<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\Sponsor;
use App\Models\SponsoredChild;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SponsorAdminController extends Controller
{
     // ─────────────────────────────────────────────────────────────────
    //  INDEX
    // ─────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Sponsor::with('children', 'families')->latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('first_name', 'like', "%$s%")
                  ->orWhere('last_name',  'like', "%$s%")
                  ->orWhere('email',      'like', "%$s%")
                  ->orWhere('username',   'like', "%$s%");
            });
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        $sponsors = $query->paginate(15)->withQueryString();

        $stats = [
            'total'         => Sponsor::count(),
            'active'        => Sponsor::where('is_active', true)->count(),
            'inactive'      => Sponsor::where('is_active', false)->count(),
            'with_children' => Sponsor::has('children')->count(),
        ];

        return view('admin.sponsors.index', compact('sponsors', 'stats'));
    }

    // ─────────────────────────────────────────────────────────────────
    //  CREATE
    // ─────────────────────────────────────────────────────────────────
    public function create()
    {
        $children = SponsoredChild::where('is_active', true)
                        ->orderBy('first_name')
                        ->get(['id', 'first_name', 'code', 'profile_photo']);

        $families = Family::where('is_active', true)
                        ->orderBy('name')
                        ->get(['id', 'name', 'code', 'profile_photo']);

        return view('admin.sponsors.create', compact('children', 'families'));
    }

    // ─────────────────────────────────────────────────────────────────
    //  STORE
    // ─────────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'  => 'required|string|max:255',
            'last_name'   => 'required|string|max:255',
            'email'       => 'required|email|unique:sponsors,email',
            'username'    => 'required|string|max:100|unique:sponsors,username',
            'password'    => 'required|string|min:8|confirmed',
            'is_active'   => 'nullable|boolean',
            'children'    => 'nullable|array',
            'children.*'  => 'exists:sponsored_children,id',
            'families'    => 'nullable|array',
            'families.*'  => 'exists:families,id',
        ]);

        $sponsor = Sponsor::create([
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'email'      => $validated['email'],
            'username'   => $validated['username'],
            'password'   => Hash::make($validated['password']),
            'is_active'  => $request->boolean('is_active', true),
        ]);

        $sponsor->children()->sync($request->input('children', []));
        $sponsor->families()->sync($request->input('families', []));

        return redirect()
            ->route('admin.sponsors.index')
            ->with('success', "Sponsor \"{$sponsor->full_name}\" created successfully!");
    }

    // ─────────────────────────────────────────────────────────────────
    //  SHOW
    // ─────────────────────────────────────────────────────────────────
    public function show(Sponsor $sponsor)
    {
        $sponsor->load('children', 'families');

        return view('admin.sponsors.show', compact('sponsor'));
    }

    // ─────────────────────────────────────────────────────────────────
    //  EDIT
    // ─────────────────────────────────────────────────────────────────
    public function edit(Sponsor $sponsor)
    {
        $sponsor->load('children', 'families');

        $children = SponsoredChild::where('is_active', true)
                        ->orderBy('first_name')
                        ->get(['id', 'first_name', 'code', 'profile_photo']);

        $families = Family::where('is_active', true)
                        ->orderBy('name')
                        ->get(['id', 'name', 'code', 'profile_photo']);

        return view('admin.sponsors.edit', compact('sponsor', 'children', 'families'));
    }

    // ─────────────────────────────────────────────────────────────────
    //  UPDATE
    // ─────────────────────────────────────────────────────────────────
    public function update(Request $request, Sponsor $sponsor)
    {
        $validated = $request->validate([
            'first_name'  => 'required|string|max:255',
            'last_name'   => 'required|string|max:255',
            'email'       => 'required|email|unique:sponsors,email,' . $sponsor->id,
            'username'    => 'required|string|max:100|unique:sponsors,username,' . $sponsor->id,
            'password'    => 'nullable|string|min:8|confirmed',
            'is_active'   => 'nullable|boolean',
            'children'    => 'nullable|array',
            'children.*'  => 'exists:sponsored_children,id',
            'families'    => 'nullable|array',
            'families.*'  => 'exists:families,id',
        ]);

        $updateData = [
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'email'      => $validated['email'],
            'username'   => $validated['username'],
            'is_active'  => $request->boolean('is_active'),
        ];

        if (! empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $sponsor->update($updateData);
        $sponsor->children()->sync($request->input('children', []));
        $sponsor->families()->sync($request->input('families', []));

        return redirect()
            ->route('admin.sponsors.show', $sponsor)
            ->with('success', "Sponsor \"{$sponsor->full_name}\" updated successfully!");
    }

    // ─────────────────────────────────────────────────────────────────
    //  DESTROY
    // ─────────────────────────────────────────────────────────────────
    public function destroy(Sponsor $sponsor)
    {
        $name = $sponsor->full_name;
        $sponsor->children()->detach();
        $sponsor->families()->detach();
        $sponsor->delete();

        return redirect()
            ->route('admin.sponsors.index')
            ->with('success', "Sponsor \"{$name}\" deleted successfully!");
    }
}
