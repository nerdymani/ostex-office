<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('client_name')->nullable();
            $table->text('description')->nullable();
            $table->string('department')->default('Operations');
            $table->foreignId('manager_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['planning','active','on_hold','completed','cancelled'])->default('planning');
            $table->enum('priority', ['low','medium','high','urgent'])->default('medium');
            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->decimal('budget', 12, 2)->nullable();
            $table->string('currency')->default('TZS');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('projects'); }
};
