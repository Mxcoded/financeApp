<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    // Show upload form
    public function create()
    {
        return view('file.create');
    }

    // Handle file upload
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:2048', // Limit to 2MB
        ]);

        // Save the file
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads', 'public');

            File::create([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
            ]);

            return back()->with('success', 'File uploaded successfully.');
        }

        return back()->with('error', 'File upload failed.');
    }

    // Download a file
    public function download($id)
    {
        $file = File::findOrFail($id);

        return Storage::disk('public')->download($file->file_path, $file->file_name);
    }

    // List all uploaded files
    public function index()
    {
        $files = File::all();

        return view('file.index', compact('files'));
    }
}
