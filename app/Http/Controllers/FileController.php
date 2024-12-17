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
            ->paginate(5);

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
     * Store the uploaded file in storage and database.
     */
    // Store uploaded file
    public function store(Request $request)
    {
        // Validate the uploaded files
        $request->validate([
            'files.*' => 'required|file|max:20048', // Max file size: 20MB for each file
        ]);

        $files = $request->file('files');
        foreach ($files as $file) {
            // Store file and get its path and size
            $path = $file->store('uploads', 'public');
            $size = $file->getSize();
            $isPdf = $file->getClientOriginalExtension() === 'pdf'; // Check if the file is PDF

            // Store file details in DB
            File::create([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_size' => $size,
                'uploader' => auth()->user()->name ?? 'Unknown', // Get the uploader's name
                'uploaded_at' => now(),
                'is_pdf' => $isPdf, // Mark if the file is a PDF
            ]);
        }

        return back()->with('success', 'Files uploaded successfully.');
    }

    /**
     * Download a specific file.
     */
    public function download(File $file)
    {
        // Check if file exists in storage
        if (Storage::disk('public')->exists($file->file_path)) {
            return Storage::disk('public')->download($file->file_path, $file->file_name);
        }

        return redirect()->route('files.index')
            ->with('error', 'File not found.');
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
