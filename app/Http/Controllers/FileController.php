<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Display a list of uploaded files with search functionality.
     */
    public function index(Request $request)
    {
        // Search query
        $search = $request->input('search');

        // Fetch files with optional search filter
        $files = File::when($search, function ($query, $search) {
            return $query->where('file_name', 'like', "%$search%");
        })
            ->latest()
            ->paginate(10);

        return view('file.index', compact('files'));
    }

    /**
     * Show the file upload form.
     */
    public function create()
    {
        return view('file.create');
    }

    /**
     * Store the uploaded files in storage and database.
     */
    public function store(Request $request)
    {
        // Validate the uploaded files
        $request->validate([
            'files.*' => 'required|file|max:10240', // Max 10MB per file
        ]);

        $uploadedFiles = $request->file('files');

        if (!empty($uploadedFiles)) {
            foreach ($uploadedFiles as $uploadedFile) {
                // Store the file in 'uploads' folder within 'public' disk
                $filePath = $uploadedFile->store('uploads', 'public');

                // Save file details to the database
                File::create([
                    'file_name' => $uploadedFile->getClientOriginalName(),
                    'file_size' => $uploadedFile->getSize(),
                    'file_path' => $filePath, // Save the path to 'file_path' column
                    'uploader' => auth()->user()->name ?? 'Anonymous',
                    'uploaded_at' => now(),
                ]);
            }
        }

        return redirect()->route('files.index')
        ->with('success', 'Files uploaded successfully!');
    }


    /**
     * Download a specific file.
     */
    /**
     * Download a specific file by its ID.
     */
    public function download($id)
    {
        // Fetch the file record from the database using its ID
        $file = File::find($id);

        // Check if the file record exists
        if (!$file) {
            return redirect()->route('files.index')
            ->with('error', 'File not found in the database.');
        }

        // Check if the file exists in storage
        if ($file->file_path && Storage::disk('public')->exists($file->file_path)) {
            return Storage::disk('public')->download($file->file_path, $file->file_name);
        }

        // Return an error if the file is missing from storage
        return redirect()->route('files.index')
        ->with('error', 'File not found in storage.');
    }


    /**
     * Delete a single file from storage and database.
     */
    public function destroy($id)
    {
        // Fetch the file record from the database
        $file = File::find($id);

        if (!$file) {
            return redirect()->back()->with('error', 'File not found.');
        }

        // Get the file path from the database
        $filePath = $file->file_path;

        if ($filePath && Storage::disk('public')->exists($filePath)) {
            // Delete the file from storage
            Storage::disk('public')->delete($filePath);
        }

        // Delete the record from the database
        $file->delete();

        return redirect()->route('files.index')
            ->with('success', 'File deleted successfully.');
    }

    /**
     * Delete multiple selected files.
     */
    public function massDelete(Request $request)
    {
        // Validate the file IDs
        $request->validate([
            'file_ids' => 'required|array',
            'file_ids.*' => 'exists:files,id',
        ]);

        // Fetch files to delete
        $files = File::whereIn('id', $request->file_ids)->get();

        foreach ($files as $file) {
            // Check and delete from storage
            if (Storage::disk('public')->exists($file->file_path)) {
                Storage::disk('public')->delete($file->file_path);
            }

            // Delete the record from the database
            $file->delete();
        }

        return redirect()->route('files.index')
            ->with('success', 'Selected files deleted successfully.');
    }
}
