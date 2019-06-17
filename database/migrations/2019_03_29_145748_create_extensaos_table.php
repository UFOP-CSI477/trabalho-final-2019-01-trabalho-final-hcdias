<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtensaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extensaos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo');
            $table->string('resumo');
            $table->integer('ano_inicio');
            $table->integer('semestre_inicio');
            $table->string('sisbin')->nullable();
            $table->integer('status_id')->unsigned()->default(1);
            $table->integer('abordagem_id')->unsigned()->default(1);
            $table->integer('area_id')->unsigned()->default(1);
            $table->integer('sub_area_id')->unsigned()->default(1);
            $table->integer('orientador_id')->unsigned()->default(null);
            $table->integer('coorientador_id')->unsigned()->default(null);
            $table->integer('aluno_id')->unsigned()->default(1);
            
            $table->timestamps();

            $table->foreign('abordagem_id')
                ->references('id')
                ->on('abordagem_pesquisas');

            $table->foreign('area_id')
                ->references('id')
                ->on('area_pesquisas');

            $table->foreign('sub_area_id')
                ->references('id')
                ->on('sub_area_pesquisas');

            $table->foreign('orientador_id')
                ->references('id')
                ->on('professores');

            $table->foreign('coorientador_id')
                ->references('id')
                ->on('professores');

            $table->foreign('aluno_id')
                ->references('id')
                ->on('alunos');

            $table->foreign('status_id')
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
        Schema::dropIfExists('extensaos');
    }
}
