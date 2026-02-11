<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaUploadController extends Controller
{
    /**
     * Handle CKEditor image/media/document upload.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,webp,svg,mp4,webm,ogg,pdf,doc,docx,xls,xlsx,ppt,pptx,txt,csv,zip,rar|max:20480',
        ]);

        $file = $request->file('file');
        $path = $file->store('berita/media', 'public');
        $url  = asset('storage/' . $path);

        return response()->json([
            'url'      => $url,
            'location' => $url,
            'filename' => $file->getClientOriginalName(),
        ]);
    }
}

