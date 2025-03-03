<?php 

$toDoCategoria = listaToDoCategoria($conn);
$listaToday = listaToDoHoje($conn);
$listaAtrasado = listaToDoAtradado($conn);
$id_categoria = 1;
$listaRotina = listaToDoItensRotina($conn, $id_categoria);



// se opcao incluir categoria
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['incluirCategoria'])){
    echo 'incluir categoria';
}
// se opcao editar categoria
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editarCategoria'])){
    echo 'editar categoria';
}
// se opcao exluir categoria
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluirCategoria'])){
    echo 'excluir categoria';
}
// se opcao incluir  item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['incluirItem'])){
    echo 'incluir Item';
}



// se opcao incluir item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['concluirItem'])){
    echo 'item concluido';
}
// se opcao editar item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editarItem'])){
    echo 'editar Item';
}
// se opcao exluir item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluirItem'])){
    echo 'excluir Item';
}

?>

<style>
/* Reset de margens e preenchimentos */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    color: #333;
}

.main {
    width: 100%;
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
}

/* Cabeçalho */
.topo {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #2196F3;
    color: white;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.titulo {
    font-size: 24px;
    font-weight: bold;
}

.incluir button {
    background-color: #fff;
    color: #2196F3;
    border: 1px solid #2196F3;
    padding: 8px 20px;
    border-radius: 5px;
    cursor: pointer;
}

.incluir button:hover {
    background-color: #2196F3;
    color: white;
}

/* Lista de categorias */
.listaCategoria {
    margin-top: 20px;
}

/* Títulos de categorias */
.categoriaTitulo {
    background-color: #2196F3;
    color: white;
    padding: 10px 15px;
    border-radius: 5px;
    margin: 10px 0;
    cursor: pointer;
    font-weight: bold;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.categoriaTitulo:hover {
    background-color: #1976D2;
}

/* Itens dentro de cada categoria */
.categoriaiTem {
    display: none;
    margin-left: 20px;
    padding: 10px;
    background-color: #f2f2f2;
    border-radius: 5px;
    margin-bottom: 10px;
}

/* Lista de itens dentro da categoria */
.categoriaiTem ul {
    list-style-type: none;
}

/* Cada item de tarefa */
.categoriaiTem li {
    display: flex;  /* Faz com que o item e os botões fiquem na mesma linha */
    justify-content: space-between;  /* Espaço entre item e botões */
    padding: 5px 0;
    align-items: center;
}

/* Alterna o fundo entre os itens */
.categoriaiTem li:nth-child(even) {
    background-color:#f2f2f2; /* Cor de fundo mais clara */
    border-radius: 5px;
}

.categoriaiTem li:nth-child(odd) {
    background-color:#f9f9f9; /* Cor de fundo um pouco mais escura */
    border-radius: 5px;
}

/* Botões de ação dentro do item */
.botaoContainer {
    display: flex;
    gap: 10px;
}

.botaoContainer button {
    background-color: #fff;
    color: #2196F3;
    border: 1px solid #2196F3;
    padding: 6px 15px;
    border-radius: 5px;
    cursor: pointer;
}

.botaoContainer button:hover {
    background-color: #2196F3;
    color: white;
}

/* MODAL */

/* Estilização do fundo escuro */
.modal {
    display: none; /* Oculto por padrão */
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
}

/* Estilização do conteúdo do modal */
.modal-content {
    background-color: #fff;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 40%;
    text-align: center;
}

/* Botão de fechar */
.close {
    color: red;
    float: right;
    font-size: 28px;
    cursor: pointer;
}

/* TERMINO DO MODAL*/

/* Estilos para telas menores que 768px */
@media (max-width: 768px) {
    .incluir button, .botaoContainer button {
        padding: 6px 12px; /* Reduz o padding dos botões */
        font-size: 14px;   /* Reduz o tamanho da fonte */
    }

    .categoriaTitulo {
        font-size: 18px;   /* Reduz o tamanho da fonte do título da categoria */
    }

    .botaoContainer {
        gap: 5px;         /* Reduz o espaço entre os botões */
    }

    .modal-content {
        width: 80%;       /* Aumenta a largura do modal para telas menores */
    }

    .main {
        padding: 10px; /* Reduz o padding do conteúdo principal */
    }

    .topo {
        flex-direction: column; /* Coloca o título e o botão em coluna */
        align-items: flex-start; /* Alinha os itens à esquerda */
    }

    .incluir {
        margin-top: 10px; /* Adiciona um espaço entre o título e o botão */
    }
}

/* Estilos para telas menores que 480px */
@media (max-width: 600px) {
    .incluir button, .botaoContainer button {
        padding: 4px 8px;  /* Reduz ainda mais o padding dos botões */
        font-size: 12px;   /* Reduz o tamanho da fonte */
    }

    .categoriaTitulo {
        font-size: 16px;   /* Reduz o tamanho da fonte do título da categoria */
    }

    .botaoContainer {
        flex-direction: column; /* Coloca os botões em coluna */
        gap: 5px;         /* Reduz o espaço entre os botões */
    }

    .modal-content {
        width: 90%;       /* Aumenta ainda mais a largura do modal para telas muito pequenas */
        padding: 10px; /* Reduz ainda mais o padding interno */
    }

    .categoriaiTem li {
        flex-direction: column; /* Coloca o item e os botões em coluna */
    }

    .botaoContainer {
        margin-top: 10px; /* Adiciona um espaço entre o item e os botões */
    }
}
</style>


     

  <!-- Modal Incluir Categoria -->
  <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Categoria a ser adicionada</h2>
            <form id="meuFormulario" method="post" action="toDoAcoes.php">
                <label for="categoria">Nome:</label>
                <input type="text" id="categoria" name="categoria" required>
                <input type="hidden" name="incluirCategoria"> 
                <button type="submit">Enviar</button>
            </form>
        </div>
    </div>

<!-- Modal Incluir Item -->
<div id="modalItem" class="modal">
    <div class="modal-content">
        <span id="closeModalItem" class="close">&times;</span>
        <h2>Adicionar Item</h2>
        <form id="formIncluirItem" method="POST" action="toDoAcoes.php">
            <label for="nomeItem">Nome do Item:</label>
            <input type="text" id="Item" name="item" required>       
            <br><br>
            <label for="nomeItem">Data Prevista :</label>
            <input type="date" id="data" name="data" required>    

            <!-- Campo oculto para armazenar o ID da categoria -->
            <input type="hidden" id="categoriaId" name="categoriaId">
            <input type="hidden" id="incluirItem" name="incluirItem">

            <button type="submit">Enviar</button>
        </form>
    </div>
</div>








<div class="main"> 
    <!-- TOPO --> 
    <div class="topo">
        <div class="titulo"> Lista de tarefas  </div>

        <div class="incluir">
              
                <button id="openModalBtn">Incluir Categoria</button>
            
        </div>
    </div>
    <!-- FIM TOPO --> 

     
    <div class="listaCategoria">

    <div class="categoriaTitulo">
               <SPAM> Hoje</SPAM>
    </div>
    <!-- FIM CATEGORIA - TITULO  --> 



    <!-- Mostrando a sub lista de itens -->
    
        
        
        <div class="categoriaiTem"><ul>
        
        <?php foreach($listaToday as $listaHoje) { ?>
            
            <li class="itemCategoria"> 
                <?php echo $listaHoje['categoria_lista'].' - '?>
                <?php echo $listaHoje['itemCategoria']; ?> 





                <div class="botaoContainer">
                    <form method="POST" action="toDoAcoes.php"> 
                        <input type="hidden"  name="editarItem"  /> 
                        <input type="hidden"  name="id_lista_todo" value="<?php echo $listaHoje['id_lista_todo']; ?>" /> 
                        <button>Editar</button>  
                    </form>  
                    <form method="POST" action="toDoAcoes.php"> 
                        <input type="hidden"  name="excluirItem"  /> 
                        <input type="hidden"  name="id_lista_todo" value="<?php echo $listaHoje['id_lista_todo']; ?>" /> 
                        <button type="submit" onclick="return confirm('Deseja realmente excluir esse Item?');">Excluir</button>  
                    </form>  
                    <form method="POST" action="toDoAcoes.php"> 
                        <input type="hidden"  name="concluirItem"  /> 
                        <input type="hidden"  name="id_lista_todo" value="<?php echo $listaHoje['id_lista_todo']; ?>" /> 
                        <button type="submit" onclick="return confirm('Deseja realmente marcar como concluido?');">Concluido</button>  
                    </form>  
                </div>   
            </li>
        <?php } ?>

        </ul></div>
  
    </div>

    <div class="listaCategoria">

    <div class="categoriaTitulo">
               <SPAM> Atrasado</SPAM>
    </div>
    <!-- FIM CATEGORIA - TITULO  --> 



    <!-- Mostrando a sub lista de itens -->
    
        
        
        <div class="categoriaiTem"><ul>
        
        <?php foreach($listaAtrasado as $listaHoje) { ?>
            
            <li class="itemCategoria"> 
                <?php echo $listaHoje['categoria_lista'].' - '?>
                <?php echo $listaHoje['itemCategoria']; ?> 





                <div class="botaoContainer">
                    <form method="POST" action="toDoAcoes.php"> 
                        <input type="hidden"  name="editarItem"  /> 
                        <input type="hidden"  name="id_lista_todo" value="<?php echo $listaHoje['id_lista_todo']; ?>" /> 
                        <button>Editar</button>  
                    </form>  
                    <form method="POST" action="toDoAcoes.php"> 
                        <input type="hidden"  name="excluirItem"  /> 
                        <input type="hidden"  name="id_lista_todo" value="<?php echo $listaHoje['id_lista_todo']; ?>" /> 
                        <button type="submit" onclick="return confirm('Deseja realmente excluir esse Item?');">Excluir</button>  
                    </form>  
                    <form method="POST" action="toDoAcoes.php"> 
                        <input type="hidden"  name="concluirItem"  /> 
                        <input type="hidden"  name="id_lista_todo" value="<?php echo $listaHoje['id_lista_todo']; ?>" /> 
                        <button type="submit" onclick="return confirm('Deseja realmente marcar como concluido?');">Concluido</button>  
                    </form>  
                </div>   
            </li>
        <?php } ?>

        </ul></div>
  
    </div>


    <div class="listaCategoria">

    <div class="categoriaTitulo">
               <SPAM> Rotina</SPAM>
    </div>
    <!-- FIM CATEGORIA - TITULO  --> 



    <!-- Mostrando a sub lista de itens -->
    
        
        
        <div class="categoriaiTem"><ul>
        
        <?php foreach($listaRotina as $listaRotinas) { ?>
            
            <li class="itemCategoria"> 
                
                <?php echo $listaRotinas['itemCategoria']; ?> 





                <div class="botaoContainer">
                    <form method="POST" action="toDoAcoes.php"> 
                        <input type="hidden"  name="editarItem"  /> 
                        <input type="hidden"  name="id_lista_todo" value="<?php echo $listaRotinas['id_lista_todo']; ?>" /> 
                        <button>Editar</button>  
                    </form>  
                    <form method="POST" action="toDoAcoes.php"> 
                        <input type="hidden"  name="excluirItem"  /> 
                        <input type="hidden"  name="id_lista_todo" value="<?php echo $listaRotinas['id_lista_todo']; ?>" /> 
                        <button type="submit" onclick="return confirm('Deseja realmente excluir esse Item?');">Excluir</button>  
                    </form>  
                    <form method="POST" action="toDoAcoes.php"> 
                        <input type="hidden"  name="concluirItem"  /> 
                        <input type="hidden"  name="id_lista_todo" value="<?php echo $listaRotinas['id_lista_todo']; ?>" /> 
                        <button type="submit" onclick="return confirm('Deseja realmente marcar como concluido?');">Concluido</button>  
                    </form>  
                </div>   
            </li>
        <?php } ?>

        </ul></div>
  
    </div>

    

    


    <!-- Mostrando a lista de categorias -->
    <div class="listaCategoria">

        
        <?php 
        foreach($toDoCategoria as $categorias) { ?>
            
            <div class="categoriaTitulo">
                <?php echo $categorias['categoria_lista']; ?>
                
                <div class="botaoContainer">
                    <form method="post" action="toDoAcoes.php"> 
                        <input type="hidden"  name="editarCategoria"  /> 
                        <input type="hidden"  name="id_categoria" value ="<?php echo $categorias['id_categoria']?>"  /> 
                        <button>Editar Categoria</button>  
                    </form>  
                    <form method="POST" action="toDoAcoes.php"> 
                        <input type="hidden"  name="excluirCategoria"  /> 
                        <input type="hidden"  name="id_categoria" value ="<?php echo $categorias['id_categoria']?>"  /> 
                        <button type="submit" onclick="return confirm('Deseja realmente excluir o essa categoria?');">Excluir Categoria</button>  
                    </form>  

                    <div class="botaoContainer">
                    <button class="btnIncluirItem" data-id="<?php echo $categorias['id_categoria']; ?>">Incluir Item</button>
                    </div>
                    
                </div>
            </div>
            
            <!-- Mostrando a sub lista de itens -->
            <?php 
                $id_categoria = $categorias['id_categoria'];
                $lista = listaToDoItens($conn, $id_categoria);
                echo '<div class="categoriaiTem"><ul>';
                foreach($lista as $listas) { ?>
                    
                    <li class="itemCategoria"> 
                        <?php echo $listas['itemCategoria']; ?> 
                        <div class="botaoContainer">
                            <form method="POST" action="toDoAcoes.php"> 
                                <input type="hidden"  name="editarItem"  /> 
                                <input type="hidden"  name="id_lista_todo" value="<?php echo $listas['id_lista_todo']; ?>" /> 
                                <button>Editar</button>  
                            </form>  
                            <form method="POST" action="toDoAcoes.php"> 
                                <input type="hidden"  name="excluirItem"  /> 
                                <input type="hidden"  name="id_lista_todo" value="<?php echo $listas['id_lista_todo']; ?>" /> 
                                <button type="submit" onclick="return confirm('Deseja realmente excluir esse Item?');">Excluir</button>  
                            </form>  
                            <form method="POST" action="toDoAcoes.php"> 
                                <input type="hidden"  name="concluirItem"  /> 
                                <input type="hidden"  name="id_lista_todo" value="<?php echo $listas['id_lista_todo']; ?>" /> 
                                <button type="submit" onclick="return confirm('Deseja realmente marcar como concluido?');">Concluido</button>  
                            </form>  
                        </div>   
                    </li>
                <?php } 
                echo '</ul></div>';
        }
        ?>
    </div>
</div>

<script> 
// Seleciona todas as divs de título de categoria
const categoriasTitulo = document.querySelectorAll('.categoriaTitulo');

categoriasTitulo.forEach(categoriaTitulo => {
  const categoriaiTem = categoriaTitulo.nextElementSibling; // A div filha é sempre a próxima (a lista de itens)

  categoriaTitulo.addEventListener('click', (event) => {
    event.stopPropagation(); // Impede a propagação do clique

    // Alterna a visibilidade da div filha associada
    if (categoriaiTem.style.display === 'none' || categoriaiTem.style.display === '') {
      categoriaiTem.style.display = 'block';
    } else {
      categoriaiTem.style.display = 'none';
    }
  });
});






/* FUNCAO DO MODAL Categoria*/

  // Modal Categoria
  const modal = document.getElementById("modal");
        const openModalBtn = document.getElementById("openModalBtn");
        const closeModal = modal.querySelector(".close");

        openModalBtn.onclick = () => modal.style.display = "block";
        closeModal.onclick = () => modal.style.display = "none";
        window.onclick = event => { if (event.target == modal) modal.style.display = "none"; };

        
// Modal Incluir Item
const modalItem = document.getElementById("modalItem");
const btnsIncluirItem = document.querySelectorAll(".btnIncluirItem");
const closeModalItem = document.getElementById("closeModalItem");
const categoriaIdInput = document.getElementById("categoriaId"); // Captura o campo oculto

btnsIncluirItem.forEach(btn => {
    btn.onclick = event => {
        event.preventDefault();
        const categoriaId = btn.getAttribute("data-id"); // Obtém o ID da categoria
        categoriaIdInput.value = categoriaId; // Define o ID no campo hidden

        modalItem.style.display = "block"; // Abre o modal
    };
});

// Fechar o modal quando clicar no botão "X"
closeModalItem.onclick = () => modalItem.style.display = "none";

// Fechar o modal quando clicar fora dele
window.onclick = event => { 
    if (event.target == modalItem) modalItem.style.display = "none"; 
};







</script>
