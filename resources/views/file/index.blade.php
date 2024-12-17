<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
      {{ __('Uploaded Files') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <!-- Card Container -->
      <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
        <!-- Header with Search and Upload -->
        <div class="px-6 py-4 flex flex-wrap justify-between items-center border-b">
          <!-- Search Form -->
          <form method="GET" action="{{ route('files.index') }}" class="flex w-full sm:w-auto space-x-2">
            <input
              type="text"
              name="search"
              value="{{ request('search') }}"
              placeholder="Search files..."
              class="p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white px-4 py-2 rounded">
              Search
            </button>
          </form>

          <!-- Add Upload Button -->
          <a href="{{ route('files.create') }}"
             class="flex items-center bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded mt-4 sm:mt-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Add Upload
          </a>
        </div>

        <!-- Table -->
        <div class="w-full overflow-x-auto">
          <table class="w-full table-auto border-collapse">
            <thead>
              <tr class="bg-blue-100 text-gray-700 uppercase text-sm leading-normal">
                <th class="py-3 px-4 text-left">#</th>
                <th class="py-3 px-4 text-left">File Title</th>
                <th class="py-3 px-4 text-left">File Size (KB)</th>
                <th class="py-3 px-4 text-left">Uploader</th>
                <th class="py-3 px-4 text-left">Upload Time</th>
                <th class="py-3 px-4 text-left">Actions</th>
              </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
              @forelse ($files as $file)
                <tr class="border-b hover:bg-gray-50">
                  <td class="py-3 px-4">{{ $loop->iteration }}</td>
                  <td class="py-3 px-4">{{ $file->file_name }}</td>
                  <td class="py-3 px-4">{{ round($file->file_size / 1024, 2) }}</td>
                  <td class="py-3 px-4">{{ $file->uploader }}</td>
                  <td class="py-3 px-4">{{ $file->uploaded_at }}</td>
                  <td class="py-3 px-4 flex space-x-3">
                    <!-- Preview Button -->
                    @if ($file->is_pdf)
                      <a href="{{ Storage::url($file->file_path) }}" target="_blank"
                         class="text-green-600 hover:text-green-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M10 3a7 7 0 00-7 7 7 7 0 0014 0 7 7 0 00-7-7zm0 12a5 5 0 110-10 5 5 0 010 10zm-.707-6.707a1 1 0 011.414 0l1.5 1.5a1 1 0 01-1.414 1.414L10 10.414 9.207 11.5a1 1 0 01-1.414-1.414l1.5-1.5z" clip-rule="evenodd" />
                        </svg>
                      </a>
                    @endif

                    <!-- Download Button -->
                    <a href="{{ route('files.download', $file->id) }}"
                       class="text-blue-600 hover:text-blue-800">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v8a1 1 0 11-2 0V4H5v12h5a1 1 0 110 2H4a1 1 0 01-1-1V3zm7.707 8.293a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L10 13.414l2.293 2.293a1 1 0 001.414-1.414l-3-3z" clip-rule="evenodd" />
                      </svg>
                    </a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center py-6 text-gray-500">
                    No files found. Start by uploading a new file!
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
