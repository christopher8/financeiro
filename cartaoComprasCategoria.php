<?php
    include_once('config\functions.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adicionar'])){
        
        $categoria = $_POST['categoria'];
        cadastrarCartaoCategoria($conn, $categoria);


    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])){



    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir'])){



    }else{

        // $listaComprasCategoria = 'categoria';
        
    }
    

?>



<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.container {
    width: 100%;
    max-width: 400px;
    padding: 20px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

h2 {
    margin-bottom: 15px;
    color: #333;
}

input, button {
    width: 100%;
    padding: 10px;
    margin: 5px 0;
    border-radius: 5px;
    border: 1px solid #ccc;
}

input:focus {
    outline: none;
    border-color: #007bff;
}

button {
    background-color: #007bff;
    color: white;
    border: none;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}
</style>

<div class="container">
    <h2>Cadastro categoria </h2>

    <form action="" method="post">
        <div class="form-login">
            <label for="text">Categoria:</label>
            <input type="text" id="categoria" name="categoria" required>
        </div>
        <input type="hidden" name="adicionar">
        <button type="submit" class="login-btn">Cadastrar</button>
    </form>
    </div>
