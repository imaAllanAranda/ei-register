<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvisersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advisers', function (Blueprint $table) {
            $table->id();

            $table->string('type');
            $table->string('name');
            $table->string('email');
            $table->integer('fsp_no')->nullable();
            $table->string('contact_number');
            $table->string('status');

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
        Schema::dropIfExists('advisers');
    }
}
