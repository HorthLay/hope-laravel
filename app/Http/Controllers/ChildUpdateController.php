<?php

namespace App\Http\Controllers;

use App\Models\ChildUpdate;
use App\Models\SponsoredChild;
use Illuminate\Http\Request;

class ChildUpdateController extends Controller
{
   
    public function store(Request $request, SponsoredChild $child)
    {
        $validated = $request->validate([
            'title'       => 'nullable|string|max:255',
            'content'     => 'required|string',
            'type'        => 'nullable|string|max:100',
            'report_date' => 'nullable|date',
        ]);

        $child->updates()->create($validated);

        return back()->with('success', 'Update added successfully.');
    }

    public function destroy(SponsoredChild $child, ChildUpdate $update)
    {
        abort_if($update->child_id !== $child->id, 403);

        $update->delete();

        return back()->with('success', 'Update deleted.');
    }
}
