<?php
setlocale(LC_TIME, 'pt_BR.UTF-8', 'Portuguese_Brazil');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comprador'])){

 $FiltroID = $_POST['comprador'];
 $Filtro = "cc.id_comprador = $FiltroID";
 $listarCompras =  listarComprasFiltro($conn,$Filtro);


}elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cartao'])){

  $FiltroID = $_POST['cartao'];
  $Filtro = "c.id_cartao = $FiltroID";
  $listarCompras =  listarComprasFiltro($conn,$Filtro);
 
 }elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['categoria'])){

  $FiltroID = $_POST['categoria'];
  $Filtro = "cat.id_categoria_cartao = $FiltroID";
  $listarCompras =  listarComprasFiltro($conn,$Filtro);
 
 }else{
$listarCompras = listarCompras($conn);
}




// Obter a data atual
$data_atual = new DateTime();
$mes_atual = $data_atual->format('Y-m');

// Gerar os próximos 12 meses
$proximos_meses = [];
for ($i = 0; $i < 12; $i++) {
    $mes = clone $data_atual;
    $mes->modify("+$i month");
    $proximos_meses[] = $mes->format('Y-m');
}

function calcularFaturas($primeira_fatura, $numero_parcelas, $valor_parcela) {
    $faturas = [];
    if (!empty($primeira_fatura)) {
        $data_inicio = DateTime::createFromFormat('Y-m', $primeira_fatura);
        if ($data_inicio instanceof DateTime) {
            for ($i = 0; $i < $numero_parcelas; $i++) {
                $data_parcela = clone $data_inicio;
                $data_parcela->modify("+$i month");
                $mes_parcela = $data_parcela->format('Y-m');
                $faturas[$mes_parcela] = $valor_parcela;
            }
        }
    }
    return $faturas;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório Financeiro</title>
    <style>
        /* Estilo Geral */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
            color: #333;
        }
        h2 {
            text-align: center;
            color: #0056b3;
            margin-bottom: 30px;
            font-weight: bold;
        }

        /* Tabela */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            font-size: 14px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e0f7fa;
        }



        /* Botão de Exportação */
        .export-btn {
            display: inline-block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
        .export-btn:hover {
            background-color: #0056b3;
        }

        
 /*Oculta colunas específicas em telas menores , ocultas todos os meses menos o
@media (max-width: 768px) {
    th:nth-child(n+8), td:nth-child(n+8) {
        display: none;
    }
}*/


/* Adicione isso ao seu arquivo CSS */
@media (max-width: 768px) {
    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
    th, td {
        min-width: 100px; /* Ajuste conforme necessário */
    }
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
</head>
<body>
    <h2>Relatório de faturas</h2>
  <!--  Botao exportar CSV
    
    <div style="text-align: center;">
        
        <a href="exportar_csv.php" class="export-btn">Exportar para CSV</a>

    </div>
-->

<!-- Ícone de filtro -->
<div class="filter-icon" onclick="toggleDropdown()">🔍 Filtro</div>









  <!-- Menu dropdown -->
  <div class="dropdown-menu" id="dropdownMenu">

  
  <form id="FormularioComprador" action="index.php?pg=cartaoFaturaLista" method="POST">
        <label for="opcoes">Comprador : </label>
        <select id="Comprador" name="comprador">
            <option value="">Selecione...</option>
            <?php $comprador = listarCompradorCartao($conn);
              foreach ($comprador as $compradores){?>
              <option value="<?php echo $compradores['id_comprador'];?>"><?php echo $compradores['comprador'];?></option>  

              <?php }
            
            ?>
        </select>
    </form>

  
    <form id="FormularioCartao" action="index.php?pg=cartaoFaturaLista" method="POST">
        <label for="opcoes">Cartao : </label>
        <select id="Cartao" name="cartao">
            <option value="">Selecione...</option>
            <?php $cartao = listarCartoes($conn);
              foreach ($cartao as $cartoes){?>
              <option value="<?php echo $cartoes['id_cartao'];?>"><?php echo $cartoes['cartao'];?></option>  

              <?php }
            
            ?>
        </select>
    </form>

  
    <form id="FormularioCategoria" action="index.php?pg=cartaoFaturaLista" method="POST">
        <label for="opcoes">Categoria : </label>
        <select id="Categoria" name="categoria">
            <option value="">Selecione...</option>
            <?php $categoria = listarCategoriaCartoes($conn);
              foreach ($categoria as $categorias){?>
              <option value="<?php echo $categorias['id_categoria_cartao'];?>"><?php echo $categorias['categoria_cartao'];?></option>  

              <?php }
            
            ?>
        </select>
    </form>
 

  </div>

    <table>
        <thead>
            <tr>
                <th>Comprador</th>
                <th>Cartão Usado</th>
                <th>Categoria</th>
                <th>Produto</th>
                <?php foreach ($proximos_meses as $mes): ?>
                    <?php
                    // Formatar o mês em português usando IntlDateFormatter
                    $formatter = new IntlDateFormatter(
                        'pt_BR', // Idioma
                        IntlDateFormatter::NONE, // Sem formato de data completo
                        IntlDateFormatter::NONE, // Sem formato de hora
                        NULL,
                        NULL,
                        'MMM/yy' // Formato personalizado
                    );
                    echo "<th>" . $formatter->format(DateTime::createFromFormat('Y-m', $mes)) . "</th>";
                    ?>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
    <?php 
    $totais = array_fill_keys($proximos_meses, 0); // Inicializa um array com meses zerados
    
    foreach ($listarCompras as $compra): 
        $faturas = calcularFaturas(
            $compra['primeira_fatura'],
            $compra['numero_Parcelas'],
            $compra['valor_Parcela']
        );
    ?>
        <tr>
            <td><?= htmlspecialchars($compra['comprador']) ?></td>
            <td><?= htmlspecialchars($compra['cartao']) ?></td>
            <td><?= htmlspecialchars($compra['categoria_cartao']) ?></td>
            <td><?= htmlspecialchars($compra['produto']) ?></td>
            <?php foreach ($proximos_meses as $mes): ?>
                <td>
                    <?php 
                    if (isset($faturas[$mes])) {
                        echo "R$ " . number_format($faturas[$mes], 2, ',', '.');
                        $totais[$mes] += $faturas[$mes]; // Acumula o valor no total
                    } else {
                        echo '-';
                    }
                    ?>
                </td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
    
    <!-- Linha de totalização -->
    <tr style="font-weight: bold; background-color: #d9edf7;">
        <td colspan="4">Total</td>
        <?php foreach ($proximos_meses as $mes): ?>
            <td>R$ <?= number_format($totais[$mes], 2, ',', '.') ?></td>
        <?php endforeach; ?>
    </tr>
</tbody>

                        




    </table>


  
    <script>
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
 const selectElementComprador = document.getElementById('Comprador');
 const selectElementCartao = document.getElementById('Cartao');
 const selectElementCategoria = document.getElementById('Categoria');



// Adiciona um ouvinte de evento para detectar mudanças no <select> Comprador
selectElementComprador.addEventListener('change', function() {
    // Verifica se uma opção válida foi selecionada
    if (this.value !== "") {
        // Envia o formulário automaticamente
        document.getElementById('FormularioComprador').submit();
    }
});

selectElementCartao.addEventListener('change', function() {
      if (this.value !== "") {
      document.getElementById('FormularioCartao').submit();
    }
});

selectElementCategoria.addEventListener('change', function() {
      if (this.value !== "") {
      document.getElementById('FormularioCategoria').submit();
    }
});







    
  </script>
</body>
</html>