<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();  // Auto-increment primary key
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade'); // Foreign key with cascade delete
            $table->string('address');
            $table->string('district');
            $table->string('city');
            $table->string('province'); 
            $table->integer('postal_code'); 
            $table->timestamps(); // Automatically creates 'created_at' & 'updated_at'
        });
    }

    public function down(): void {
        Schema::dropIfExists('addresses'); 
    }
};
