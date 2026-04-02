<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('job_postings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('department');
            $table->enum('type', ['full_time','part_time','contract','internship']);
            $table->longText('description');
            $table->text('requirements')->nullable();
            $table->string('salary_range')->nullable();
            $table->date('deadline')->nullable();
            $table->enum('status', ['draft','open','closed'])->default('draft');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('job_postings'); }
};
