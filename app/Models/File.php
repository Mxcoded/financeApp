<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    // Allow mass assignment for these fields
    protected $fillable = [
        'file_name',
        'file_path',
        'file_size',
        'uploader',
        'uploaded_at',
        'is_pdf',
    ];
}
