<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_POST['id_usuario'];
    $id_cartao = $_POST['id_cartao'];
    $id_categoria = $_POST['id_categoria'];
    $item = $_POST['item'];
    $valor_Total = $_POST['valor_Total'];
    $numero_Parcelas = $_POST['numero_Parcelas'];
    $valor_Parcela = $valor_Total / $numero_Parcelas;
    $data_compra = $_POST['data_compra'];
    $data_primeiraFatura = $_POST['primeira_fatura'];

    
    compra($conn, $id_usuario, $id_cartao, $id_categoria, $item, $valor_Total, $numero_Parcelas, $valor_Parcela , $data_compra, $data_primeiraFatura);

    
}
?>

    <style> 
    body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

form {
    width: 100%;
    max-width: 400px;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

label {
    font-weight: bold;
    display: block;
    margin-top: 10px;
}

input, select {
    width: 95%;
    padding: 8px;
    margin: 5px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    background-color: #007bff;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    width: 100%;
    margin-top: 10px;
}

button:hover {
    background-color: #0056b3;
}


.adicionar_icon img {
    width: 30px; /* Ajuste conforme o tamanho do input */
    height: 30px;
    cursor: pointer;
}

    </style>
<?php 
    $usuarios = listarCompradorCartao($conn);
    $cartoes = listarCartoes($conn);
    $categorias = listarCategoriaCartoes($conn);
?>


    <form id="fomularioCompras" method="post">




    <label>Comprador:</label>
    
    <div style="display: flex; align-items: center; gap: 8px;">
    <select id="id_usuario" name="id_usuario" required style="flex: 1;">
        <?php foreach ($usuarios as $usuario) {
            echo "<option value='{$usuario['id_comprador']}'>{$usuario['comprador']} </option>";
        } ?>
    </select>
    <a href="index.php?pg=cartaoCompradorCadastro" class="adicionar_icon">
        <img src="icons/adicionar.png" alt="Adicionar usuário">
    </a>
</div>
    
    <label>Cartão de credito :</label>
    




    <div style="display: flex; align-items: center; gap: 8px;">
    <select id="id_cartao" name="id_cartao" required>
    <?php      foreach ($cartoes as $cartao) {
            echo "<option value='{$cartao['id_cartao']}'>{$cartao['cartao']} </option>";
    }?>
    </select>
    <a href="index.php?pg=cartaoCadastro" class="adicionar_icon">
        <img src="icons/adicionar.png" alt="Adicionar usuário">
    </a>

    </div>

    <label>Categoria:</label>
    
    <div style="display: flex; align-items: center; gap: 8px;">
    <select id="id_categoria" name="id_categoria" required>
    <?php      foreach ($categorias as $categoria) {
            echo "<option value='{$categoria['id_categoria_cartao']}'>{$categoria['categoria_cartao']} </option>";
    }?>
    </select>

    <a href="index.php?pg=cartaoComprasCategoria" class="adicionar_icon">
        <img src="icons/adicionar.png" alt="Adicionar usuário">
    </a>

    </div>    


    
        
 
        <label>Item:</label>
        <input type="text" name="item" required>
        
        <label>Valor Total R$</label>
        <input type="number" step="0.01" name="valor_Total" id="valor_Total" required>
        
        <label>Número de Parcelas:</label>
        <input type="number" name="numero_Parcelas" id="numero_Parcelas" required>

        <label>Valor Parcela R$:</label>
        <input type="number" step="0.01" name="valor_Parcela" id="valor_Parcela" readonly>

        <label>Data da Compra:</label>
        <input type="date" name="data_compra"  value="<?php  echo date('Y-m-d') ?>"  required>
        
        <label for="primeira_fatura">Primeira Fatura (Mês/Ano):</label>
        <input type="month" id="primeira_fatura" name="primeira_fatura" required>
        
        
        
        <button type="submit">Cadastrar</button>
    </form>

    <script>
        document.getElementById('valor_Total').addEventListener('input', calcularParcela);
        document.getElementById('numero_Parcelas').addEventListener('input', calcularParcela);
        
        function calcularParcela() {
            let total = parseFloat(document.getElementById('valor_Total').value) || 0;
            let numParcelas = parseInt(document.getElementById('numero_Parcelas').value) || 1;
            
            if (numParcelas > 0) {
                document.getElementById('valor_Parcela').value = (total / numParcelas).toFixed(2);
            }
        }
    </script>
