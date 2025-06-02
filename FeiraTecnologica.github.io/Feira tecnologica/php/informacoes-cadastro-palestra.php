<?php

$informacoes = [
    'nome' => '',
    'anoNascimento' => '',
    'telefone' => '',
    'palestraSelecionada' => '',
    'tipoParticipante' => '',
    'rm' => '',
    'cpf' => ''
];

echo "informações recebidas: <br>";
foreach ($informacoes as $key => $value) {
    if (isset($_POST[$key])) {
        $informacoes[$key] = trim($_POST[$key]);
        echo "$key: " . htmlspecialchars($informacoes[$key]) . "<br>";
    } else {
        echo "$key não foi enviado.<br>";
    }
}