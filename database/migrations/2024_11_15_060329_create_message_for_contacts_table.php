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
        Schema::create('message_for_contacts', function (Blueprint $table) {
            $table->id();  // Auto-incrementing primary key
            $table->text('title');  // Column to store the title, using `text` as the type

            // Foreign keys for assigner and performer, assuming "users" is the table name
            $table->foreignId('from')->constrained('users')->onDelete('cascade');
            $table->foreignId('to')->constrained('users')->onDelete('cascade');

            // Add created_at and updated_at columns (timestamps)
            $table->timestamps();  // This automatically adds `created_at` and `updated_at` columns

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('message_for_contacts');
    }
};
