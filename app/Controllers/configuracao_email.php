<?php
return [
    'host' => 'smtp.gmail.com',
    'porta' => 587,
    'seguranca' => 'tls',

    'usuario' => 'levisantosoliv@gmail.com',

    'senha' => 'lwyh vdbe vebs hgku',

    'remetente' => 'levisantosoliv@gmail.com',

    'nome_remetente' => 'Histórias na Pérola',

    // Usados pela recuperação de senha

    // Chave secreta que assina os links de "Esqueceu a senha?". Mantenha em segredo.
    // Se trocar, os links já enviados deixam de funcionar.
    'chave_token' => '687f3338c74147d9f862d0696195f113f4110bc0280875bfaa4b8d47a71380b8',

    // Endereço público do site, sem barra no final (ex.: 'https://meusite.com.br').
    // Deixe vazio no XAMPP: o endereço é detectado automaticamente.
    // Ao publicar, preencha: o link do e-mail passa a usar este endereço.
    'url_site' => '',

    // Verifica o certificado do servidor de e-mail. Só mude para false em teste local,
    // se der erro de certificado no XAMPP.
    'verificar_certificado' => true
];
