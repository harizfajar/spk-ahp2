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
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->string('nik',16)->unique();
            $table->string('nama', 100);
            $table->enum('kelamin', ['Male', 'Female']);
            $table->date('birth_date');
            $table->string('birth_place', 100);
            $table->text('alamat');
            $table->string('agama', 50)->nullable();
            $table->enum('marital_status', ['Married', 'Single']);
            $table->string('pekerjaan', 100)->nullable();
            $table->string('phone', 20)->nullable();
            $table->enum('status', ['Pindahan', 'Almarhum', 'Aktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};
