<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memos', function (Blueprint $table) {
            $table->id();
            $table->string('memo_num');
            $table->string('recipient');
            $table->string('recipient_company');
            $table->string('recipient_address');
            $table->string('subject');
            $table->longtext('content');
            $table->string('name_of_writer');
            $table->string('position_of_writer');
            $table->string('signature_of_writer');
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
        Schema::dropIfExists('memos');
    }
}
