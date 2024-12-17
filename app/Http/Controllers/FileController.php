<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    // Display all files with pagination and sorting
    public function index(Request $request)
    {
        // Fetch and filter files based on search query
        $search = $request->input('search');

        // Fetch paginated files, sorting by upload time
        $files = File::query()
            ->when($search, function ($query, $search) {
                return $query->where('file_name', 'like', "%{$search}%")
                    ->orWhere('uploader', 'like', "%{$search}%");
            })
            ->orderBy('uploaded_at', 'desc') // Sorting files by upload time in descending order
            ->paginate(5); // Paginate with 10 items per page

        return view('file.index', compact('files', 'search'));
    }

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

    // Show file upload form
    public function create()
    {
        return view('file.create'); // Ensure you have this view file
    }

    // Download file
    public function download($id)
    {
        $file = File::findOrFail($id);
        return Storage::disk('public')->download($file->file_path, $file->file_name); // Return file for download
    }

    // Destroy file (delete it from both storage and database)
    public function destroy($id)
    {
        $file = File::findOrFail($id);

        // Delete the file from storage
        Storage::disk('public')->delete($file->file_path);

        // Delete the file record from the database
        $file->delete();

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'File deleted successfully.'
        ]);
    }


    // Mass delete selected files
    public function massDelete(Request $request)
    {
        $fileIds = $request->input('file_ids');

        if ($fileIds) {
            // Fetch the files to delete
            $files = File::whereIn('id', $fileIds)->get();

            // Delete files from storage
            foreach ($files as $file) {
                Storage::disk('public')->delete($file->file_path);
                $file->delete(); // Delete the file record from the database
            }

            return redirect()->route('files.index')->with('success', 'Files deleted successfully.');
        }

        return redirect()->route('files.index')->with('error', 'No files selected.');
    }
}