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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id(); // 自增主键
            $table->string('queue')->index(); // 队列名称
            $table->longText('payload'); // 要执行的任务内容
            $table->unsignedTinyInteger('attempts'); // 重试次数
            $table->unsignedInteger('reserved_at')->nullable(); // 被占用的时间（执行中）
            $table->unsignedInteger('available_at'); // 可用时间（准备执行）
            $table->unsignedInteger('created_at'); // 创建时间（Unix 时间戳）
        });        

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary(); // 批处理唯一ID
            $table->string('name'); // 批次名
            $table->integer('total_jobs'); // 总任务数
            $table->integer('pending_jobs'); // 待处理数量
            $table->integer('failed_jobs'); // 失败数量
            $table->longText('failed_job_ids'); // 失败任务ID列表（JSON）
            $table->mediumText('options')->nullable(); // 选项（JSON）
            $table->integer('cancelled_at')->nullable(); // 被取消的时间戳
            $table->integer('created_at'); // 创建时间
            $table->integer('finished_at')->nullable(); // 完成时间
        });        

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique(); // 全局唯一 ID
            $table->text('connection'); // 连接类型（如 database、redis）
            $table->text('queue'); // 队列名
            $table->longText('payload'); // 任务数据
            $table->longText('exception'); // 异常信息
            $table->timestamp('failed_at')->useCurrent(); // 失败时间
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('failed_jobs');
    }
};
