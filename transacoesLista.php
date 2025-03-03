<?php 
// Verifica se um ID foi enviado para exclusão
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir_id'])) {
    
    $id = intval($_POST['excluir_id']);
    
    // excluir transacao revertera a transacao, antes de excluir voltara com o saldo

    // pegando valor e id da conta de origem para que possa ser devolvido valor a conta de origem
    $pegarIDeValor = listaTransacaoPorID($conn, $id);
    
    
    foreach ($pegarIDeValor as $idValor){

        
        $id_conta_origem = $idValor['id_conta_origem'];
        $id_conta_destino = $idValor['id_conta_destino'];
        $id_categoria = 0;
        $id_transacao = $idValor['id_transacao'];
        $valor = $idValor['valor'];
        $data_transacao =  $idValor['data_transacao'];;
        $descricao_manual = ' - ';
        $tipo_transacao =$idValor['tipo_transacao'];
        $devedor = $idValor['local_transacao'];
        
    }
    

    if( $tipo_transacao == 'despesa'){
    // se for despesa 		( receita adicionar dinheiro na conta de origem , tipo transacao = estorno, local null, data, valor, id_categoria = 0, id_conta_destino = null)
        $id_conta_destino = NULL;
        $tipo_transacao ='estorno';
        transacaoEstornoDespesa($conn,$id_conta_origem, $id_categoria,  $valor, $data_transacao, $descricao_manual, $tipo_transacao, $id_transacao);

    }elseif($tipo_transacao == 'receita'){
        $tipo_transacao ='estorno';
    // se for receita 		( despesa remover dinheiro da conta de origem, tipo transacao = estorno, local null, data , valor , id_categoria = 0, id_conta_destino = null)

        transacaoEstornoReceita($conn,$id_conta_origem, $id_conta_destino, $valor, $data_transacao, $tipo_transacao, $descricao_manual, $id_categoria,$id_transacao );
    }elseif($tipo_transacao == 'receita_divida'){
        $devedor = $devedor." ESTORNO";        
        $data_prevista = $data_transacao;
        $tipo_transacao ='estorno';

        cadastrarValorAReceber($conn , $devedor, $valor, $data_prevista );
        $idcategoria = 0;
        transacaoDespesa($conn, $id_conta_origem,$valor,$tipo_transacao,$descricao_manual, $data_transacao,  $idcategoria);



        
    }else{
    // se for transferencia( dinheiro sai da conta de destino, dinheiro entra  na conta de origem, id_conta_destino, id_conta_origem, tipo transacao = estorno, local null , data, valor , id_categoria = 0)
        $tipo_transacao ='estorno';
        transacaoEstornoTransferencia($conn,$id_conta_origem, $id_conta_destino, $valor, $data_transacao, $tipo_transacao, $descricao_manual, $id_categoria , $id_transacao );
    }




    /*
    
    // Finalmente excluindo a transacao
    if (excluirTransacao($conn, $id)) {
        
        echo "<script>alert('Transação com ID {$id} foi excluido com sucesso ')</script>";

    } else {
        echo "Erro ao tentar excluir o Transação.";
    }*/
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['data'])){

   $FiltroID = $_POST['data'];
   $filtro = "data_transacao = '$FiltroID'";
    $transacao=  listartransacoesFiltro($conn,$filtro);
   
   
   }elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['origem'])){

    $FiltroID = $_POST['origem'];
    $filtro = "id_conta_origem = '$FiltroID'";
    $transacao=  listartransacoesFiltro($conn,$filtro);
    
    }elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipo'])){
        $FiltroID = $_POST['tipo'];
        $filtro = "tipo_transacao = '$FiltroID'";
         $transacao=  listartransacoesFiltro($conn,$filtro);
    
    }elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['categoria'])){
        $FiltroID = $_POST['categoria'];
        $filtro = "id_categoria = '$FiltroID'";
        $transacao=  listartransacoesFiltro($conn,$filtro);
    
    }else{
        $transacao = listartransacoes($conn);
   }





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
        .cabecalho, .linha:hover{
            background-color: #e0f7fa
        } 
        .cabecalho {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        .linha:nth-child(even) {
            background-color: #f2f2f2;
        }
        .linha:nth-child(even):hover {
            background-color: #e0f7fa;
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


        .filter-icon {
      cursor: pointer;
      font-size: 24px;
      color: #007bff;
      margin-bottom: 10px;
      display: inline-block;
    }

    .dropdown-menu {
      display: none;
      position: absolute;
      background-color: #fff;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 15px;
      z-index: 1000;
      width: 300px;
    }

    .dropdown-menu select {
      width: 100%;
      padding: 8px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .dropdown-menu button {
      width: 100%;
      padding: 10px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .dropdown-menu button:hover {
      background-color: #0056b3;
    }

    .list {
      margin-top: 20px;
    }

    .list ul {
      list-style-type: none;
      padding: 0;
    }

    .list li {
      padding: 10px;
      border-bottom: 1px solid #ccc;
    }
    </style>



<div class="filter-icon" onclick="toggleDropdown()">🔍 Filtro</div>

<!-- Menu dropdown -->
<div class="dropdown-menu" id="dropdownMenu">
<?php $contas = listarContas($conn); ?>

<form id="FormularioOrigem" action="index.php?pg=transacoesLista" method="post">
      <label for="Origem">Origem : </label>
      <select id="Origem" name="origem">
          <option value="">Selecione...</option>
          
          <?php
            foreach ($contas as $conta){?>
                <option value="<?php echo $conta['id_banco'];?>"><?php echo $conta['banco'];?></option>  
            <?php }
          
          ?>
      </select>
  </form>

  <form id="FormularioCategoria" action="index.php?pg=transacoesLista" method="POSt">
      <label for="Categoria">Categoria : </label>
      <select id="Categoria" name="categoria">
          <option value="">Selecione...</option>
          
          <?php
            $categoria = listarCategoriaDespesa($conn);
            foreach ($categoria as $categorias){?>
                <option value="<?php echo $categorias['id_categoria'];?>"><?php echo $categorias['categoria'];?></option>  
            <?php }
          
          ?>
      </select>
  </form>


  <form id="FormularioTipo" action="index.php?pg=transacoesLista" method="POST">
      <label for="tipo">Tipo : </label>
      <select id="Tipo" name="tipo">
          <option value="">Selecione...</option>
          <option value="transferencia">Transferencia</option>
          <option value="despesa">Despesa</option>
          <option value="receita">Receita</option>
          <option value="receita_divida">Receita Divida</option>
          
      </select>
  </form>


  <form id="FormularioData" action="index.php?pg=transacoesLista" method="POST">
      <label for="data">Data : </label>
      <input type="date" id="Data" name="data">
      
      
      </select>
  </form>





</div>


<div class="tabela">
    <!-- Cabeçalho da Tabela -->
    <div class="cabecalho">
        
        <div class="coluna">Origem</div>
        <div class="coluna">Destino</div>
        <div class="coluna acao">Valor</div>
        <div class="coluna acao">Data</div>
        <div class="coluna acao">Tipo</div>
        <div class="coluna acao">Excluir</div>
    </div>
    

    <?php if (!empty($transacao)): ?>
    
    <?php foreach ($transacao as $transacoes): ?>
        

        <div class="linha">


            
            
            <div class="coluna"><?php echo htmlspecialchars(pegarNomeBanco($conn, $transacoes['id_conta_origem'])); ?></div>
            <?php 
                if ($transacoes['tipo_transacao'] == 'transferencia'){?>
                 <div class="coluna"><?php echo htmlspecialchars(pegarNomeBanco($conn, $transacoes['id_conta_destino'])); ?></div>  <?php     }    ?>
            <?php 
                if (($transacoes['tipo_transacao'] == 'despesa') ||($transacoes['tipo_transacao'] == 'receita') || ($transacoes['tipo_transacao'] == 'receita_divida') || $transacoes['tipo_transacao'] == 'estorno'){?>
                 <div class="coluna"> <?php echo htmlspecialchars($transacoes['local_transacao']); ?></div>  <?php     }    ?>   
                     
          
               

            <div class="coluna"><?php echo 'R$ '.htmlspecialchars($transacoes['valor']); ?></div>
            <div class="coluna"> <?php echo htmlspecialchars($transacoes['data_transacao']); ?></div>
            <div class="coluna"> <?php echo htmlspecialchars($transacoes['tipo_transacao']); ?> - </div>
           
           
            <?php if($transacoes['tipo_transacao'] != 'estorno'){?>
            <div class="coluna acao">
                <form method="POST" action="">
                    <input type="hidden" name="excluir_id" value="<?php echo $transacoes['id_transacao']; ?>">
                    <button type="submit" onclick="return confirm('Deseja realmente Excluir a transação?');">Excluir Transação</button>
                </form>
            </div>
            <?php } else { ?>
            <div class="coluna acao">
                <form "">
                     <label> - </label>
                </form>
            </div>   <?php } ?>




        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="linha">
        <div class="coluna" colspan="5">Nenhuma transação encontrado.</div>
    </div>
<?php endif; ?>






<script>
    function alterarbancos(id) {
        alert('Função para alterar o cartao ' + id + ' pode ser implementada aqui.');
    }

    function excluirBanco(id) {
        if (confirm('Deseja realmente excluir a transacao ' + id + '?')) {
            alert('Função para excluir o banco ' + id + ' pode ser implementada aqui.');
        }
    }



    document.addEventListener("DOMContentLoaded", function () {
        const linhas = document.querySelectorAll(".linha");
        const linhasPorPagina = 15;
        let paginaAtual = 1;
        const totalPaginas = Math.ceil(linhas.length / linhasPorPagina);
        
        function mostrarPagina(pagina) {
            let inicio = (pagina - 1) * linhasPorPagina;
            let fim = inicio + linhasPorPagina;
            
            linhas.forEach((linha, index) => {
                linha.style.display = (index >= inicio && index < fim) ? "flex" : "none";
            });
        }
        
        function criarPaginacao() {
            const paginacaoDiv = document.createElement("div");
            paginacaoDiv.className = "paginacao";
            paginacaoDiv.style.textAlign = "center";
            paginacaoDiv.style.marginTop = "20px";
            
            for (let i = 1; i <= totalPaginas; i++) {
                let botao = document.createElement("button");
                botao.textContent = i;
                botao.style.margin = "5px";
                botao.style.padding = "10px 15px";
                botao.style.border = "none";
                botao.style.borderRadius = "5px";
                botao.style.backgroundColor = "#007bff";
                botao.style.color = "white";
                botao.style.cursor = "pointer";
                botao.style.fontSize = "16px";
                
                botao.addEventListener("click", function () {
                    paginaAtual = i;
                    mostrarPagina(paginaAtual);
                    document.querySelectorAll(".paginacao button").forEach(btn => btn.style.backgroundColor = "#007bff");
                    botao.style.backgroundColor = "#0056b3";
                });
                
                paginacaoDiv.appendChild(botao);
            }
            
            document.querySelector(".tabela").appendChild(paginacaoDiv);
        }
        
        if (totalPaginas > 1) {
            mostrarPagina(paginaAtual);
            criarPaginacao();
        }
    });




    // Função para alternar a visibilidade do menu dropdown
    function toggleDropdown() {
      const dropdown = document.getElementById('dropdownMenu');
      if (dropdown.style.display === 'block') {
        dropdown.style.display = 'none';
      } else {
        dropdown.style.display = 'block';
      }
    }

    // Adicionar um listener para esconder o menu quando clicar fora
    document.addEventListener('click', function(event) {
      const dropdown = document.getElementById('dropdownMenu');
      const filterIcon = document.querySelector('.filter-icon');

      if (!dropdown.contains(event.target) && !filterIcon.contains(event.target)) {
        dropdown.style.display = 'none';
      }
    });


   // menu de filtro

 // Seleciona o elemento <select>
 const selectElementCategoria = document.getElementById('Categoria');
 const selectElementOrigem = document.getElementById('Origem');
 const selectElementTipo = document.getElementById('Tipo');
 const dataElementData = document.getElementById('Data');
 



// Adiciona um ouvinte de evento para detectar mudanças no <select> Comprador
selectElementOrigem.addEventListener('change', function() {
    // Verifica se uma opção válida foi selecionada
    if (this.value !== "") {
        // Envia o formulário automaticamente
        document.getElementById('FormularioOrigem').submit();
    }
});

selectElementTipo.addEventListener('change', function() {
      if (this.value !== "") {
      document.getElementById('FormularioTipo').submit();
    }
});

dataElementData.addEventListener('change', function() {
      if (this.value !== "") {
      document.getElementById('FormularioData').submit();
    }
});

selectElementCategoria.addEventListener('change', function() {
      if (this.value !== "") {
      document.getElementById('FormularioCategoria').submit();
    }
});


</script>

