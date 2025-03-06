<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();  // Auto-increment primary key
            $table->string('title');
            $table->string('name')->unique();
            $table->string('gender');
            $table->string('phone_number')->nullable();
            $table->string('image')->nullable(); 
            $table->string('email')->unique();
            $table->timestamps(); // Automatically creates 'created_at' & 'updated_at'
        });
    }

    public function down(): void {
        Schema::dropIfExists('customers');
    }
};
