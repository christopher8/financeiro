
<?php 



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['despesas'])) {




    // Captura dos dados do formulário
    $id_conta_origem = $_POST['id_conta_origem'];
    $valor = $_POST['valor'];
    $tipo_transacao = 'despesa';
    $descricao_manual = $_POST['descricao_manual'] ?? null;
    $data_transacao = $_POST['data_transacao']; // Captura a data do formulário
    $idcategoria = $_POST['id_categoria']; // id da categoria

// Transação de despesas
    $saldobanco = consultarSaldo($conn,$id_conta_origem) ;
    if($saldobanco >= $valor ){
    transacaoDespesa($conn, $id_conta_origem,$valor,$tipo_transacao,$descricao_manual, $data_transacao,  $idcategoria);
    } else{
    echo "<script>
            alert('SALDO INSUFICIENTE!!!!!!');
            window.location.href = 'index.php?pg=transacoesDespesas';
        </script>";
        }   

}
$contas = listarContas($conn);
$categorias = listarCategoriaDespesa($conn);

?>






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
        background-color: #ffffff;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
    }

    h2 {
        margin-bottom: 1.5rem;
        font-size: 1.5rem;
        color: #333;
        text-align: center;
    }

    label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
        color: #555;
    }

    select,input[type="number"], input[type="text"], input[type="date"] {
        width: 89%;
        padding: 0.75rem;
        margin-bottom: 1rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 1rem;
        color: #333;
        background-color: #f9f9f9;
        transition: border-color 0.3s ease;
    }

    select:focus, input[type="number"]:focus, input[type="text"]:focus {
        border-color: #007bff;
        outline: none;
    }

    button {
        width: 100%;
        padding: 0.75rem;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #0056b3;
    }

    .hidden {
        display: none;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .adicionar_icon img {
    width: 30px; /* Ajuste conforme o tamanho do input */
    height: 30px;
    cursor: pointer;
}
</style>

<div class="form-container">
    <h2>Formulário de Despesas</h2>
    <form action="" method="post">
    <input type="hidden" name="despesas" value="1">
    
    
    

        <div class="form-group">
            <label for="id_conta_origem">Conta de Origem:</label>

            <div style="display: flex; align-items: center; gap: 8px;">
            <select id="id_conta_origem" name="id_conta_origem" required>
<!-- Opções preenchidas dinamicamente com as contas disponíveis -->
        <?php
        // Exemplo de como preencher as opções com PHP
         // Função que retorna as contas do banco de dados
        foreach ($contas as $conta) {
            echo "<option value='{$conta['id_banco']}'>{$conta['banco']} - R$ {$conta['saldo']} </option>";
        }  ?>
        
   
        </select>

        <a href="index.php?pg=bancoCadastro" class="adicionar_icon">
            <img src="icons/adicionar.png" alt="Adicionar usuário">
         </a>

        </div>   
        </div>


        <label>Categoria:</label>
    
    <div style="display: flex; align-items: center; gap: 8px;">
    <select id="id_categoria" name="id_categoria" required>
    <?php      foreach ($categorias as $categoria) {
            echo "<option value='{$categoria['id_categoria']}'>{$categoria['categoria']} </option>";
    }?>
    </select>

    <a href="index.php?pg=transacoesDespesasCategorias" class="adicionar_icon">
        <img src="icons/adicionar.png" alt="Adicionar usuário">
    </a>

    </div>

        <div class="form-group">
            <label for="valor">Valor R$ : </label>
            <input type="number" id="valor" name="valor" step="0.01" required>
        </div>


        <label class="form-group" for="data_transacao">Data da Transação:</label>
        <input  class="form-group" type="date" id="data_transacao" name="data_transacao" value="<?php  echo date('Y-m-d') ?>"  required>


        <div class="form-group" id="descricao_manual_field">
            <label for="descricao_manual">Destino :</label>
            <input type="text" id="descricao_manual" name="descricao_manual">
        </div>

        <button type="submit">Enviar</button>
    </form>
</div>

<script>
    document.getElementById('tipo_transacao').addEventListener('change', function() {
        var tipo = this.value;
        var contaDestinoField = document.getElementById('conta_destino_field');
        var descricaoManualField = document.getElementById('descricao_manual_field');

        if (tipo === 'transferencia') {
            contaDestinoField.classList.remove('hidden');
            descricaoManualField.classList.add('hidden');
        } else if (tipo === 'despesa' || tipo === 'receita' ) {
            contaDestinoField.classList.add('hidden');
            descricaoManualField.classList.remove('hidden');
        }
    });
</script>
