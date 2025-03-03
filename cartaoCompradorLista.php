<?php 
    // Verifica se um ID foi enviado para exclusão
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir_id'])) {
        $id = intval($_POST['excluir_id']);
        if (excluirCompradorCartao($conn, $id)) {
            
            echo "<script>alert('Usuario com ID {$id} foi excluido com sucesso ')</script>";

        } else {
            echo "Erro ao tentar excluir o usuário.";
        }
    }


    $usuarios = listarCompradorCartao($conn);


    ?>

<body class = "usuarioLista" >
    
        <div class="tabela" style="width:100%; max-width:1000px;">
        <!-- Cabeçalho da Tabela -->
        <div class="cabecalho">
            
            <div class="coluna">Usuário</div>
            <div class="coluna">Ativo</div>
            <div class="coluna acao">Alterar</div>
            <div class="coluna acao">Excluir</div>
        </div>
    

        <!-- Listagem de Usuários -->
        <?php if (!empty($usuarios)): ?>
            <?php foreach ($usuarios as $usuario): ?>
                <div class="linha">
                    
                    <div class="coluna"><?php echo htmlspecialchars($usuario['comprador']); ?></div>
                    <div class="coluna"><?php echo $usuario['ativo'] ? 'Sim' : 'Não'; ?></div>
                    <div class="coluna acao">
                        <form method="GET" action="index.php">
                        <input type="hidden" name="pg" value="cartaoCompradorEditar">    
                        <input type="hidden" name="id" value="<?php echo $usuario['id_comprador']; ?>">
                            
                            <button type="submit">Alterar</button>
                        </form>
                    </div>
                    <div class="coluna acao">
                        <form method="POST" action="">
                            <input type="hidden" name="excluir_id" value="<?php echo $usuario['id_comprador']; ?>">
                            <button type="submit" onclick="return confirm('Deseja realmente excluir o usuário?');">Excluir</button>
                        </form>
                    </div>

                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="linha">
                <div class="coluna" colspan="5">Nenhum usuário encontrado.</div>
            </div>
        <?php endif; ?>
        <div class="linha" style="display: flex; justify-content: space-between;">
    <div class="adicionar" style="display: flex; margin-left: auto; padding-right: 8%;">
        <div class="coluna acao">
            <form method="POST" action="index.php?pg=cartaoCadastro">
                <button type="submit">Adicionar</button>
            </form>
        </div>
    </div>
</div>



</body>



<script>
    function alterarUsuario(id) {
        alert('Função para alterar o usuário ' + id + ' pode ser implementada aqui.');
    }

    function excluirUsuario(id) {
        if (confirm('Deseja realmente excluir o usuário ' + id + '?')) {
            alert('Função para excluir o usuário ' + id + ' pode ser implementada aqui.');
        }
    }
</script>

</body>
</html>