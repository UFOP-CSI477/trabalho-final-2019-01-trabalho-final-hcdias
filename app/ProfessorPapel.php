<?php

namespace PesquisaProjeto;

use Illuminate\Database\Eloquent\Model;

class ProfessorPapel extends Model
{
    protected $table = 'professor_papeis';

    const ORIENTADOR = 1;
    const COORIENTADOR = 2;
}
