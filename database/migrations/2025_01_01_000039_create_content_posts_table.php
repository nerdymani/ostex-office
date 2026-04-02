<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('content_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('caption');
            $table->json('media_paths')->nullable();
            $table->json('platforms');
            $table->string('post_type');
            $table->enum('status', ['idea','draft','ready','scheduled','published','cancelled'])->default('idea');
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedBigInteger('campaign_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('content_posts'); }
};
