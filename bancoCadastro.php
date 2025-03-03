<?php

require_once('config\functions.php');

if (isset($_POST["banco"]) && isset($_POST["agencia"]) && isset($_POST["conta"]) && isset($_POST["saldo"]) ) {
    $banco = $_POST["banco"];
    $agencia = (int) $_POST["agencia"]; // Convertendo para inteiro
    $conta = (int) $_POST["conta"];
    $saldo = (int) $_POST["saldo"];
    
   
    cadastrarConta($conn, $banco, $agencia, $conta, $saldo);    
    
}


?>


<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.container {
    width: 350px;
    padding: 20px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

h2 {
    margin-bottom: 15px;
    color: #333;
}

input, button {
    width: 100%;
    padding: 10px;
    margin: 5px 0;
    border-radius: 5px;
    border: 1px solid #ccc;
}

input:focus {
    outline: none;
    border-color: #007bff;
}

button {
    background-color: #007bff;
    color: white;
    border: none;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}
</style>
    
    

</head>
<body>
    <div class="container">
        <h2>Cadastro de Banco</h2>
        <form id="bancoForm" action="" method="POST" onsubmit="return validarFormulario()">
            <input type="text" name="banco" placeholder="Nome do Banco" required>
            <input type="text" name="agencia" placeholder="Agência" required>
            <input type="text" name="conta" placeholder="Conta" required>
            <input type="number" step="0.01" name="saldo" placeholder="Saldo" required min="0">
            <button type="submit">Cadastrar</button>
        </form>
    </div>
    
    <script>
        function validarFormulario() {
            const saldo = document.querySelector('[name="saldo"]').value;
            if (saldo < 0) {
                alert("O saldo não pode ser negativo.");
                return false;
            }
            return true;
        }
    </script>
