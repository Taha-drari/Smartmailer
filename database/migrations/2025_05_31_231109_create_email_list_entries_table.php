<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('email_list_entries', function (Blueprint $table) {
        $table->id();
        $table->foreignId('email_list_id')->constrained()->onDelete('cascade');
        $table->string('email');
        $table->boolean('is_valid')->default(false); // For validation API
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_list_entries');
    }
};
