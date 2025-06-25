<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodosTable extends Migration
{
    public function up()
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->datetime('due_date');
            $table->datetime('end_date')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('implementing');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('todos'); // ✅ 正确的表名
    }
}
