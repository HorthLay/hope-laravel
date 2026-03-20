<?php

namespace App\Http\Controllers;

use App\Models\DonationProject;
use Illuminate\Http\Request;

class ProjectAdminController extends Controller
{
       public function index()
    {
        $projects = DonationProject::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.donation-projects.index', compact('projects'));
    }
 
    public function create()
    {
        return view('admin.donation-projects.form', ['project' => new DonationProject]);
    }
 
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'title_en'               => 'required|string|max:255',
            'title_fr'               => 'nullable|string|max:255',
            'title_km'               => 'nullable|string|max:255',
            'description_en'         => 'nullable|string',
            'description_fr'         => 'nullable|string',
            'description_km'         => 'nullable|string',
            'helloasso_widget_url'   => 'nullable|url',
            'helloasso_counter_url'  => 'nullable|url',
            'helloasso_vignette_url' => 'nullable|url',
            'image'                  => 'nullable|image|max:3072',
            'tags'                   => 'nullable|string',
            'badge_label'            => 'nullable|string|max:60',
            'badge_color'            => 'nullable|in:orange,green,blue,gray',
            'is_active'              => 'nullable|boolean',
            'sort_order'             => 'nullable|integer',
        ]);
 
        if ($request->hasFile('image')) {
            $data['image'] = $this->handleImageUpload($request->file('image'));
        }
 
        $data['tags']      = $this->parseTags($request->input('tags', ''));
        $data['is_active'] = $request->boolean('is_active', true);
 
        DonationProject::create($data);
 
        return redirect()->route('admin.donation-projects.index')
                         ->with('success', 'Project created successfully.');
    }
 
    public function edit(DonationProject $donationProject)
    {
        return view('admin.donation-projects.form', ['project' => $donationProject]);
    }
 
    public function update(Request $request, DonationProject $donationProject)
    {
        $data = $this->validate($request, [
            'title_en'               => 'required|string|max:255',
            'title_fr'               => 'nullable|string|max:255',
            'title_km'               => 'nullable|string|max:255',
            'description_en'         => 'nullable|string',
            'description_fr'         => 'nullable|string',
            'description_km'         => 'nullable|string',
            'helloasso_widget_url'   => 'nullable|url',
            'helloasso_counter_url'  => 'nullable|url',
            'helloasso_vignette_url' => 'nullable|url',
            'image'                  => 'nullable|image|max:3072',
            'tags'                   => 'nullable|string',
            'badge_label'            => 'nullable|string|max:60',
            'badge_color'            => 'nullable|in:orange,green,blue,gray',
            'is_active'              => 'nullable|boolean',
            'sort_order'             => 'nullable|integer',
        ]);
 
        if ($request->hasFile('image')) {
            // Delete old file from public/
            if ($donationProject->image) {
                $oldPath = public_path($donationProject->image);
                if (file_exists($oldPath)) @unlink($oldPath);
            }
            $data['image'] = $this->handleImageUpload($request->file('image'));
        }
 
        $data['tags']      = $this->parseTags($request->input('tags', ''));
        $data['is_active'] = $request->boolean('is_active', false);
 
        $donationProject->update($data);
 
        return redirect()->route('admin.donation-projects.index')
                         ->with('success', 'Project updated successfully.');
    }
 
    public function destroy(DonationProject $donationProject)
    {
        if ($donationProject->image) {
            $path = public_path($donationProject->image);
            if (file_exists($path)) @unlink($path);
        }
        $donationProject->delete();
 
        return back()->with('success', 'Project deleted.');
    }
 
    public function reorder(Request $request)
    {
        foreach ($request->input('order', []) as $index => $id) {
            DonationProject::where('id', $id)->update(['sort_order' => $index]);
        }
        return response()->json(['ok' => true]);
    }
 
    /* ── Helpers ── */
 
    /**
     * Save uploaded image to public/uploads/projects/ (no Storage symlink needed).
     * Returns the relative path usable with asset(), e.g. "uploads/projects/abc.jpg"
     */
    private function handleImageUpload(\Illuminate\Http\UploadedFile $file): string
    {
        $dir = public_path('uploads/projects');
        if (!is_dir($dir)) mkdir($dir, 0755, true);
 
        $filename = uniqid('proj_') . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $filename);
 
        return 'uploads/projects/' . $filename;
    }
 
    private function parseTags(string $raw): array
    {
        return array_values(array_filter(array_map('trim', explode(',', $raw))));
    }
}
