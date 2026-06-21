<?php

use App\Services\GeneralServices;

it('tests if the salary is grather than a specific amount', function () {
    $salary = 1000;
    $amount = 500;

    $result = GeneralServices::checkIfSalaryIsGreaterThan($salary, $amount);

    expect($result)->toBeTrue();
});

it('tests if the phrase is created correctly', function () {
    $name = "Matheus";
    $salary = 2000;

    $result = GeneralServices::createPhraseWithNameAndSalary($name, $salary);

    expect($result)->toBe("O salário do(a) Matheus é 2000 reais");
});

it('tests if the salary with bonus is calculated correctly', function () {
    $salary = 2000;
    $bonus = 25;

    $result = GeneralServices::getSalaryWithBonus($salary, $bonus);

    expect($result)->toBe(2025);
});

it('tests if the json fake data is created correctly', function () {

    $result = GeneralServices::fakeDataInJson();

    $clients = json_decode($result, true);

    expect(count($clients))->toBeGreaterThanOrEqual(1);
    expect($clients[0])->toHaveKeys(['name', 'email', 'phone', 'address']);
});

it('tests if the complex data is created correctly', function () {
    $result = GeneralServices::jsonComplexData();

    $data = json_decode($result, true);
    expect($data)->toHaveKeys(['name', 'email', 'moradas', 'telefones']);
    expect($data['moradas'])->toBeArray();
    expect($data['moradas'][0])->toHaveKeys(['rua', 'cidade', 'pais']);
    expect($data['telefones'])->toHaveKeys(['phones', 'mobiles']);
    expect($data['telefones']['phones'])->toBeArray();
    expect($data['telefones']['mobiles'])->toBeArray();


});
