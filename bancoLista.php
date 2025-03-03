<?php 
// Verifica se um ID foi enviado para exclusão
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir_id'])) {
    $id = intval($_POST['excluir_id']);
    if (excluirBanco($conn, $id)) {
        
        echo "<script>alert('Conta com ID {$id} foi excluido com sucesso ')</script>";

    } else {
        echo "Erro ao tentar excluir o Banco.";
    }
}


$bancos = listarContas($conn)



?>


    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        .tabela {
            display: flex;
            flex-direction: column;
            width: 100%;
            max-width:1000px;
            margin: auto;
            border: 1px solid #ddd;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .cabecalho, .linha {
            display: flex;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .cabecalho {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        .linha:nth-child(even) {
            background-color: #f2f2f2;
        }
        .coluna {
            flex: 1;
            text-align: center;
        }
        .coluna.acao button {
            background-color: transparent;
            border: none;
            color:  #007bff;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }
        .coluna.acao button:hover {
            text-decoration: underline;
        }
    </style>


<div class="tabela">
    <!-- Cabeçalho da Tabela -->
    <div class="cabecalho">
        
        <div class="coluna">Banco</div>
        <div class="coluna">Agencia</div>
        <div class="coluna acao">Conta</div>
        <div class="coluna acao">Saldo</div>
        <div class="coluna acao">Alterar</div>
        <div class="coluna acao">Excluir</div>

    </div>
    

    <?php if (!empty($bancos)): ?>
    <?php $STotal = 0; // Inicializa $STotal com 0 ANTES do loop ?>
    <?php foreach ($bancos as $banco): ?>
        <?php $STotal += $banco['saldo']; ?>

        <div class="linha">
        
            <div class="coluna"><?php echo htmlspecialchars($banco['banco']); ?></div>
            <div class="coluna"><?php echo htmlspecialchars($banco['agencia']); ?></div>
            <div class="coluna"><?php echo htmlspecialchars($banco['conta']); ?></div>
            <div class="coluna"> <?php echo 'R$ '.htmlspecialchars($banco['saldo']); ?></div>

            <div class="coluna acao">
                <form method="GET" action="bancoEditar.php">
                    <input type="hidden" name="id" value="<?php echo $banco['id_banco']; ?>">
                    <button type="submit">Alterar</button>
                </form>
            </div>
            <div class="coluna acao">
                <form method="POST" action="">
                    <input type="hidden" name="excluir_id" value="<?php echo $banco['id_banco']; ?>">
                    <button type="submit" onclick="return confirm('Deseja realmente excluir o banco?');">Excluir</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="linha">
        <div class="coluna" colspan="5">Nenhum Banco encontrado.</div>
    </div>
<?php endif; ?>
<div class="linha">Saldo Total - R$ <?php if (isset($STotal)) echo number_format($STotal, 2, ',', '.'); // Formata para moeda ?></div>





<script>
    function alterarbancos(id) {
        alert('Função para alterar o cartao ' + id + ' pode ser implementada aqui.');
    }

    function excluirBanco(id) {
        if (confirm('Deseja realmente excluir o banco ' + id + '?')) {
            alert('Função para excluir o banco ' + id + ' pode ser implementada aqui.');
        }
    }
</script>

</body>
</html>