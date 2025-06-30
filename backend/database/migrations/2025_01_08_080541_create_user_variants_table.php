<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserVariantsTable extends Migration
{
    public function up()
    {
        Schema::create('user_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('variant_id');
            $table->text('user_id');
            $table->timestamps();

            $table->foreign('variant_id')->references('id')->on('variants')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_variants');
    }
}