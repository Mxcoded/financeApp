@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Uploaded Files</h1>

    <a href="{{ route('files.create') }}" class="btn btn-success mb-3">Upload New File</a>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>File Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($files as $file)
            <tr>
                <td>{{ $file->id }}</td>
                <td>{{ $file->file_name }}</td>
                <td>
                    <a href="{{ route('files.download', $file->id) }}" class="btn btn-primary">Download</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
