<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FamilyController extends Controller
{
       public function index(Request $request)
    {
        $query = Family::with(['sponsors', 'media', 'documents'])->latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q
                ->where('name',    'like', "%$s%")
                ->orWhere('code',  'like', "%$s%")
                ->orWhere('country','like',"%$s%")
            );
        }
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        $families = $query->paginate(12)->withQueryString();

        $stats = [
            'total'     => Family::count(),
            'active'    => Family::where('is_active', true)->count(),
            'inactive'  => Family::where('is_active', false)->count(),
            'sponsored' => Family::has('sponsors')->count(),
        ];

        return view('admin.families.index', compact('families', 'stats'));
    }

    public function create()
    {
        $sponsors = Sponsor::where('is_active', true)
                        ->orderBy('first_name')
                        ->get(['id', 'first_name', 'last_name', 'email']);

        return view('admin.families.create', compact('sponsors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'code'          => 'nullable|string|max:50|unique:families,code',
            'country'       => 'nullable|string|max:100',
            'story'         => 'nullable|string',
            'is_active'     => 'nullable|boolean',
            'profile_photo' => 'nullable|image|max:2048',
            'sponsors'      => 'nullable|array',
            'sponsors.*'    => 'exists:sponsors,id',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);
        if (empty($data['code'])) {
            $data['code'] = 'FM-' . strtoupper(Str::random(6));
        }

        unset($data['profile_photo'], $data['sponsors']);
        $family = Family::create($data);

        $family->sponsors()->sync($request->input('sponsors', []));

        if ($request->hasFile('profile_photo')) {
            $this->handleImageUpload($family, $request->file('profile_photo'));
        }

        return redirect()->route('admin.families.index')
            ->with('success', "Family \"{$family->name}\" created!");
    }

    public function show(Family $family)
    {
        $family->load(['sponsors', 'media', 'documents', 'updates']);
        return view('admin.families.show', compact('family'));
    }

    public function edit(Family $family)
    {
        $family->load(['sponsors', 'media', 'documents']);

        $sponsors = Sponsor::where('is_active', true)
                        ->orderBy('first_name')
                        ->get(['id', 'first_name', 'last_name', 'email']);

        return view('admin.families.edit', compact('family', 'sponsors'));
    }

    public function update(Request $request, Family $family)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'code'          => 'nullable|string|max:50|unique:families,code,' . $family->id,
            'country'       => 'nullable|string|max:100',
            'story'         => 'nullable|string',
            'is_active'     => 'nullable|boolean',
            'profile_photo' => 'nullable|image|max:2048',
            'remove_photo'  => 'nullable|boolean',
            'sponsors'      => 'nullable|array',
            'sponsors.*'    => 'exists:sponsors,id',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $family->sponsors()->sync($request->input('sponsors', []));

        if ($request->boolean('remove_photo') && $family->profile_photo) {
            $this->deletePhoto($family);
            $data['profile_photo'] = null;
        }
        if ($request->hasFile('profile_photo')) {
            $this->deletePhoto($family);
            $this->handleImageUpload($family, $request->file('profile_photo'));
        }

        unset($data['profile_photo'], $data['sponsors'], $data['remove_photo']);
        $family->update($data);

        return redirect()->route('admin.families.show', $family)
            ->with('success', "Family \"{$family->name}\" updated!");
    }

    public function destroy(Family $family)
    {
        $name = $family->name;
        $family->sponsors()->detach();
        // Delete media & doc files
        foreach ($family->media as $m) {
            @unlink(public_path($m->file_path));
            $m->delete();
        }
        foreach ($family->documents as $d) {
            @unlink(public_path($d->file_path));
            $d->delete();
        }
        $this->deletePhoto($family);
        $family->delete();

        return redirect()->route('admin.families.index')
            ->with('success', "Family \"{$name}\" deleted.");
    }

    // ── Helpers ──────────────────────────────────────────────────────

    protected function handleImageUpload(Family $family, $file): void
    {
        $path = public_path('uploads/families');
        if (!File::exists($path)) File::makeDirectory($path, 0755, true);

        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $file->move($path, $filename);
        $family->update(['profile_photo' => 'uploads/families/' . $filename]);
    }

    protected function deletePhoto(Family $family): void
    {
        if ($family->profile_photo) @unlink(public_path($family->profile_photo));
    }
}
