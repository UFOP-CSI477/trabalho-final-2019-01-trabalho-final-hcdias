<?php
namespace PesquisaProjeto\LdapiAPI;

use Illuminate\Support\Facades\Facade;

class LdapiAPIFacade extends Facade{

	protected static function getFacadeAccessor()
	{
		return 'LdapiAPI';
	}
}