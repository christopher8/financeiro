<?php 
// Verifica se um ID foi enviado para exclusão
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir_id'])) {
    $id = intval($_POST['excluir_id']);
    if (excluirDividas($conn, $id)){
        
        echo "<script>alert('divida com ID {$id} foi excluido com sucesso ')</script>";

    } else {
        echo "Erro ao tentar excluir a divida.";
    }
}





$dividas = listarDividas($conn);


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
        
        <div class="coluna">Devedor</div>
        <div class="coluna">Valor </div>
        <div class="coluna">Data prevista </div>
        <div class="coluna acao">Alterar</div>
        <div class="coluna acao">Excluir</div>
    </div>
    

    <!-- Listagem de Usuários -->
    <?php if (!empty($dividas)): ?>
        <?php $STotal = 0; // Inicializa $STotal com 0 ANTES do loop ?>
        <?php foreach ($dividas as $dividass): ?>
            <?php $STotal += $dividass['valor']; ?>
            <div class="linha">
                
                <div class="coluna"><?php echo htmlspecialchars($dividass['divida']); ?></div>
                <div class="coluna"><?php echo htmlspecialchars($dividass['valor']);?></div>
                <div class="coluna"><?php echo htmlspecialchars($dividass['data_prevista']);?></div>
                <div class="coluna acao">
                    <form method="post" action="dividaPagar.php">
                        <input type="hidden" name="id" value="<?php echo $dividass['id_divida']; ?>">
                        <button type="submit">Pagar</button>
                    </form>
                </div>
                <div class="coluna acao">
                    <form method="post" action="dividaEditar.php">
                        <input type="hidden" name="id" value="<?php echo $dividass['id_divida']; ?>">
                        <button type="submit">Alterar</button>
                    </form>
                </div>
                <div class="coluna acao">
                    <form method="POST" action="">
                        <input type="hidden" name="excluir_id" value="<?php echo $dividass['id_divida']; ?>">
                        <button type="submit" onclick="return confirm('Deseja realmente excluir essa divida ?');">Excluir</button>
                    </form>
                </div>

            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="linha">
            <div class="coluna" colspan="5">Nenhuma divida a receber encontrado.</div>
        </div>
    <?php endif; ?>

    <div class="linha" style="display: flex; justify-content: space-between;">
        <div class="saldo"> Saldo Total - R$ <?php if (isset($STotal)) echo number_format($STotal, 2, ',', '.'); // Formata para moeda ?></div>
        
        <div class="adicionar" style=" padding-right: 5%"> <div class="coluna acao">
                    <form method="POST" action="index.php?pg=dividaAPagar">
                        <button type="submit">Adicionar</button>
                    </form>
                </div></div>

</div>
    
</div>





</body>
</html>