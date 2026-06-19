<?php

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
