<?php 
// Verifica se um ID foi enviado para exclusão
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir_id'])) {
    $id = intval($_POST['excluir_id']);
    if (excluirCartao($conn, $id)) {
        
        echo "<script>alert('Cartao com ID {$id} foi excluido com sucesso ')</script>";

    } else {
        echo "Erro ao tentar excluir o cartao.";
    }
}


$cartoes = listarCartoes($conn);



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
        
        <div class="coluna">Cartão</div>
        <div class="coluna">limite</div>
        <div class="coluna">limite disponivel</div>
        <div class="coluna acao">Dia Fechamento</div>
        <div class="coluna acao">Dia Vencimento</div>
        <div class="coluna acao">Alterar</div>
        <div class="coluna acao">Excluir</div>

    </div>
    

    <!-- Listagem de Usuários -->
    <?php if (!empty($cartoes)): ?>
        <?php foreach ($cartoes as $cartao):   ?>
            <div class="linha">
        
            <div class="coluna"><?php echo htmlspecialchars($cartao['cartao']); ?></div>
            <div class="coluna"><?php echo 'R$ '.htmlspecialchars($cartao['limite']); ?></div>
            <div class="coluna"><?php echo 'R$ '.htmlspecialchars($cartao['limite_disponivel']); ?></div>
            <div class="coluna"><?php echo htmlspecialchars($cartao['fechamento']); ?></div>
            <div class="coluna"><?php echo htmlspecialchars($cartao['vencimento']); ?></div>
            
            <div class="coluna acao">
                   <form method="GET" action="cartaoEditar.php">
                    <input type="hidden" name="id" value="<?php echo $cartao['id_cartao']; ?>">
                    <button type="submit">Alterar</button>
                    </form>
            </div>
            <div class="coluna acao">
                   <form method="POST" action="">
                       <input type="hidden" name="excluir_id" value="<?php echo $cartao['id_cartao']; ?>">
                       <button type="submit" onclick="return confirm('Deseja realmente excluir o Cartao?');">Excluir</button>
                   </form>
            </div>

            
            </div>

        <?php endforeach; ?>
        
    <?php else: ?>
        <div class="linha">
            <div class="coluna" colspan="5">Nenhum cartão encontrado.</div>
        </div>
    <?php endif; ?>


    <div class="linha" style="display: flex; justify-content: space-between;">


     
    
     <div class="adicionar" style=" padding-right: 5%"> <div class="coluna acao">
                    <form method="POST" action="index.php?pg=cartaoCadastro">
                        <button type="submit">Adicionar</button>
                    </form>
     </div>
    
     
    </div>
</div>
    




</body>
</html>