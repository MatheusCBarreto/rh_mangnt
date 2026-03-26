<?php

use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/email', function () {

    Mail::raw('Mensagem de teste rh mangnt', function (Message $message) {
        $message->to('teste@gmail.com')
            ->subject('Bem-vindo ao RH Mangnt')
            ->from('noreply@rhmangnt.com');
    });

    echo "Email enviado com sucesso!";
});
