<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar'])) {
    

    $devedor= $_POST['devedor'];
    $valor = intval($_POST['valor']);
    $data_prevista = $_POST['data_prevista'];

    cadastrarValorAReceber($conn , $devedor, $valor, $data_prevista );

}


?>







<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .form-container {
        background-color: #ffffff;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
    }

    h2 {
        margin-bottom: 1.5rem;
        font-size: 1.5rem;
        color: #333;
        text-align: center;
    }

    label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
        color: #555;
    }

    select,input[type="number"], input[type="text"], input[type="date"] {
        width: 100%;
        padding: 0.75rem;
        margin-bottom: 1rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 1rem;
        color: #333;
        background-color: #f9f9f9;
        transition: border-color 0.3s ease;
    }

    select:focus, input[type="number"]:focus, input[type="text"]:focus {
        border-color: #007bff;
        outline: none;
    }

    button {
        width: 100%;
        padding: 0.75rem;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #0056b3;
    }

    .hidden {
        display: none;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }
</style>


<div class="form-container">
    <h2>Dividas a receber</h2>
    <form action="" method="post">
            
    <input type="hidden" name="cadastrar">

    <div class="form-group" id="devedor">
        <label for="devedor">Devedor :</label>
        <input type="text" id="devedor" name="devedor" required>
    </div>

    <div class="form-group">
        <label for="valor">Valor R$ : </label>
        <input type="number" id="valor" name="valor" step="0.01" required>
    </div>


    <label class="form-group" for="data_prevista">Data prevista :</label>
    <input  class="form-group" type="date" id="data_prevista" name="data_prevista" value="<?php  echo date('Y-m-d') ?>" required>

    <button type="submit">Enviar</button>
    </form>
</div>