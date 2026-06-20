<?php

it('tests is an admin user can see the RH users page', function () {
    // criar o admin
    addAdminUser();

    // efetuar o login com o admin
    auth()->loginUsingId(1);

    //verifica se consegue acessar a página de RH users
    expect($this->get('/rh-users')->status())->toBe(200);
});
