<?php 

class LoginCest
{
    public function _before(FunctionalTester $I)
    {
    }

    // tests
    public function tryLogin(FunctionalTester $I)
    {
    	$I->amOnPage('/admin/login');
    	$I->fillField('email','admin@admin.com');
    	$I->fillField('password','admin');
    	$I->click('Entrar');
    	$I->see('Bem vindo');
    }
}
