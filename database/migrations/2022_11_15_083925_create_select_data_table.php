<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSelectDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('select_data', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode_kuisioner');
            $table->string('isi_data');
            $table->integer('no_urut');
            $table->integer('is_archived');
            $table->timestamps();
            $table->date('archived_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('select_data');
    }
}
