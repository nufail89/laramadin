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
            $table->string('nik',20)->unique();
            $table->string('nama',100);
            $table->string('nickname',50)->nullable();
            $table->string('no_hp',20)->nullable();
            $table->enum('gender',['L', 'P'])->default('L');
            $table->text('alamat')->nullable();
            $table->string('tempat_lahir',100)->nullable();
            $table->date('tanggal_lahir');
            $table->date('TMT');
            $table->string('gelar_depan',64)->nullable();
            $table->string('gelar_belakang',64)->nullable();
            $table->enum('status_kawin',['Kawin', 'Belum Kawin'])->default('Kawin')->nullable();
            $table->string('no_sk')->nullable();
            $table->string('foto_url')->nullable();
            $table->string('rek_kjks',100)->nullable();
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
