<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    // Display all files with enhanced data
    public function index(Request $request)
    {
        // Fetch and filter files
        $search = $request->input('search');
        $files = File::query()
            ->when($search, function ($query, $search) {
                return $query->where('file_name', 'like', "%{$search}%")
                    ->orWhere('uploader', 'like', "%{$search}%");
            })
            ->orderBy('uploaded_at', 'desc')
            ->get();

        return view('file.index', compact('files', 'search'));
    }

    // Store uploaded file
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:2048', // Max file size: 2MB
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads', 'public');
            $size = $file->getSize();
            $isPdf = $file->getClientOriginalExtension() === 'pdf';

            // Store file details in DB
            File::create([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_size' => $size,
                'uploader' => auth()->user()->name ?? 'Unknown',
                'uploaded_at' => now(),
                'is_pdf' => $isPdf,
            ]);

            return back()->with('success', 'File uploaded successfully.');
        }

        return back()->with('error', 'File upload failed.');
    }

    // Download file
    public function download($id)
    {
        $file = File::findOrFail($id);
        return Storage::disk('public')->download($file->file_path, $file->file_name);
    }
}
