<?php 
include_once('config\functions.php');

$contas = listarContas($conn);

    // reebendo dados para alimentar o formulario de alteração
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])){
            $id = $_POST['id'];
           $valorAReceberID =  listaValorAReceberID($conn , $id);
           

           foreach ($valorAReceberID as $idValor){
       
               
                $receber = $idValor['devedor'];
                $valor = $idValor['valor'];
                $data_prevista = $idValor['data_prevista'];  
                $id = $idValor['id_receber'];                   
            }

    }

// valor recebido
// se valor recebedido for igual a valor da divida = exclui divida
// se valor for menor = valor - valor pago
// se valor for maior nao pode


    // se for passado o alterar id Fazer a alteração
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['receber_id'])) {
    



        $id_receber = (int) $_POST['receber_id'];
        $valorNovo = intval($_POST['valor']);
        $valorAtual = intval($_POST['receber_valor_id']);
        $devedor= $_POST['devedor'];
        $data_prevista = $_POST['data_prevista'];
        $id_conta_origem = $_POST['id_conta_origem'];
        
        $tipo_transacao = 'receita_divida';
        $descricao_manual = $_POST['devedor'];
        $data_transacao = $data_prevista;
       
       

        if($valorNovo == $valorAtual){
            excluirValorAReceber($conn, $id_receber);
            $valor = $valorNovo;
            transacaoReceita($conn, $id_conta_origem,$valor,$tipo_transacao,$descricao_manual, $data_transacao);

            echo "<script>
            alert('Valor a receber com ID {$id} foi excluido com sucesso');
            window.location.href = 'index.php?pg=proventoAReceberLista';
            </script>";
            }elseif($valorNovo < $valorAtual){
                $valor = $valorAtual- $valorNovo;
                $valor;
            alterarValorAReceber($conn , $id_receber, $devedor, $valor, $data_prevista ); 
            $valor = $valorNovo;
            transacaoReceita($conn, $id_conta_origem,$valor,$tipo_transacao,$descricao_manual, $data_transacao);

            }else{
                echo "<script>
            alert('Não podemos receber valor acima da divida');
            window.location.href = 'index.php?pg=proventoAReceberLista';
            </script>";
            }




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
            
    <input type="hidden" name="receber_id" value = <?php echo $id ?>>
    <input type="hidden" name="receber_valor_id" value = <?php echo $valor ?>>
    <div class="form-group" id="devedor">
        <label for="devedor">Devedor :</label>
        <input type="text" id="devedor" name="devedor" value = "<?php echo $receber?>" required>
    </div>


    <div class="form-group">
            <label for="id_conta_origem">Conta recebida :</label>
            <select id="id_conta_origem" name="id_conta_origem" required>
            <!-- Opções preenchidas dinamicamente com as contas disponíveis -->
            <?php
            // Exemplo de como preencher as opções com PHP
             // Função que retorna as contas do banco de dados
            foreach ($contas as $conta) {
            echo "<option value='{$conta['id_banco']}'>{$conta['banco']} - R$ {$conta['saldo']} </option>";
            }     ?>
              </select>
        </div>




    <div class="form-group">
        <label for="valor">Valor Pago R$ : </label>
        <input type="number" id="valor" name="valor" step="0.01"  required>
    </div>



    <label class="form-group" for="data_prevista">Data prevista : </label>
    <input  class="form-group" type="date" id="data_prevista" name="data_prevista" value ="<?php echo $data_prevista ?>" required>

    <button type="submit">Receber</button>
    </form>
</div>