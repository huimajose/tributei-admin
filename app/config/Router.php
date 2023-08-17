<?php

$this->get('/dashboard', 'PagesController@home');
$this->get('/home', 'PagesController@home');
$this->get('/login', 'PagesController@login');
$this->get('/lancamentos-entrada', 'PagesController@entrada');
$this->get('/lancamentos-custos', 'PagesController@saida');
$this->get('/simulacao', 'PagesController@simulacao');
$this->get('/register', 'PagesController@register');
$this->get('/produto', 'ProdutoController@index');
$this->get('/complete-profile', 'PagesController@complete');
$this->get('/minha-conta', 'PagesController@profile');

$this->get('/novo-produto', 'ProdutoController@novo');
$this->get('/editar-produto', 'ProdutoController@editar');
$this->post('/insert-produto', 'ProdutoController@insert');

$this->get('/pesquisa', 'ProdutoController@pesquisar');


//criando as rotas do usuario
$this->post('/account/home', 'AccountController@index');
$this->get('/account/login', 'AccountController@login');
$this->post('/account/register', 'AccountController@register');
$this->post('/insert-perfil', 'AccountController@insert');
$this->get('/completar-perfil', 'AccountController@editar');
$this->post('/cossmpletar-perfil', 'AccountController@completar');
$this->get('/account/profile', 'AccountController@profile');
$this->get('/account/dashboard', 'AccountController@dashboard');
$this->get('/account/settings', 'AccountController@settings');
$this->post('/save-settings', 'AccountController@updateSettings');
$this->post('/login-action', 'AccountController@login');
$this->get('/logout', 'PagesController@logout');
$this->get('/account/add-bank-account', 'AccountController@addbank');
$this->get('/account/add-money', 'AccountController@depositar');
$this->post('/account/deposit-money', 'AccountController@addMoney');
$this->get('/account/success-add-bank', 'AccountController@successBank');


//Rotas de pagamentos
$this->get('/account/payment/', 'PaymentController@index');
$this->post('/account/payment-handler', 'PaymentController@handler');
$this->post('/account/payment-sucess', 'PaymentController@sucess');
$this->get('/account/payment/error', 'PaymentController@error');
