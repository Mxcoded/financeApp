<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Display the file upload form.
     */
    public function create()
    {
        return view('file.create');
    }

    /**
     * Handle file upload and store in the database.
     */
    public function store(Request $request)
    {
        // Validate the uploaded file (2MB max size)
        $request->validate([
            'file' => 'required|file|max:2048',
        ]);

        // Check if a file is uploaded
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Store the file in the 'public/uploads' directory
            $path = $file->store('uploads', 'public');

            // Save file details to the database
            File::create([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
            ]);

            return redirect()->back()->with('success', 'File uploaded successfully.');
        }

        return redirect()->back()->with('error', 'File upload failed. Please try again.');
    }

    /**
     * Download the specified file.
     */
    public function download($id)
    {
        // Retrieve the file record by ID
        $file = File::findOrFail($id);

        // Return the file for download
        return Storage::disk('public')->download($file->file_path, $file->file_name);
    }

    /**
     * Display a list of all uploaded files.
     */
    public function index()
    {
        // Fetch all uploaded files from the database
        $files = File::all();

        return view('file.index', compact('files'));
    }
}