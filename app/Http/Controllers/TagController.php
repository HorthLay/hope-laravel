<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
   // ──────────────────────────────────────────────────────────────────────
    //  INDEX  GET /admin/tags
    // ──────────────────────────────────────────────────────────────────────
    public function index()
    {
        $tags = Tag::withCount('articles')
            ->ordered()
            ->paginate(20);

        return view('admin.tags.index', compact('tags'));
    }

    // ──────────────────────────────────────────────────────────────────────
    //  STORE  POST /admin/tags
    // ──────────────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:100|unique:tags,name',
            'color'     => 'required|regex:/^#[0-9a-fA-F]{6}$/',
            'style'     => 'required|in:pill,solid,outline,soft,minimal',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        Tag::create($validated);

        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag "' . $validated['name'] . '" created.');
    }

    // ──────────────────────────────────────────────────────────────────────
    //  UPDATE  PUT /admin/tags/{tag}
    // ──────────────────────────────────────────────────────────────────────
    public function update(Request $request, Tag $tag)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:100|unique:tags,name,' . $tag->id,
            'color'     => 'required|regex:/^#[0-9a-fA-F]{6}$/',
            'style'     => 'required|in:pill,solid,outline,soft,minimal',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $tag->update($validated);

        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag "' . $tag->name . '" updated.');
    }

    // ──────────────────────────────────────────────────────────────────────
    //  DESTROY  DELETE /admin/tags/{tag}
    // ──────────────────────────────────────────────────────────────────────
    public function destroy(Tag $tag)
    {
        $name = $tag->name;

        // Detach from all articles before deleting
        $tag->articles()->detach();
        $tag->delete();

        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag "' . $name . '" deleted.');
    }
}
