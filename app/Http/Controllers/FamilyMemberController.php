<?php

namespace App\Http\Controllers;
use App\Models\FamilyMember;
use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
class FamilyMemberController extends Controller
{
        const RELATIONSHIPS = [
        'Father', 'Mother', 'Son', 'Daughter',
        'Guardian', 'Grandfather', 'Grandmother',
        'Uncle', 'Aunt', 'Brother', 'Sister', 'Other',
    ];

    // ─────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = FamilyMember::with('family')->latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q
                ->where('name',         'like', "%$s%")
                ->orWhere('relationship','like', "%$s%")
                ->orWhere('email',      'like', "%$s%")
                ->orWhere('phone',      'like', "%$s%")
            );
        }
        if ($request->filled('family_id')) {
            $query->where('family_id', $request->family_id);
        }
        if ($request->filled('relationship')) {
            $query->where('relationship', $request->relationship);
        }
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        $members  = $query->paginate(15)->withQueryString();
        $families = Family::orderBy('name')->get(['id', 'name']);
        $stats = [
            'total'    => FamilyMember::count(),
            'active'   => FamilyMember::where('is_active', true)->count(),
            'inactive' => FamilyMember::where('is_active', false)->count(),
            'families' => FamilyMember::distinct('family_id')->count('family_id'),
        ];

        return view('admin.family-members.index', compact('members', 'families', 'stats'));
    }

    // ─────────────────────────────────────────────────────────────────
    public function create(Request $request)
    {
        $families = Family::where('is_active', true)->orderBy('name')
                        ->get(['id', 'name', 'code', 'country', 'profile_photo']);

        // Pre-select a family if coming from a family page
        $selectedFamily = $request->filled('family_id')
            ? Family::find($request->family_id)
            : null;

        return view('admin.family-members.create', [
            'families'      => $families,
            'selectedFamily'=> $selectedFamily,
            'relationships' => self::RELATIONSHIPS,
        ]);
    }

    // ─────────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $data = $request->validate([
            'family_id'     => 'required|exists:families,id',
            'name'          => 'required|string|max:255',
            'relationship'  => 'required|string|max:100',
            'phone'         => 'nullable|string|max:30',
            'email'         => 'nullable|email|max:255',
            'is_active'     => 'nullable|boolean',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);
        unset($data['profile_photo']);

        $member = FamilyMember::create($data);

        if ($request->hasFile('profile_photo')) {
            $this->handleImageUpload($member, $request->file('profile_photo'));
        }

        // Redirect back to family if came from there
        if ($request->filled('redirect_to_family')) {
            return redirect()->route('admin.families.show', $member->family_id)
                ->with('success', "{$member->name} added to the family!");
        }

        return redirect()->route('admin.family-members.show', $member)
            ->with('success', "Family member \"{$member->name}\" created!");
    }

    // ─────────────────────────────────────────────────────────────────
    public function show(FamilyMember $member)
    {
        $member->load('family');
        return view('admin.family-members.show', compact('member'));
    }

    // ─────────────────────────────────────────────────────────────────
    public function edit(FamilyMember $member)
    {
        $member->load('family');
        $families = Family::where('is_active', true)->orderBy('name')
                        ->get(['id', 'name', 'code', 'country', 'profile_photo']);

        return view('admin.family-members.edit', [
            'member'        => $member,
            'families'      => $families,
            'relationships' => self::RELATIONSHIPS,
        ]);
    }

    // ─────────────────────────────────────────────────────────────────
    public function update(Request $request, FamilyMember $member)
    {
        $data = $request->validate([
            'family_id'     => 'required|exists:families,id',
            'name'          => 'required|string|max:255',
            'relationship'  => 'required|string|max:100',
            'phone'         => 'nullable|string|max:30',
            'email'         => 'nullable|email|max:255',
            'is_active'     => 'nullable|boolean',
            'profile_photo' => 'nullable|image|max:2048',
            'remove_photo'  => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        if ($request->boolean('remove_photo') && $member->profile_photo) {
            $this->deletePhoto($member);
            $data['profile_photo'] = null;
        }
        if ($request->hasFile('profile_photo')) {
            $this->deletePhoto($member);
            $this->handleImageUpload($member, $request->file('profile_photo'));
        }

        unset($data['profile_photo'], $data['remove_photo']);
        $member->update($data);

        return redirect()->route('admin.family-members.show', $member)
            ->with('success', "\"{$member->name}\" updated!");
    }

    // ─────────────────────────────────────────────────────────────────
    public function destroy(FamilyMember $member)
    {
        $familyId = $member->family_id;
        $name     = $member->name;
        $this->deletePhoto($member);
        $member->delete();

        // If deleted from family show page, go back there
        if (request('redirect_to_family')) {
            return redirect()->route('admin.families.show', $familyId)
                ->with('success', "\"{$name}\" removed from family.");
        }

        return redirect()->route('admin.family-members.index')
            ->with('success', "\"{$name}\" deleted.");
    }

    // ── Helpers ──────────────────────────────────────────────────────
    protected function handleImageUpload(FamilyMember $member, $file): void
    {
        $path = public_path('uploads/family-members');
        if (!File::exists($path)) File::makeDirectory($path, 0755, true);

        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $file->move($path, $filename);
        $member->update(['profile_photo' => 'uploads/family-members/' . $filename]);
    }

    protected function deletePhoto(FamilyMember $member): void
    {
        if ($member->profile_photo) @unlink(public_path($member->profile_photo));
    }
}
