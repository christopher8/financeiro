<?php 
Funcoes:
// . Incluir categoria
// . Editar categoria(form) --> id_categoria ok
// . Incluir item(form)
// . Excluir categoria(js alert)
// . Editar item(form)
// . Excluir item(JS alert)
// . item Concluido(alert)



include_once('config\functions.php');


// se opcao incluir categoria
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['incluirCategoria'])){
    $categoria = ucfirst($_POST['categoria']);
    adicionarCategoriaToDo($conn, $categoria);

}
// se opcao editar categoria
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editarCategoria'])){
    $id_categoria = $_POST['id_categoria'];
    
    $listaCategoriasPorID = listaToDoCategoriaPorID($conn, $id_categoria);
    
    foreach($listaCategoriasPorID as $listas) { ?>
    


<form action="" method="POST" style="font-family: Arial, sans-serif; padding: 20px; max-width: 400px; margin: 0 auto; background-color: #f4f4f4; border-radius: 8px;">
    <label for="categoria" style="display: block; margin-bottom: 8px; font-weight: bold;">Categoria:</label>
    <input type="hidden"  name="editarCategoriaFinal"  /> 
    <input type="hidden"  name="id_categoria" value="<?php echo $listas['id_categoria']?>"  /> 
    <input type="text" id="categoriaFinal" name="categoriaFinal" value="<?php echo $listas['categoria_lista']?>"  required style="width: 100%; padding: 8px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px;">
    <button type="submit" style="background-color: #4CAF50; color: white; border: none; padding: 10px 15px; cursor: pointer; border-radius: 4px;">Editar Categoria</button>
</form>



<?php }
}

// se opcao exluir categoria
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluirCategoria'])){
    $id_categoria = $_POST['id_categoria'];
    excluirToDoCategoria($conn, $id_categoria);

}
// se opcao incluir  item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['incluirItem'])){
    $id_categoria = $_POST['categoriaId'];
    $itemCategoria = ucfirst($_POST['item']);
    $dataASerCumprida = $_POST['data'];
    $statuss = 'pendente';


    adicionaritemToDo($conn, $id_categoria, $itemCategoria, $dataASerCumprida, $statuss);


}



// se opcao item concluir
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['concluirItem'])){
    $id_lista_todo = $_POST['id_lista_todo'];
    $status = "concluido";
    concluidoItemToDo($conn, $status , $id_lista_todo);

}
// se opcao editar item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editarItem'])){
    $toDoCategoria = listaToDoCategoriaEditar($conn);
    $id_lista_todo = $_POST['id_lista_todo'];
    $listarItem = listaItemToDoPorID($conn, $id_lista_todo);
    foreach($listarItem as $lista){
    ?>

<form action="" method="POST" style="font-family: Arial, sans-serif; padding: 20px; max-width: 400px; margin: 0 auto; background-color: #f4f4f4; border-radius: 8px;">
    <label for="id_categoria" style="display: block; margin-bottom: 8px; font-weight: bold;" >Editar item:</label>
    <br>
    
    <label for="categoria" style="display: block; margin-bottom: 8px; font-weight: bold;" >Categoria</label>
    <select id="categoria" name="id_categoria" required style="width: 100%; padding: 8px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px;">
    <?php      foreach ($toDoCategoria as $categoria) {
        ?>
            
            <option <?php if($lista['id_categoria']  == $categoria['id_categoria']) echo 'selected'; ?> nome="id_categoria" value="<?php echo $categoria['id_categoria']?>"><?php echo $categoria['categoria_lista']?> </option>;
            <?php
    }?>   

    </select>

    <label for="itemCategoria" style="display: block; margin-bottom: 8px; font-weight: bold;">Item:</label>
    <input type="text" id="itemCategoria" name="itemCategoria" value="<?php echo $lista['itemCategoria']?>" required style="width: 100%; padding: 8px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px;">
    
    <label for="dataASerCumprida" style="display: block; margin-bottom: 8px; font-weight: bold;">Data a Ser Cumprida:</label>
    <input type="date" id="dataASerCumprida" name="dataASerCumprida" value="<?php echo $lista['dataASerCumprida']?>"required style="width: 100%; padding: 8px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px;">
    
    <label for="status" style="display: block; margin-bottom: 8px; font-weight: bold;">Status:</label>
    <select id="status" name="status" required style="width: 100%; padding: 8px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px;">
        <option value="pendente" <?php if($lista['status']  == 'pendente') echo 'selected'; ?>>Pendente</option>
        <option value="concluido" <?php if($lista['status'] == 'concluido') echo 'selected'; ?>>Concluido</option>
        <option value="atrasado" <?php if($lista['status'] == 'atrasado') echo 'selected'; ?>>Atrasado</option>
        <option value="pausado" <?php if($lista['status'] == 'pausado') echo 'selected'; ?>>Pausado</option>
        <option value="rotina" <?php if($lista['status'] == 'rotina') echo 'selected'; ?>>Rotina</option>
        

    </select>
    <input type="hidden"  name="id_lista_todo" value="<?php echo $lista['id_lista_todo']?>"  />
    <input type="hidden"  name="editarItemfinal"  /> 
    <button type="submit" style="background-color: #4CAF50; color: white; border: none; padding: 10px 15px; cursor: pointer; border-radius: 4px;">Editar Item</button>
</form>



    <?php
}}
// se opcao exluir item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluirItem'])){
    $id_lista_todo = $_POST['id_lista_todo'];
    excluirItemToDo($conn, $id_lista_todo );


}



// se opcao editar categoria definitivo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editarCategoriaFinal'])){
    $id_categoria = $_POST['id_categoria'];
    $categoria_Lista = ucfirst($_POST['categoriaFinal']);
    alterarCategoriaToDo($conn, $id_categoria, $categoria_Lista);
}



// se opcao editar item Definitivo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editarItemfinal'])){

    $id_lista_todo = $_POST['id_lista_todo'];
    $id_categoria = $_POST['id_categoria'];
    $itemCategoria = ucfirst($_POST['itemCategoria']);
    $dataASerCumprida = $_POST['dataASerCumprida'];
    $status = $_POST['status'];

    alterarItemListaToDo($conn, $id_categoria, $itemCategoria, $dataASerCumprida, $status, $id_lista_todo);

}
?>
