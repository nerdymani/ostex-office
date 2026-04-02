<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('kpi_records', function (Blueprint $table) {
            $table->id();
            $table->string('department');
            $table->string('metric_name');
            $table->string('metric_value');
            $table->string('target_value')->nullable();
            $table->string('period');
            $table->text('notes')->nullable();
            $table->foreignId('recorded_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('kpi_records'); }
};
