<?php
// Conexão ao banco


require_once('config\functions.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['alterar_id'])) {
    $id = intval($_POST['alterar_id']); // ID do usuário a ser alterado
    $cartao = trim($_POST['cartao']); // Novo nome de usuário
    $limite = (int) $_POST["limite"]; // Convertendo para inteiro
    $diaFechamento = (int) $_POST["diaFechamento"];
    $diaVencimento = (int) $_POST["diaVencimento"];
    
        // Chamando a função de alteração
        if (alterarCartao($conn, $id, $cartao, $limite, $diaFechamento, $diaVencimento)) {
            echo "<script>
                alert('Cartão com ID {$id} foi alterado com sucesso.');
                window.location.href = 'index.php?pg=cartaoLista';
            </script>";
        } else {
            echo "<script>
                alert('Erro ao tentar alterar o cartão com ID {$id}.');
                window.location.href = 'index.php?pg=cartaoLista';
            </script>";
        }
}



// Obtém o ID enviado via GET
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Busca o usuário para preencher os campos
    $sql = "SELECT * FROM cartao WHERE id_cartao = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $cartao = $result->fetch_assoc();

    if (!$cartao) {
        echo "Cartao não encontrado.";
        exit;
    }
}




?>


    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px 30px;
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
        }
        h1 {
            font-size: 24px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
        }
        input[type="text"], select {
            font-size: 16px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            margin-bottom: 15px;
            width: 100%;
            box-sizing: border-box;
            background-color: #fdfdfd;
        }

        input[type="password"], select {
            font-size: 16px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            margin-bottom: 15px;
            width: 100%;
            box-sizing: border-box;
            background-color: #fdfdfd;
        }
        input[type="text"]:focus, select:focus {
            border-color: #007bff;
            outline: none;
            background-color: #fff;
        }
        input[type="password"]:focus, select:focus {
            border-color: #007bff;
            outline: none;
            background-color: #fff;
        }
        button {
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            padding: 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
                }
        button:hover {
            background-color: #0056b3;
        }
        .cancelar {
            background-color: #007bff;
            margin-top: 10px;
        }
        .cancelar:hover {
            background-color: #0056b3;
        }
    </style>


<div class="container">
    <h1>Editar Cartao</h1>
    <form method="POST" action="">


        <label for="novoUser">ID:</label>
        <input type="text" name="alterar_id" value="<?php echo $cartao['id_cartao']; ?>">

        <div class="form-login">
                <label for="text">Cartao:</label>
                <input type="text" id="cartao" value="<?php echo htmlspecialchars($cartao['cartao']); ?>" name="cartao" required>
            </div>

            <div class="form-login">
                <label for="text">Limite:</label>
                <input type="text" id="limite" value="<?php echo htmlspecialchars($cartao['limite']); ?>" name="limite" required>
            </div>

            <div class="form-login">
                <label for="text">Dia Fechamento:</label>
                <input type="text" id="diaFechamento" value="<?php echo htmlspecialchars($cartao['fechamento']); ?>" name="diaFechamento" required>
            </div>

            <div class="form-login">
                <label for="text">Dia Vencimento</label>
                <input type="text" id="diaVencimento" value="<?php echo htmlspecialchars($cartao['vencimento']); ?>" name="diaVencimento" required>
            </div>
            
                   
        
        <button type="submit">Alterar</button>

        <a href="index.php?pg=cartaoLista">
            <button type="button" class="cancelar">Voltar</button>
        </a>

    </form>
</div>

</body>
</html>