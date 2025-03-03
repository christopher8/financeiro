<?php 
include_once('config\functions.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logar'])){
 $usuario         =trim($_POST['usuario']);
 $senha           =trim($_POST['senha']);

 $id = verificarUsuario($conn,$usuario,$senha);
 

 if($id){
    echo "<script>
       window.location.href = 'index.php';
    </script>";
 }else{
    "<script>
    alert('USUARIO OU SENHA INVALIDA!!!!!');
    </script>";
 }

}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Login</title>
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
        .form-login {
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
        input[type="password"] {
            width: 95%;
            padding: 10px;
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
        .links {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }
        .links a {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }
        .links a:hover {
            text-decoration: underline;
        }
        .error {
            color: red;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="form-login">
        <h2>Login</h2>
        <form action="" method="POST">
        <input type="hidden" name="logar">
            <!-- Campo de Usuário -->
            <label for="usuario">Usuário:</label>
            <input type="text" id="usuario" name="usuario" placeholder="Digite seu nome de usuário" required>

            <!-- Campo de Senha -->
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" placeholder="Digite sua senha" minlength="6" required>

            <!-- Botão de Envio -->
            <input type="submit" value="Entrar">

            <!-- Links para Esqueci Senha e Cadastrar -->
            <div class="links">   
            <a href="cadastro.php">Cadastrar</a>
            <a href="#">Esqueci minha senha</a>    
            </div>
        </form>
    </div>
</body>
</html>