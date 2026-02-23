<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\FamilyMedia;
use Illuminate\Http\Request;

class FamilyMediaController extends Controller
{
        public function store(Request $request, Family $family)
    {
        if ($request->hasFile('file') && !$request->file('file')->isValid()) {
            return back()->withErrors(['file' => 'File upload failed: ' . $this->uploadErrorMessage($request->file('file')->getError())])->withInput();
        }

        $request->validate([
            'file'       => 'required|file|mimes:jpg,jpeg,png,gif,webp,mp4,mov|max:20480',
            'caption'    => 'nullable|string|max:255',
            'taken_date' => 'nullable|date',
        ]);

        $file   = $request->file('file');
        $folder = public_path("uploads/families/{$family->id}/media");

        if (!is_dir($folder) && !mkdir($folder, 0755, true) && !is_dir($folder)) {
            return back()->with('error', 'Could not create upload directory: ' . $folder);
        }

        $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());

        try {
            $file->move($folder, $filename);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to move uploaded file: ' . $e->getMessage());
        }

        $type = in_array(strtolower($file->getClientOriginalExtension()), ['mp4', 'mov']) ? 'video' : 'photo';

        $family->media()->create([
            'type'       => $type,
            'file_path'  => "uploads/families/{$family->id}/media/{$filename}",
            'caption'    => $request->caption,
            'taken_date' => $request->taken_date,
        ]);

        return back()->with('success', 'Media uploaded successfully.');
    }

    public function destroy(Family $family, FamilyMedia $media)
    {
        abort_if($media->family_id !== $family->id, 403);

        $fullPath = public_path($media->file_path);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }

        $media->delete();

        return back()->with('success', 'Media deleted.');
    }

    private function uploadErrorMessage(int $code): string
    {
        return match ($code) {
            UPLOAD_ERR_INI_SIZE   => 'File exceeds upload_max_filesize in php.ini (' . ini_get('upload_max_filesize') . ').',
            UPLOAD_ERR_FORM_SIZE  => 'File exceeds MAX_FILE_SIZE in the HTML form.',
            UPLOAD_ERR_PARTIAL    => 'File was only partially uploaded.',
            UPLOAD_ERR_NO_FILE    => 'No file was uploaded.',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing temp folder. Set upload_tmp_dir in php.ini.',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk. Check temp folder permissions.',
            UPLOAD_ERR_EXTENSION  => 'A PHP extension stopped the upload.',
            default               => "Unknown upload error (code {$code}).",
        };
    }
}
