<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTccPropostasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tcc_propostas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('orientador_id')->unsigned();
            $table->integer('coorientador_id')->unsigned()->nullable();
            $table->integer('aluno_id')->unsigned();
            $table->integer('area_id')->unsigned();
            $table->string('titulo');
            $table->string('descricao');
            $table->integer('status_id')->unsigned()->default(1);
            $table->timestamps();

            $table->foreign('status_id')
                ->references('id')
                ->on('status_tcc_propostas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tcc_propostas');
    }
}
