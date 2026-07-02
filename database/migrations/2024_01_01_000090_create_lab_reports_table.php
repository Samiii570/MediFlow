<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lab_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')->constrained('lab_tests')->cascadeOnDelete();
            $table->string('report_file')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lab_reports');
    }
};
