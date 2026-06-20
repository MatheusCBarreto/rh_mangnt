<?php

use App\Models\User;
use App\Models\Department;

it('tests if an admin can insert a new RH user', function () {
    // criar um user admin
    addAdminUser();

    // criar os departamentos
    addDepartment('Administração');
    addDepartment('Recursos Humanos');

    // fazer o login com o admin
    $result = $this->post('/login', [
        'email' => 'admin@rhmangnt.com',
        'password' => 'Aa123456'
    ]);

    // verifica se o login foi feito com sucesso.
    expect($result->status())->toBe(302);
    expect($result->assertRedirect('/home'));

    // verifica se o admin consegue adicionar o user de rh
    $result = $this->post('/rh-users/create-colaborator', [
        'name' => 'RH user 1',
        'email' => 'rhuser@teste.com',
        'select_department' => 2,
        'address' => 'Rua 1',
        'zip_code' => '1234-123',
        'city' => '1234-City-1',
        'phone' => '123456789',
        'salary' => '1000.00',
        'admission_date' => '2026-02-05',
        'role' => 'rh',
        'permissions' => '["rh"]',
    ]);

    // verifica se o user rh foi inserido com sucesso
    $this->assertDatabaseHas('users', [
        'name' => 'RH user 1',
        'email' => 'rhuser@teste.com',
        'role' => 'rh',
        'permissions' => '["rh"]',
    ]);
});

it('tests if an admin can insert a new Colaborator user', function () {
    // criar um user hr
    addRhUser();

    // criar os departamentos
    addDepartment('Administração');
    addDepartment('Recursos Humanos');
    addDepartment('Comercial');

    // fazer o login com o rh
    $result = $this->post('/login', [
        'email' => 'rh1@rhmangnt.com',
        'password' => 'Aa123456'
    ]);

    // verifica se o login foi feito com sucesso.
    expect(auth()->user()->role)->toBe('rh');

    // verifica se o admin consegue adicionar o user de rh
    $result = $this->post('/rh-users/management/create-colaborator', [
        'name' => 'Colaborator 1',
        'email' => 'colaborator1@teste.com',
        'select_department' => 3,
        'address' => 'Rua 2',
        'zip_code' => '1234-000',
        'city' => '1234-City-2',
        'phone' => '123456789',
        'salary' => '1000.00',
        'admission_date' => '2026-02-05',
        'role' => 'colaborator',
        'permissions' => '["colaborator"]',
    ]);

    // verifica se o user rh foi inserido com sucesso
    // $this->assertDatabaseHas('users', [
    //     'name' => 'Colaborator 1',
    //     'email' => 'colaborator1@teste.com',
    //     'role' => 'colaborator',
    //     'permissions' => '["colaborator"]',
    // ]);

    expect(User::where('email', 'colaborator1@teste.com')->exists())->toBe(true);
});

function addDepartment($name)
{
    Department::insert([
        'name' => $name,
        'created_at' => now(),
        'updated_at' => now()
    ]);
}
