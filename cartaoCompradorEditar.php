<?php
// Conexão ao banco


require_once('config\functions.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['alterar_id'])) {
    $id = intval($_POST['alterar_id']); // ID do usuário a ser alterado
    $novoUser = trim($_POST['novoUser']); // Novo nome de usuário
    $ativo = intval($_POST['ativo']); // Novo status de ativo (1 ou 0)

    // Chamando a função de alteração
    if (alterarCompradorCartao($conn, $id, $novoUser, $ativo)) {
        echo "<script>alert('Usuario com ID {$id} foi Alterado com sucesso ')
               window.location.href = 'index.php?pg=listarCompradorCartao';  </script>";
            
        
    } else {
        echo "<script>alert('Usuario com ID {$id} Erro ao tentar alterar o usuário. ')
            window.location.href = 'index.php?pg=listarCompradorCartao';
        </script>";
    }
}




// Obtém o ID enviado via GET
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Busca o usuário para preencher os campos
    $sql = "SELECT * FROM cartao_comprador WHERE id_comprador = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();

    if (!$usuario) {
        echo "Usuário não encontrado.";
        exit;
    }
}




?>


    <style>
        body{
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-alteracaco-usuario {
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

</body>
    <div class="form-alteracaco-usuario">
        <h1>Editar Usuário</h1>
        <form method="POST" action="">
            <input type="hidden" name="alterar_id" value="<?php echo $usuario['id_comprador']; ?>">
            
            <label for="novoUser">Novo Usuário:</label>
            <input type="text" name="novoUser" id="novoUser" value="<?php echo htmlspecialchars($usuario['comprador']); ?>" required>
                    
            <label for="ativo">Ativo:</label>
            
            <select name="ativo" id="ativo">
                <option value="1" <?php echo $usuario['ativo'] == 1 ? 'selected' : ''; ?>>Sim</option>
                <option value="0" <?php echo $usuario['ativo'] == 0 ? 'selected' : ''; ?>>Não</option>
            </select>
            
            <button type="submit">Alterar</button>

            <a href="index.php?pg=cartaoCompradorLista">
                <button type="button" class="cancelar">Voltar</button>
            </a>

        </form>
    </div>

</body>
