<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id(); // big integer with auto increment
            $table->string('title');
            $table->unsignedBigInteger('author_id'); // unsigned big integer
            $table->year('published_year');
            $table->boolean('available')->default(true); // Indicates if the book is available for borrowing
            $table->dateTime('borrowed_at')->nullable(); // Date and time when the book was borrowed
            $table->dateTime('returned_at')->nullable(); // Date and time when the book was returned
            $table->timestamps();
            
            // Foreign key constraint
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('books');
    }
}