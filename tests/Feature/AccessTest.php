<?php

it('tests if is an admin user can see the RH users page', function () {
    // criar o admin
    addAdminUser();

    // efetuar o login com o admin
    auth()->loginUsingId(1);

    //verifica se consegue acessar a página de RH users
    expect($this->get('/rh-users')->status())->toBe(200);
});

it('tests if is not possible to access the home page without logged user', function () {
    // verifica se é possível acessar a home page
    expect($this->get('/home')->status())->toBe(302);

    // ou 
    expect($this->get('/home')->status())->not()->toBe(200);
});

it('tests if user logged in can access to the login page', function () {
    // adiciona admin à base de dados
    addAdminUser();

    // login automático
    auth()->loginUsingId(1);

    expect($this->get('/login')->status())->not()->toBe(200);
});

it('tests if user logged in can access to the recover password page', function () {
    // adiciona admin à base de dados
    addAdminUser();

    // login automático
    auth()->loginUsingId(1);

    expect($this->get('/forgot-password')->status())->not()->toBe(200);
});
