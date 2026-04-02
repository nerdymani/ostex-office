<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->string('department')->nullable()->after('email');
            $table->string('position')->nullable()->after('department');
            $table->string('phone')->nullable()->after('position');
            $table->string('employee_id')->unique()->nullable()->after('phone');
            $table->date('joined_date')->nullable()->after('employee_id');
            $table->boolean('is_active')->default(true)->after('joined_date');
            $table->boolean('is_admin')->default(false)->after('is_active');
        });
    }
    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['department','position','phone','employee_id','joined_date','is_active','is_admin']);
        });
    }
};
