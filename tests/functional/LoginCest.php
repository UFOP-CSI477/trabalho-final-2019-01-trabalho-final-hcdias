<?php 

class LoginCest
{

    // tests
    public function tryLogin(FunctionalTester $functionalI)
    {
    	$functionalI->amOnPage('/admin/login');
    	$functionalI->fillField('email','admin@admin.com');
    	$functionalI->fillField('password','admin');
    	$functionalI->click('Entrar');
    	$functionalI->see('Bem vindo');
    }
}
