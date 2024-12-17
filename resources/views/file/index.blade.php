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
        <!-- Header with Search, Upload, and Mass Delete -->
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

          <!-- Admin Mass Delete Button -->
          @if(auth()->user()->is_admin)
          <form action="{{ route('files.massDelete') }}" method="POST" id="massDeleteForm">
            @csrf
            <button type="submit" id="massDeleteButton" class="bg-red-600 hover:bg-red-800 text-white px-4 py-2 rounded mt-4 sm:mt-0 hidden">
              Delete Selected
            </button>
          </form>
          @endif
        </div>

        <!-- Table -->
        <div class="w-full overflow-x-auto">
          <table class="w-full table-auto border-collapse">
            <thead>
              <tr class="bg-blue-100 text-gray-700 uppercase text-sm leading-normal">
                <th class="py-3 px-4 text-left">
                  <input type="checkbox" id="selectAll" class="mr-2">
                </th>
                <th class="py-3 px-4 text-left">#</th>
                <th class="py-3 px-4 text-left">File Title</th>
                <th class="py-3 px-4 text-left">File Size (KB)</th>
                <th class="py-3 px-4 text-left">Uploader</th>
                <th class="py-3 px-4 text-left">Upload Time</th>
                <th class="py-3 px-4 text-left">Actions</th>
              </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
              <div id="progressBarContainer" style="display: none;">
    <div id="progressBar" style="width: 0%; height: 5px; background-color: #4caf50;"></div>
</div>

<div id="alertMessage" style="display: none;">
    <div class="alert alert-success" role="alert">
        <strong>Success!</strong> The file was deleted successfully.
    </div>
</div>
              @forelse ($files as $file)
                <tr class="border-b hover:bg-gray-50">
                  <td class="py-3 px-4">
                    <input type="checkbox" class="file-checkbox" value="{{ $file->id }}" name="file_ids[]">
                  </td>
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
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
</svg>

                      </a>
                    @endif

                    <!-- Download Button with new icon -->
                    <a href="{{ route('files.download', $file->id) }}"
                       class="text-blue-600 hover:text-blue-800">
                      <!-- Updated Download Icon -->
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
</svg>

                    </a>

                    <!-- Delete Icon for Individual Files (Admin Only) -->
                   @if(auth()->check())
                    <form action="{{ route('files.destroy', $file->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this file?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="text-red-600 hover:text-red-800">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
</svg>
                      </button>
                    </form>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="text-center py-6 text-gray-500">
                    No files found. Start by uploading a new file!
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
           <!-- Pagination Links -->
    <div class="px-6 py-4">
        {{ $files->links() }}
    </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Toggle Select All checkbox
    document.getElementById('selectAll').addEventListener('change', function() {
      const checkboxes = document.querySelectorAll('.file-checkbox');
      checkboxes.forEach(checkbox => checkbox.checked = this.checked);
      toggleDeleteButton();
    });

    // Toggle the mass delete button visibility based on selected checkboxes
    const checkboxes = document.querySelectorAll('.file-checkbox');
    checkboxes.forEach(checkbox => {
      checkbox.addEventListener('change', function() {
        toggleDeleteButton();
      });
    });

    function toggleDeleteButton() {
      const selectedFiles = document.querySelectorAll('.file-checkbox:checked');
      const massDeleteButton = document.getElementById('massDeleteButton');
      if (selectedFiles.length > 0) {
        massDeleteButton.classList.remove('hidden');
      } else {
        massDeleteButton.classList.add('hidden');
      }
    }
  </script>
</x-app-layout>
