// database/migrations/2024_01_01_000002_create_residents_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix')->nullable();
            $table->date('birth_date');
            $table->enum('gender', ['Male', 'Female']);
            $table->string('civil_status');
            $table->string('sitio');
            $table->string('street_address');
            $table->string('household_number');
            $table->string('contact_number')->nullable();
            $table->string('occupation')->nullable();
            $table->string('religion')->nullable();
            $table->string('citizenship')->default('Filipino');
            $table->string('photo')->nullable();
            $table->boolean('is_head_of_family')->default(false);
            $table->foreignId('family_head_id')->nullable()->constrained('residents');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};