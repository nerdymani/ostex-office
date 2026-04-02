<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lead_id')->nullable();
            $table->string('client_name');
            $table->string('client_email')->nullable();
            $table->string('title');
            $table->longText('body')->nullable();
            $table->decimal('amount', 12, 2)->nullable();
            $table->string('currency')->default('TZS');
            $table->date('valid_until')->nullable();
            $table->enum('status', ['draft','sent','viewed','accepted','rejected'])->default('draft');
            $table->timestamp('sent_at')->nullable();
            $table->foreignId('prepared_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('proposals'); }
};
