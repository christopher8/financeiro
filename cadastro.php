<?php 
include_once('config\functions.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar'])){
$usuario         =strtolower($_POST['usuario']);
$senha           =$_POST['senha'];
$nome_completo   =ucwords($_POST['nome_completo']);
$estado          =$_POST['estado'];
$cidade          =ucWords($_POST['cidade']);
$dataAniversario =$_POST['data_nascimento'];
$ativo = 1;

cadastrarUsuario($conn,$usuario,$senha,$nome_completo,$estado,$cidade,$dataAniversario , $ativo);

}








?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Cadastro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-top: 10px;
            color: #555;
        }
        input[type="text"],
        input[type="password"],
        input[type="date"],
        select {
            width: 100%;
            padding: 7px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Cadastro de Usuário</h2>
        <form name="cadastrar" action="" method="post">
        <input type="hidden" name="cadastrar">
            <!-- Campo de Usuário -->
            <label for="usuario">Usuário:</label>
            <input type="text" id="usuario" name="usuario" placeholder="Digite seu nome de usuário" required>

            <!-- Campo de Senha -->
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" placeholder="Digite sua senha" minlength="6" required>

            <!-- Campo de Nome Completo -->
            <label for="nome-completo">Nome Completo:</label>
            <input type="text" id="nome-completo" name="nome_completo" placeholder="Digite seu nome completo" required>

            <!-- Campo de Cidade -->
            <label for="cidade">Cidade:</label>
            <input type="text" id="cidade" name="cidade" placeholder="Digite sua cidade" required>

            <!-- Campo de Estado -->
            <label for="estado">Estado:</label>
            <select id="estado" name="estado" required>
                <option value="" disabled selected>Selecione seu estado</option>
                <option value="AC">Acre</option>
                <option value="AL">Alagoas</option>
                <option value="AP">Amapá</option>
                <option value="AM">Amazonas</option>
                <option value="BA">Bahia</option>
                <option value="CE">Ceará</option>
                <option value="DF">Distrito Federal</option>
                <option value="ES">Espírito Santo</option>
                <option value="GO">Goiás</option>
                <option value="MA">Maranhão</option>
                <option value="MT">Mato Grosso</option>
                <option value="MS">Mato Grosso do Sul</option>
                <option value="MG">Minas Gerais</option>
                <option value="PA">Pará</option>
                <option value="PB">Paraíba</option>
                <option value="PR">Paraná</option>
                <option value="PE">Pernambuco</option>
                <option value="PI">Piauí</option>
                <option value="RJ">Rio de Janeiro</option>
                <option value="RN">Rio Grande do Norte</option>
                <option value="RS">Rio Grande do Sul</option>
                <option value="RO">Rondônia</option>
                <option value="RR">Roraima</option>
                <option value="SC">Santa Catarina</option>
                <option value="SP">São Paulo</option>
                <option value="SE">Sergipe</option>
                <option value="TO">Tocantins</option>
            </select>

            <!-- Campo de Data de Nascimento -->
            <label for="data-nascimento">Data de Nascimento:</label>
            <input type="date" id="data-nascimento" name="data_nascimento" required>

            <!-- Botão de Envio -->
            <input type="submit" value="Cadastrar">
        </form>
    </div>
</body>
</html>