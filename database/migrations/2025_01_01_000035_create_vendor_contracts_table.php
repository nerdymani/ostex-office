<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('vendor_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('value', 12, 2)->nullable();
            $table->string('currency')->default('TZS');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->enum('status', ['active','expired','terminated'])->default('active');
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('vendor_contracts'); }
};
