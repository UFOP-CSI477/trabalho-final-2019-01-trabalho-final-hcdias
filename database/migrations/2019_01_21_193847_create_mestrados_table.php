<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMestradosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mestrados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo_mestrado');
            $table->string('resumo_mestrado');
            $table->integer('ano_inicio_mestrado');
            $table->integer('semestre_inicio_mestrado');
            $table->string('sisbin_mestrado')->nullable();
            $table->integer('status_mestrado')->unsigned()->default(1);
            $table->integer('natureza_mestrado_id')->unsigned()->default(1);
            $table->integer('abordagem_mestrado_id')->unsigned()->default(1);
            $table->integer('objetivo_mestrado_id')->unsigned()->default(1);
            $table->integer('procedimentos_mestrado_id')->unsigned()->default(1);
            $table->integer('area_mestrado_id')->unsigned()->default(1);
            $table->integer('sub_area_mestrado_id')->unsigned()->default(1);
            $table->integer('orientador_mestrado_id')->unsigned()->default(null);
            $table->integer('coorientador_mestrado_id')->unsigned()->default(null);
            $table->integer('aluno_mestrado_id')->unsigned()->default(1);
            
            $table->timestamps();

             $table->foreign('natureza_mestrado_id')
                ->references('id')
                ->on('natureza_pesquisas');

            $table->foreign('abordagem_mestrado_id')
                ->references('id')
                ->on('abordagem_pesquisas');

            $table->foreign('objetivo_mestrado_id')
                ->references('id')
                ->on('objetivo_pesquisas');

            $table->foreign('procedimentos_mestrado_id')
                ->references('id')
                ->on('procedimentos_pesquisas');

            $table->foreign('area_mestrado_id')
                ->references('id')
                ->on('area_pesquisas');

            $table->foreign('sub_area_mestrado_id')
                ->references('id')
                ->on('sub_area_pesquisas');

            $table->foreign('orientador_mestrado_id')
                ->references('id')
                ->on('professores');

            $table->foreign('coorientador_mestrado_id')
                ->references('id')
                ->on('professores');

            $table->foreign('aluno_mestrado_id')
                ->references('id')
                ->on('alunos');

            $table->foreign('status_mestrado')
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
        Schema::dropIfExists('mestrados');
    }
}
