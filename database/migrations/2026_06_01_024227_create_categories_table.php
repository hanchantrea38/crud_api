<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();                                    // Unique Auto-increment Key
            $table->string('name');                          // Category Title (Required)
            $table->text('desc')->nullable()->change();                     // Detailed Text (Required)
            $table->boolean('is_active')->default(true);     // Toggle Active/Inactive Status
            $table->timestamps();                            // created_at & updated_at
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
