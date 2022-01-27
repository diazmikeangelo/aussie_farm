<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKangaroosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kangaroos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('nickname')->nullable();
            $table->decimal('weight', 8, 2)->comment('in kilograms');
            $table->decimal('height', 8, 2)->comment('in centimeters');
            $table->enum('gender', ['male', 'female']);
            $table->string('color')->nullable();
            $table->string('friendliness')->nullable();
            $table->dateTime('birthday');
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
        Schema::dropIfExists('kangaroos');
    }
}
