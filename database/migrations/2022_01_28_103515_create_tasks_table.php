<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('detail')->nullable();
            $table->integer('order')->default(0)->index();
            $table->foreignId('board_id')->constrained()->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
            $table->index(['order', 'board_id']);
        });
    }

    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropIndex(['order', 'board_id']);
            $table->dropConstrainedForeignId('board_id');
            $table->dropColumn('board_id');
        });
        Schema::dropIfExists('tasks');
    }
}
