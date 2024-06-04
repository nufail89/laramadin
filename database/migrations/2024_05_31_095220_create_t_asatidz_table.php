<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTAsatidzTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_asatidz', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->string('nickname')->nullable();
            $table->string('no_hp')->nullable();
            $table->enum('gender',['L', 'P'])->default('L');
            $table->text('alamat')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir');
            $table->date('TMT');
            $table->string('gelar_depan')->nullable();
            $table->string('gelar_belakang')->nullable();
            $table->enum('status_kawin',['Kawin', 'Belum Kawin'])->default('Kawin')->nullable();
            $table->string('no_sk')->nullable();
            $table->string('foto_url')->nullable();
            $table->string('rek_kjks')->nullable();
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
        Schema::dropIfExists('t_asatidz');
    }
}
