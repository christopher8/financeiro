<?php
require_once('config\functions.php');

if (isset($_POST["cartao"]) && isset($_POST["limite"]) && isset($_POST["diaFechamento"]) && isset($_POST["diaVencimento"]) ) {
    $cartao = $_POST["cartao"];
    $limite = (int) $_POST["limite"]; // Convertendo para inteiro
    $diaFechamento = (int) $_POST["diaFechamento"];
    $diaVencimento = (int) $_POST["diaVencimento"];
    $limiteDisponivel = 0;
      // Cadastrando o cartão de crédito
    cadastrarCartao($conn, $cartao, $limite, $diaFechamento, $diaVencimento , $limiteDisponivel);
}

// Fechar conexão
$conn->close();
?>



<style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
</style>


<div class="login-container">
        <h1>Cadastro de Cartao de credito </h1>

        <form action="index.php?pg=cartaoCadastro" method="POST">
            <div class="form-login">
                <label for="text">Cartao:</label>
                <input type="text" id="cartao" name="cartao" required>
            </div>

            <div class="form-login">
                <label for="text">Limite:</label>
                <input type="text" id="limite" name="limite" required>
            </div>

            <div class="form-login">
                <label for="text">Dia Fechamento:</label>
                <input type="text" id="diaFechamento" name="diaFechamento" required>
            </div>

            <div class="form-login">
                <label for="text">Dia Vencimento</label>
                <input type="text" id="diaVencimento" name="diaVencimento" required>
            </div>
            
            <button type="submit" class="login-btn">Cadastrar</button>
        </form>


        
    </div>

    