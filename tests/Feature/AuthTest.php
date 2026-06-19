<?php

use App\Models\User;

it('display the login page when not logged in', function () {

    // verifica, no contexto do fortify, se ao entrar inicial, será redirecionado para a página de login
    $result = $this->get('/')->assertRedirect('/login');

    // verifica se o resultado é o código 302
    expect(($result)->status(302))->toBe(302);

    // verifica se a rota de login é acessível com status 200
    expect($this->get('/login')->status())->toBe(200);

    // verifica se a página de login contém o texto "Esquceu a sua senha?"
    expect($this->get('/login')->content())->toContain("Esqueceu a sua senha?");
});

it('display the recover password page correctly', function () {

    expect($this->get('/forgot-password')->status())->toBe(200);
    expect($this->get('/forgot-password')->content())->toContain("Já sei a minha senha?");
});

it('test if an admin user can login with success', function () {

    // criar um admin
    addAdminUser();

    // login com o admin criado
    $result = $this->post('/login', [
        'email' => 'admin@rhmangnt.com',
        'password' => 'Aa123456'
    ]);

    // verifica se o login foi feito com sucesso.
    expect($result->status())->toBe(302);
    expect($result->assertRedirect('/home'));
});

it('test if an rh user can loggin with success', function () {

    // criar o usuário rh
    addRhUser();

    // login o rh user
    $result = $this->post('/login', [
        'email' => 'rh1@rhmangnt.com',
        'password' => 'Aa123456'
    ]);

    // verifica se o user rh fez login com sucesso
    expect($result->status())->toBe(302);
    expect($result->assertRedirect('/home'));

    // verifica se o user rh consegue acesso à página exclusiva
    expect($this->get('/rh-users/management/home')->status())->toBe(200);
});

it('test if an colaborator user can loggin with success', function () {

    // criar o usuário colaborador
    addColaboratorUser();

    // login o rh user
    $result = $this->post('/login', [
        'email' => 'colaborador@rhmangnt.com',
        'password' => 'Aa123456'
    ]);

    // verifica se o user rh fez login com sucesso
    expect($result->status())->toBe(302);
    expect($result->assertRedirect('/home'));

    // verifica se o calaborador NÃO consegue chegar a uma rota exclusiva do admin
    expect($this->get('/departments')->status())->not()->toBe(200);
});

function addAdminUser()
{
    // create admin user 
    User::insert([
        'department_id' => 1,   // Administração
        'name' => 'Administrador',
        'email' => 'admin@rhmangnt.com',
        'email_verified_at' => now(),
        'password' => bcrypt('Aa123456'),
        'role' => 'admin',
        'permissions' => '["admin"]',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}

function addRhUser()
{
    // create rh user 
    User::insert([
        'department_id' => 2,   // Administração
        'name' => 'Colaborador de RH',
        'email' => 'rh1@rhmangnt.com',
        'email_verified_at' => now(),
        'password' => bcrypt('Aa123456'),
        'role' => 'rh',
        'permissions' => '["rh"]',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}

function addColaboratorUser()
{
    // create admin user 
    User::insert([
        'department_id' => 3,   // Administração
        'name' => 'Colaborador normal',
        'email' => 'colaborador@rhmangnt.com',
        'email_verified_at' => now(),
        'password' => bcrypt('Aa123456'),
        'role' => 'colaborator',
        'permissions' => '["colaborator"]',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}
