<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariantsTable extends Migration
{
    public function up()
    {
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->uuid('resource_id');
            $table->unsignedBigInteger('condition_id');
            $table->longText('content');
            $table->text('type');  // content | resume | conceptual_map
            $table->string('label')->nullable(); 
            $table->string('proccessing_id')->nullable();
            $table->timestamps();

            $table->foreign('resource_id')->references('id')->on('resources')->onDelete('cascade');
            $table->foreign('condition_id')->references('id')->on('conditions')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('variants');
    }
}