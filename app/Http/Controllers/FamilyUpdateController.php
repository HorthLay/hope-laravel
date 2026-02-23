<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\FamilyUpdate;
use Illuminate\Http\Request;

class FamilyUpdateController extends Controller
{
     public function store(Request $request, Family $family)
    {
        $request->validate([
            'title'       => 'nullable|string|max:255',
            'content'     => 'required|string',
            'type'        => 'nullable|string|max:100',
            'report_date' => 'nullable|date',
        ]);

        $family->updates()->create($request->only('title', 'content', 'type', 'report_date'));

        return back()->with('success', 'Update added successfully.');
    }

    public function destroy(Family $family, FamilyUpdate $update)
    {
        abort_if($update->family_id !== $family->id, 403);

        $update->delete();

        return back()->with('success', 'Update deleted.');
    }
}
