<?php

namespace PesquisaProjeto\Http\Controllers\Auth;

use Illuminate\Http\Request;
use PesquisaProjeto\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class MinhaUfopLoginController extends Controller
{

	use AuthenticatesUsers;

	/**
	* Redirecionamento apos o login
	*
	* @var string
	*/
	protected $redirectTo = '/home';

    /**
     * Exibe o form de login minhaufop
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginUfop()
    {
    	return view('authminhaufop.login');
    }

    /**
     * Guard do controller
     *
     * @return \Illuminate\Http\Response
     */
    public function guard()
    {
    	return Auth::guard('minhaufop-guard');
    }

    public function __construct()
    {
        $this->middleware('guest:minhaufop-guard')->except('logout');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/');
    }
}
