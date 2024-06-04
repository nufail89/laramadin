<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('t_usr_lembaga', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('lembaga_id');
            $table->integer('person_id');
            $table->unsignedInteger('jabatan_id');
            $table->boolean('isActive');
            $table->timestamps(); // Add created_at and updated_at columns

            // Indexes
            $table->index('jabatan_id', 'FK_t_usr_lembaga_t_jabatan');
            $table->index('lembaga_id', 'FK_t_usr_lembaga_t_lembaga');
            $table->index('user_id', 'FK_t_usr_lembaga_admin_users');

            // Foreign keys
            $table->foreign('user_id', 'FK_t_usr_lembaga_admin_users')
                  ->references('id')->on('admin_users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreign('jabatan_id', 'FK_t_usr_lembaga_t_jabatan')
                  ->references('id')->on('t_jabatan')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreign('lembaga_id', 'FK_t_usr_lembaga_t_lembaga')
                  ->references('id')->on('t_lembaga')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_usr_lembaga');
    }
};
