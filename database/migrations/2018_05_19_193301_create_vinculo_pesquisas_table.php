<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVinculoPesquisasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vinculo_pesquisas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pesquisa_id')->unsigned();
            $table->integer('professor_papel_id')->unsigned();
            $table->integer('aluno_id')->unsigned();
            $table->integer('professor_id')->unsigned();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->foreign('pesquisa_id')
                ->references('id')
                ->on('pesquisas')
                ->onDelete('cascade');

            $table->foreign('professor_papel_id')
                ->references('id')
                ->on('professor_papeis');

            $table->foreign('aluno_id')
                ->references('id')
                ->on('alunos');

            $table->foreign('professor_id')
                ->references('id')
                ->on('professores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vinculo_pesquisas');
    }
}
