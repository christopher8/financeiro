<!-- TôNoVerde -->
<?php
 require_once('config\functions.php');



session_start(); // Inicia a sessão
/*
 //Verifica se o usuário está logado
if (!isset($_SESSION["username"])) {
    header("Location: login.php"); // Redireciona para login se não estiver autenticado
    exit;
}

*/
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Controle de Finanças</title>
  <link rel="stylesheet" href="style\styles.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>


<body>
  <header class="header">
    <?php include_once('header.php');?> 
  </header>

    <?php 
    if (!isset($_GET['pg'])){;
    include 'home.php';
    
      }else{
        // nao ira aparecer menu na pagina inicial(home)
      include 'menu.php';

      switch ($_GET['pg']) { 
        case 'Home': include 'home.php'; break;
        case 'cartaoCompradorCadastro': include 'cartaoCompradorCadastro.php'; break;
        case 'cartaoCompradorLista': include 'cartaoCompradorLista.php'; break;  
        case 'cartaoCompradorEditar': include 'cartaoCompradorEditar.php'; break;  

        case 'cartaoCadastro': include 'cartaoCadastro.php'; break;
        case 'cartaoLista': include 'cartaoLista.php'; break;
        case 'cartaoComprasCategoria': include 'cartaoComprasCategoria.php'; break;

        case 'cartaoCompras': include 'cartaoCompras.php'; break;
        case 'cartaoFaturaLista': include 'cartaoFaturaLista.php'; break;

        case 'bancoCadastro': include 'bancoCadastro.php'; break;
        case 'bancoLista': include 'bancoLista.php'; break;

        case 'transacoesDespesas': include 'transacoesDespesas.php'; break;
        case 'transacoesDespesasCategorias': include 'transacoesDespesasCategorias.php'; break;
        
        case 'transacoesReceitas': include 'transacoesReceitas.php'; break;
        case 'transacoesLista': include 'transacoesLista.php'; break;
        case 'transacoesTransferencia': include 'transacoesTransferencia.php'; break;


        case 'dividaAPagar': include 'dividaAPagar.php'; break;
        case 'proventoAReceber': include 'proventoAReceber.php'; break;

        case 'proventoAReceberLista': include 'proventoAReceberLista.php'; break;
        case 'dividaAPagarLista': include 'dividaAPagarLista.php'; break;
        
        case 'toDoLista': include 'toDOLista.php'; break;
          }
        }

    ?>


  <footer class="footer">
    <p>Controle de Finanças © 2025</p>
  </footer>

  <script>
    const menuToggle = document.querySelector(".menu-toggle");
    const menu = document.querySelector(".menu");

    menuToggle.addEventListener("click", () => {
      menu.classList.toggle("menu-visible");
    });

  </script>


</body>
</html>
