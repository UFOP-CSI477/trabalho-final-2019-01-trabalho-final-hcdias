<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTccsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('tccs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tcc_titulo');
            $table->string('tcc_resumo');
            $table->integer('tcc_ano_inicio');
            $table->integer('tcc_semestre_inicio');
            $table->integer('tcc_semestre_defesa');
            $table->string('tcc_sisbin')->default("");
            $table->integer('tcc_status');
            $table->integer('natureza_tcc_id')->unsigned()->default(1);
            $table->integer('abordagem_tcc_id')->unsigned()->default(1);
            $table->integer('objetivo_tcc_id')->unsigned()->default(1);
            $table->integer('procedimentos_tcc_id')->unsigned()->default(1);
            $table->integer('area_tcc_id')->unsigned()->default(1);
            $table->integer('sub_area_tcc_id')->unsigned()->default(1);
            $table->integer('orientador_tcc_id')->unsigned()->default(null);
            $table->integer('coorientador_tcc_id')->unsigned()->default(null);
            $table->integer('aluno_tcc_id')->unsigned()->default(1);
            $table->timestamps();

             $table->foreign('natureza_tcc_id')
                ->references('id')
                ->on('natureza_pesquisas');

            $table->foreign('abordagem_tcc_id')
                ->references('id')
                ->on('abordagem_pesquisas');

            $table->foreign('objetivo_tcc_id')
                ->references('id')
                ->on('objetivo_pesquisas');

            $table->foreign('procedimentos_tcc_id')
                ->references('id')
                ->on('procedimentos_pesquisas');

            $table->foreign('area_tcc_id')
                ->references('id')
                ->on('area_pesquisas');

            $table->foreign('sub_area_tcc_id')
                ->references('id')
                ->on('sub_area_pesquisas');

            $table->foreign('orientador_tcc_id')
                ->references('id')
                ->on('professores');

            $table->foreign('coorientador_tcc_id')
                ->references('id')
                ->on('professores');

            $table->foreign('aluno_tcc_id')
                ->references('id')
                ->on('alunos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tccs');
    }
}
