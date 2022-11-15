<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataKuisionersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_kuisioners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode_kuisioner');
            $table->text('nama_data');
            $table->integer('no_urut');
            $table->integer('is_archived')->nullable();
            $table->integer('is_selected');
            $table->integer('is_required');
            $table->integer('kategori')->nullable();
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
        Schema::dropIfExists('data_kuisioners');
    }
}
