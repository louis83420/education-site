<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id(); // 主鍵
            $table->text('question'); // 問題文字
            $table->string('option_a'); // 選項 A 描述
            $table->string('option_a_value'); // 選項 A 的特質值 (例如 J)
            $table->string('option_b'); // 選項 B 描述
            $table->string('option_b_value'); // 選項 B 的特質值 (例如 P)
            $table->string('part'); // 問題所屬部分 
            $table->timestamps(); // created_at 和 updated_at 欄位
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
