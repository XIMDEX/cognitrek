<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserResourcesTable extends Migration
{
    public function up()
    {
        Schema::create('user_resources', function (Blueprint $table) {
            $table->id();
            $table->text('user_id');
            $table->uuid('resource_id');
            $table->text('content')->nullable(); 
            $table->text('resume')->nullable(); 
            $table->text('conceptual_map')->nullable();
            $table->timestamps();

            $table->foreign('resource_id')->references('id')->on('resources')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_resources');
    }
}