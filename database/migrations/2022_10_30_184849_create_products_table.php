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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id')->unsigned();

            $table->string('title', 255);
            $table->longText('description');
            $table->integer('subcategory_id')->unsigned();
            $table->float('price', 10, 2);
            $table->string('thumbnail', 255);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('subcategory_id')
                ->references('id')->on('subcategories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
