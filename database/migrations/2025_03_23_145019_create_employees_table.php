<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_code')->unique();  // 社員番号（一意制約）
            $table->string('last_name');               // 姓
            $table->string('first_name');              // 名
            $table->string('last_name_kana');         // 姓よみ
            $table->string('first_name_kana');        // 名よみ
            $table->string('maiden_name')->nullable(); // 旧姓（null許容）
            $table->string('maiden_name_kana')->nullable(); // 旧姓よみ（null許容）
            $table->string('email')->unique();         // メールアドレス（一意制約）
            $table->string('phone');                   // 電話番号
            $table->string('department');              // 部署
            $table->string('position');                // 役職
            $table->date('hire_date');                // 入社日
            $table->date('resignation_date')->nullable(); // 退職日（null許容）
            $table->enum('status', ['active', 'job_seeking', 'resigned']); // ステータス（在籍中、求職中、退職済み）
            $table->timestamps();                      // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
