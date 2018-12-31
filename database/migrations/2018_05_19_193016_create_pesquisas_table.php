<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePesquisasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesquisas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pesquisa_titulo');
            $table->longText('pesquisa_resumo');
            $table->integer('pesquisa_ano_inicio');
            $table->integer('pesquisa_semestre_inicio');
            $table->integer('status_pesquisa_id')->unsigned()->default(1);
            $table->integer('natureza_pesquisa_id')->unsigned()->default(1);
            $table->integer('abordagem_pesquisa_id')->unsigned()->default(1);
            $table->integer('objetivo_pesquisa_id')->unsigned()->default(1);
            $table->integer('procedimentos_pesquisa_id')->unsigned()->default(1);
            $table->integer('area_pesquisa_id')->unsigned()->default(1);
            $table->integer('agencia_pesquisa_id')->unsigned()->default(1);
            $table->integer('sub_area_pesquisa_id')->unsigned()->default(1);
            $table->timestamps();

             $table->foreign('natureza_pesquisa_id')
                ->references('id')
                ->on('natureza_pesquisas');

            $table->foreign('abordagem_pesquisa_id')
                ->references('id')
                ->on('abordagem_pesquisas');

            $table->foreign('objetivo_pesquisa_id')
                ->references('id')
                ->on('objetivo_pesquisas');

            $table->foreign('procedimentos_pesquisa_id')
                ->references('id')
                ->on('procedimentos_pesquisas');

            $table->foreign('area_pesquisa_id')
                ->references('id')
                ->on('area_pesquisas');

            $table->foreign('agencia_pesquisa_id')
                ->references('id')
                ->on('agencia_pesquisas');

            $table->foreign('sub_area_pesquisa_id')
                ->references('id')
                ->on('sub_area_pesquisas');

            $table->foreign('status_pesquisa_id')
                ->references('id')
                ->on('status_pesquisas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesquisas');
    }
}
