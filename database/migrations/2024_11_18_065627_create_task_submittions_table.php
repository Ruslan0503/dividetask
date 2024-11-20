<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_submittions', function (Blueprint $table) {
            $table->id();
            $table->foreignID('to')->constrained("users")->onDelete('cascade');
            $table->foreignID('taskID')->constrained("tasks")->onDelete('cascade');
            $table->longText('description');
            $table->string('file_path');
            $table->string('file_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_submittions');
    }
};
