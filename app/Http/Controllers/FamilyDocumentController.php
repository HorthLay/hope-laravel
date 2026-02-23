<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\FamilyDocument;
use Illuminate\Http\Request;

class FamilyDocumentController extends Controller
{
        public function store(Request $request, Family $family)
    {
        if ($request->hasFile('file') && !$request->file('file')->isValid()) {
            return back()->withErrors(['file' => 'File upload failed: ' . $this->uploadErrorMessage($request->file('file')->getError())])->withInput();
        }
    
        $request->validate([
            'file'          => 'required|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240',
            'title'         => 'required|string|max:255',
            'type'          => 'nullable|string|max:100',
            'document_date' => 'nullable|date',
        ]);

        $file   = $request->file('file');
        $folder = public_path("uploads/families/{$family->id}/documents");

        if (!is_dir($folder) && !mkdir($folder, 0755, true) && !is_dir($folder)) {
            return back()->with('error', 'Could not create upload directory: ' . $folder);
        }

        $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());

        try {
            $file->move($folder, $filename);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to move uploaded file: ' . $e->getMessage());
        }

        $family->documents()->create([
            'title'         => $request->title,
            'type'          => $request->type,
            'file_path'     => "uploads/families/{$family->id}/documents/{$filename}",
            'document_date' => $request->document_date,
        ]);

        return back()->with('success', 'Document uploaded successfully.');
    }

    public function destroy(Family $family, FamilyDocument $document)
    {
        abort_if($document->family_id !== $family->id, 403);

        $fullPath = public_path($document->file_path);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }

        $document->delete();

        return back()->with('success', 'Document deleted.');
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
