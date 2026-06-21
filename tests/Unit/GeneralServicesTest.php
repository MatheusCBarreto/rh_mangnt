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
