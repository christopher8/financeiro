<?php
// Conexão ao banco


require_once('config\functions.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['alterar_id'])) {
         $banco = trim($_POST['banco']);
         $agencia = (int) $_POST["agencia"]; // Convertendo para inteiro
         $conta = (int) $_POST["conta"];
         $saldo = floatval($_POST["saldo"]);
         $id = intval($_POST['alterar_id']); // ID do usuário a ser alterado
        // Chamando a função de alteração
        if (alterarBancos($conn, $id, $banco, $agencia, $conta, $saldo)) {
            echo "<script>
                alert('banco com ID {$id} foi alterado com sucesso.');
                window.location.href = 'index.php?pg=bancoLista';
            </script>";
        } else {
            echo "<script>
                alert('Erro ao tentar alterar o banco com ID {$id}.');
            </script>";
        }
}



// Obtém o ID enviado via GET
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Busca o usuário para preencher os campos
    $sql = "SELECT * FROM banco WHERE id_banco = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $banco = $result->fetch_assoc();

    if (!$banco) {
        echo "banco não encontrado.";
        exit;
    }
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
    
    

<div class="container">
    <h2>Alterar dados Bancario</h2>
    <form id="bancoForm" action="" method="POST" onsubmit="return validarFormulario()">
    <input type="hidden" name="alterar_id" value="<?php echo $banco['id_banco']; ?>">
        <input type="text" name="banco" placeholder="Nome do Banco" value="<?php echo $banco['banco']; ?>" required>
        <input type="text" name="agencia" placeholder="Agência" value="<?php echo $banco['agencia']; ?>" required>
        <input type="text" name="conta" placeholder="Conta" value="<?php echo $banco['conta']; ?>" required>
        <input type="number" step="0.01" name="saldo" placeholder="Saldo" value="<?php echo $banco['saldo']; ?>" required min="0">
        <button type="submit">Alterar</button>

        <a href="index.php?pg=bancoLista">
            <button type="button" class="cancelar">Voltar</button>
        </a>

    </form>
</div>

<script>
function validarFormulario() {
    const saldo = parseFloat(document.querySelector('[name="saldo"]').value);
    if (saldo < 0 || isNaN(saldo)) {
        alert("O saldo não pode ser negativo ou inválido.");
        return false;
    }
    return true;
}
</script>
  

