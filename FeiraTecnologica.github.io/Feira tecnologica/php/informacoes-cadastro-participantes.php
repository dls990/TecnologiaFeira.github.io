<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

   

    $nome = filter_input(INPUT_POST, 'nome', FILTER_UNSAFE_RAW);
    $anoNascimento = filter_input(INPUT_POST, 'anoNascimento', FILTER_UNSAFE_RAW); // Data pode ser validada depois
    $telefone = filter_input(INPUT_POST, 'telefone', FILTER_UNSAFE_RAW); // Telefone como string para manter formatos (ex: com ddd)
    $palestraSelecionada = filter_input(INPUT_POST, 'palestraSelecionada', FILTER_UNSAFE_RAW);
    $tipoParticipante = filter_input(INPUT_POST, 'tipoParticipante', FILTER_UNSAFE_RAW);

    $rm = ''; // Inicializa como vazio
    $cpf = ''; // Inicializa como vazio

    // --- 2. Coleta e Sanitização dos Dados Condicionais (RM ou CPF) ---
    if ($tipoParticipante === 'aluno') {
        $rm = filter_input(INPUT_POST, 'rm', FILTER_UNSAFE_RAW);
    } elseif ($tipoParticipante === 'paiResponsavel') {
        $cpf = filter_input(INPUT_POST, 'cpf', FILTER_UNSAFE_RAW);
    }

    // --- 3. Validação dos Dados ---
    $errors = []; // Array para armazenar erros

    if (empty($nome)) {
        $errors[] = "O nome completo é obrigatório.";
    }
    if (empty($anoNascimento)) {
        $errors[] = "A data de nascimento é obrigatória.";
    }
    // Uma validação mais robusta para telefone (números, formato, etc.)
    if (empty($telefone) || !ctype_digit($telefone)) { // ctype_digit verifica se contém apenas dígitos
        $errors[] = "O telefone é obrigatório e deve conter apenas números.";
    }
    if (empty($palestraSelecionada)) {
        $errors[] = "A palestra/oficina é obrigatória.";
    }
    if (empty($tipoParticipante)) {
        $errors[] = "A seleção de Aluno ou Pai/Responsável é obrigatória.";
    }

    if ($tipoParticipante === 'aluno' && empty($rm)) {
        $errors[] = "O RM do aluno é obrigatório.";
    } elseif ($tipoParticipante === 'paiResponsavel' && empty($cpf)) {
        $errors[] = "O CPF do Pai/Responsável é obrigatório.";
    }

   
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dados Recebidos</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f7f6; color: #333; }
            .container { background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); max-width: 600px; margin: 30px auto; }
            h1 { color: #2c3e50; text-align: center; margin-bottom: 20px; }
            p { margin-bottom: 10px; line-height: 1.6; }
            .success { color: #28a745; font-weight: bold; }
            .error { color: #dc3545; font-weight: bold; }
            ul { list-style-type: none; padding: 0; }
            li { background-color: #ffe0e0; border: 1px solid #dc3545; margin-bottom: 10px; padding: 10px; border-radius: 4px; }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Dados do Cadastro</h1>

            <?php
            if (empty($errors)) {
                
                echo "<p class='success'>Cadastro realizado com sucesso!</p>";
                echo "<p><strong>Nome:</strong> " . htmlspecialchars($nome) . "</p>";
                echo "<p><strong>Nascimento:</strong> " . htmlspecialchars($anoNascimento) . "</p>";
                echo "<p><strong>Telefone:</strong> " . htmlspecialchars($telefone) . "</p>";
                echo "<p><strong>Palestra Selecionada:</strong> " . htmlspecialchars($palestraSelecionada) . "</p>";
                echo "<p><strong>Tipo de Participante:</strong> " . htmlspecialchars($tipoParticipante) . "</p>";

                if ($tipoParticipante === 'aluno') {
                    echo "<p><strong>RM do Aluno:</strong> " . htmlspecialchars($rm) . "</p>";
                } elseif ($tipoParticipante === 'paiResponsavel') {
                    echo "<p><strong>CPF do Pai/Responsável:</strong> " . htmlspecialchars($cpf) . "</p>";
                }

               

            } else {
             
                echo "<p class='error'>Ocorreram os seguintes erros no seu cadastro:</p>";
                echo "<ul>";
                foreach ($errors as $error) {
                    echo "<li>" . htmlspecialchars($error) . "</li>";
                }
                echo "</ul>";
                echo "<p>Por favor, <a href='javascript:history.back()'>volte</a> e corrija os dados.</p>";
            }
            ?>
        </div>
    </body>
    </html>

<?php
} else {
   
    header("Location: index.html"); 
    exit();
}
?>