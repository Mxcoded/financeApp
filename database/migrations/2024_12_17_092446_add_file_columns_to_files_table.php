<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('files', function (Blueprint $table) {
            $table->string('uploader')->after('file_path');
            $table->integer('file_size')->after('file_name');
            $table->boolean('is_pdf')->default(false)->after('file_size');
            $table->timestamp('uploaded_at')->nullable()->after('uploader');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('files', function (Blueprint $table) {
            $table->dropColumn(['uploader', 'file_size', 'is_pdf', 'uploaded_at']);
        });
    }
};
