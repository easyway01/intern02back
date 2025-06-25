<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // ✅ 添加主键
            $table->string('title');
            $table->date('due_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps(); // ✅ 添加 created_at 和 updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};

