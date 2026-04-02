<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('onboarding_checklists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users');
            $table->boolean('contract_signed')->default(false);
            $table->boolean('id_submitted')->default(false);
            $table->boolean('equipment_issued')->default(false);
            $table->boolean('email_setup')->default(false);
            $table->boolean('system_access')->default(false);
            $table->boolean('orientation_done')->default(false);
            $table->date('probation_end')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('onboarding_checklists'); }
};
