<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sales_targets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('department')->default('Sales');
            $table->string('period');
            $table->decimal('target_amount', 12, 2);
            $table->decimal('actual_amount', 12, 2)->default(0);
            $table->string('currency')->default('TZS');
            $table->string('metric')->default('Revenue');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('sales_targets'); }
};
