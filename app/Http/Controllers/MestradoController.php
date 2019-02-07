<?php

namespace PesquisaProjeto\Http\Controllers;

use Illuminate\Http\Request;

class MestradoController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function index()
    {
    	echo 'oi';

    }
}
