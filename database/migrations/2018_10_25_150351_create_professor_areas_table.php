<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfessorAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professor_areas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('minha_ufop_user_id')->unsigned();
            $table->integer('area_pesquisa_id')->unsigned();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->foreign('minha_ufop_user_id')
                ->references('id')
                ->on('minha_ufop_users');

            $table->foreign('area_pesquisa_id')
                ->references('id')
                ->on('area_pesquisas');                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('professor_areas');
    }
}
