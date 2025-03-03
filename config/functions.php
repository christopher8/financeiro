<?php
    
// Configurações de conexão com o banco de dados

date_default_timezone_set('America/Sao_Paulo');


    $host = 'localhost'; 
    $user = 'root'; 
    $password = ''; 
    $database = 'financeiro'; 

    // Criar conexão

    try {
    $conn = new mysqli($host, $user, $password, $database);

    // Verificar conexão
    if ($conn->connect_error) {
        throw new Exception("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
        exit; // Encerra o script se a conexão falhar
    }






function cadastrarCompradorCartao($conn ,$usuario, $ativo) {
    
    // Consulta SQL para inserir o usuário
    $sql = "INSERT INTO cartao_comprador (comprador, ativo) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Erro ao preparar a consulta: " . $conn->error);
    }

    // Liga os parâmetros à consulta
    $stmt->bind_param("si", $usuario, $ativo); // USER e PASS são strings, ATIVO é inteiro

    // Executa a consulta
    if ($stmt->execute()) {

echo "<script>
            alert('comprador cadastrado com sucesso!.');
            window.location.href = 'index.php?pg=cartaoCompradorLista';
    </script>";
        

        
    } else {
        
        echo "Erro ao cadastrar o usuário: " . $stmt->error;
    }

    // Fecha a conexão
    $stmt->close();
    $conn->close();
}


// FUNCAO DE LISTAGEM DE USUARIOS

function listarCompradorCartao($conn) {
    // Escrevendo a consulta SQL para listar todos os usuários
    $sql = "SELECT * FROM cartao_comprador";
    $result = $conn->query($sql);

    // Verificando o resultado
    if ($result && $result->num_rows > 0) {
        // Criando um array para armazenar os usuários
        $usuarios = [];
        
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }

        // Retorna a lista de usuários
        return $usuarios;
    } else {
        // Retorna um array vazio caso não haja resultados
        return [];
    }
}


// FUNCAO DE EXCLUSAO DE USUARIO
function excluirCompradorCartao($conn, $id) {
    $sql = "DELETE FROM cartao_comprador WHERE id_comprador = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        return false;
    }
    $stmt->bind_param('i', $id);
    return $stmt->execute();
}



// FUNCAO ALTERAÇÃO DE USUARIO

function alterarCompradorCartao($conn, $id, $novoUser,  $ativo) {
    // Escrevendo a consulta SQL com placeholders
    $sql = "UPDATE cartao_comprador SET `comprador` = ?,  `ativo` = ? WHERE `id_comprador` = ?";

    // Preparando a consulta para evitar SQL Injection
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        return false; // Caso algo dê errado na preparação
    }

    // Associando os parâmetros: 'ssii' -> string, string, inteiro, inteiro
    $stmt->bind_param('sii', $novoUser,  $ativo, $id);

    // Executando a consulta
    if ($stmt->execute()) {
        echo "<script>
        alert('Cartao cadastrado com sucesso!.');
        window.location.href = 'index.php?pg=cartaoCompradorLista';
        </script>";

        return true; // Alteração bem-sucedida
        
    } else {
        return false; // Falha na execução
    }
}


#CARTAO


// Função para cadastrar cartão de crédito
function cadastrarCartao($conn, $cartao, $limite, $diaFechamento, $diaVencimento,  $limiteDisponivel) {
    try {
        // Consulta SQL para inserir o cartão
        $sql = "INSERT INTO cartao (cartao, limite, fechamento, vencimento, limite_disponivel) VALUES (?, ?, ?, ?,? )";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Erro ao preparar a consulta: " . $conn->error);
        }

        // Liga os parâmetros à consulta
        $stmt->bind_param("siiii", $cartao, $limite, $diaFechamento, $diaVencimento, $limiteDisponivel);

        // Executa a consulta
        if (!$stmt->execute()) {
            throw new Exception("Erro ao executar a consulta: " . $stmt->error);
        }

        echo "<script>
        alert('Cartao cadastrado com sucesso!.');
        window.location.href = 'index.php?pg=cartaoLista';
        </script>";
        
        // Fecha o statement
        $stmt->close();
    } catch (Exception $e) {
        // Exibe mensagem de erro sem encerrar abruptamente
        echo "Erro: " . $e->getMessage();
    }
}

// FUNCAO DE EXCLUSAO DE CARTOES DE CREDITO
function excluirCartao($conn, $id) {
    $sql = "DELETE FROM cartao WHERE id_cartao = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        return false;
    }
    $stmt->bind_param('i', $id);
    return $stmt->execute();
}



// FUNCAO ALTERAÇÃO DE CARTOES DE CREDITO
        
function alterarCartao($conn, $id, $cartao, $limite, $diaFechamento, $diaVencimento) {
    // Escrevendo a consulta SQL com placeholders
    $sql = "UPDATE cartao SET `cartao` = ?, `limite` = ?, `fechamento` = ? , `vencimento` = ?  WHERE `id_cartao` = ?";

    // Preparando a consulta para evitar SQL Injection
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        return false; // Caso algo dê errado na preparação
    }


    $stmt->bind_param('siiii', $cartao, $limite, $diaFechamento, $diaVencimento , $id);

    // Executando a consulta
    if ($stmt->execute()) {
        return true; // Alteração bem-sucedida
    } else {
        return false; // Falha na execução
    }
}



function listarCartoes($conn) {
    // Escrevendo a consulta SQL para listar todos os usuários
    $sql = "SELECT * FROM cartao order by cartao asc";
    $result = $conn->query($sql);

    // Verificando o resultado
    if ($result && $result->num_rows > 0) {
        // Criando um array para armazenar os usuários
        $cartao = [];
        
        while ($row = $result->fetch_assoc()) {
            $cartao[] = $row;
        }

        // Retorna a lista de usuários
        return $cartao;
    } else {
        // Retorna um array vazio caso não haja resultados
        return [];
    }
}


# CONTA BANCARIA


function cadastrarConta($conn,$banco, $agencia, $conta, $saldo){

$id_usuario = 1; // Substituir pelo ID do usuário autenticado quando eu ativar a autenticacao

$banco = $_POST['banco'];
$agencia = $_POST['agencia'];
$conta = $_POST['conta'];
$saldo = $_POST['saldo'];

// $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); se eu quiser no futuro esconder as senhas bancarias 

$sql = "INSERT INTO banco (id_usuario, banco, agencia, conta, saldo) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isssds", $id_usuario, $banco, $agencia, $conta, $saldo);

if ($stmt->execute()) {
    echo "<script>
    alert('Conta cadastrado com sucesso!.');
    window.location.href = 'index.php?pg=bancoLista';
    </script>";
} else {
    echo "Erro: " . $stmt->error;
}

$stmt->close();
$conn->close();

}

function excluirBanco($conn, $id){
    $sql = "DELETE FROM banco WHERE id_banco = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        return false;
    }
    $stmt->bind_param('i', $id);
    return $stmt->execute();


}


function alterarBancos($conn, $id, $banco, $agencia, $conta, $saldo) {
    // Escrevendo a consulta SQL com placeholders
    $sql = "UPDATE banco SET `banco` = ?, `agencia` = ?, `conta` = ? , `saldo` = ? WHERE `id_banco` = ?";

    // Preparando a consulta para evitar SQL Injection
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        return false; // Caso algo dê errado na preparação
    }


    $stmt->bind_param('sssdi', $banco, $agencia, $conta, $saldo, $id);

    // Executando a consulta
    if ($stmt->execute()) {
        return true; // Alteração bem-sucedida
    } else {
        return false; // Falha na execução
    }
}



function listarContas($conn) {
    // Escrevendo a consulta SQL para listar todos os usuários
    $sql = "SELECT * FROM banco";
    $result = $conn->query($sql);

    // Verificando o resultado
    if ($result && $result->num_rows > 0) {
        // Criando um array para armazenar os usuários
        $banco = [];
        
        while ($row = $result->fetch_assoc()) {
            $banco[] = $row;
        }

        // Retorna a lista de usuários
        return $banco;
    } else {
        // Retorna um array vazio caso não haja resultados
        return [];
    }
}

// consultar saldo bancario

function consultarSaldo($conn,$id_conta_origem){
   
    // Preparação da consulta
    $stmt = $conn->prepare("SELECT saldo FROM banco WHERE id_banco = ?");
    $stmt->bind_param("i", $id_conta_origem); // "i" indica um inteiro
    
    // Execução da consulta
    $stmt->execute();
    
    // Obtenção do resultado
    $resultado = $stmt->get_result();
    
    // Verificação se o resultado foi encontrado
    if ($resultado->num_rows > 0) {
      $row = $resultado->fetch_assoc();
      $saldo = $row['saldo'];
      return $saldo;
    } else {
      echo "Saldo não encontrado para a conta informada.";
    }
    
    // Fechamento da conexão e do statement
    $stmt->close();
    $conn->close();
    
    
    }

    

// Funcao que tira saldo de uma conta e coloca em outra

function saldoContaOrigemDespesa($conn,$id_conta_origem,$valor ){
    // Escrevendo a consulta SQL com placeholders
    $sql = "UPDATE banco SET `saldo` = saldo - ? WHERE `id_banco` = ?";

    // Preparando a consulta para evitar SQL Injection
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        return false; // Caso algo dê errado na preparação
    }


    $stmt->bind_param('di',  $valor, $id_conta_origem);

    // Executando a consulta
    if ($stmt->execute()) {
        return true; // Alteração bem-sucedida
    } else {
        $stmt->close(); // Fechando o statement
        return false; // Falha na execução
    }


}

// Funcao que Coloca saldo de uma conta e coloca em outra

function saldoContaOrigemReceita($conn,$id_conta_origem,$valor ){
    // Escrevendo a consulta SQL com placeholders
    $sql = "UPDATE banco SET `saldo` = saldo + ? WHERE `id_banco` = ?";

    // Preparando a consulta para evitar SQL Injection
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        return false; // Caso algo dê errado na preparação
    }


    $stmt->bind_param('di',  $valor, $id_conta_origem);

    // Executando a consulta
    if ($stmt->execute()) {
        return true; // Alteração bem-sucedida
    } else {
        $stmt->close(); // Fechando o statement
        return false; // Falha na execução
    }


}



function saldoContaDestino($conn,$id_conta_destino,$valor){

        // Escrevendo a consulta SQL com placeholders
        $sql = "UPDATE banco SET `saldo` = saldo + ? WHERE `id_banco` = ?";

        // Preparando a consulta para evitar SQL Injection
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            return false; // Caso algo dê errado na preparação
        }
    
    
        $stmt->bind_param('di',  $valor, $id_conta_destino);
    
        // Executando a consulta
        if ($stmt->execute()) {
            return true; // Alteração bem-sucedida
        } else {
            $stmt->close(); // Fechando o statement
        return false; // Falha na execução
        }

}


// Funcao que executa a transacao

function transacaoTransferencia($conn, $id_conta_origem,$valor,$tipo_transacao,$id_conta_destino,$descricao_manual, $data_transacao){
// Prepara a query SQL
$sql = "INSERT INTO transacoes (id_conta_origem, id_conta_destino, valor, data_transacao, tipo_transacao) VALUES (?, ?, ?, ?, ?)";

// Prepara a declaração
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Erro na preparação da query: " . $conn->error);
}

// Associa os parâmetros
$stmt->bind_param("iidss", $id_conta_origem, $id_conta_destino, $valor, $data_transacao, $tipo_transacao);

// Executa a declaração
if ($stmt->execute()) {
 
    saldoContaOrigemDespesa($conn,$id_conta_origem,$valor);
    saldoContaOrigemReceita($conn,$id_conta_destino,$valor);

        // Redirecionamento ou mensagem de sucesso
    echo "<script>
    alert('Transação efetivada com sucesso.');
    window.location.href = 'index.php?pg=transacoesTransferencia';
        </script>";
    exit;
} else {
    die("Erro ao executar a query: " . $stmt->error);
}

// Fecha a declaração e a conexão
$stmt->close();
$conn->close();

}


function transacaoDespesa($conn, $id_conta_origem,$valor,$tipo_transacao,$descricao_manual, $data_transacao,  $idcategoria) {
    // Prepara a query SQL
    $sql = "INSERT INTO transacoes (id_conta_origem, valor, data_transacao, local_transacao, tipo_transacao, id_categoria) VALUES (?, ?, ?, ?, ?, ?)";

    // Prepara a declaração
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Erro na preparação da query: " . $conn->error);
    }

    // Associa os parâmetros
    $stmt->bind_param("idsssi", $id_conta_origem, $valor, $data_transacao, $descricao_manual, $tipo_transacao, $idcategoria);

    // Executa a declaração
    if ($stmt->execute()) {
        saldoContaOrigemDespesa($conn, $id_conta_origem, $valor);
        // Redirecionamento ou mensagem de sucesso
        echo "<script>
        alert('Transação efetivada com sucesso.');
        window.location.href = 'index.php?pg=transacoesDespesas';
        </script>";
        exit;
    } else {
        die("Erro ao executar a query: " . $stmt->error);
    }

    // Fecha a declaração e a conexão
    $stmt->close();
    $conn->close();
}





function transacaoReceita($conn, $id_conta_origem,$valor,$tipo_transacao,$descricao_manual, $data_transacao){
    // Prepara a query SQL
    $sql = "INSERT INTO transacoes (id_conta_origem, valor, data_transacao, local_transacao, tipo_transacao) VALUES (?, ?, ?, ?, ?)";

    // Prepara a declaração
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Erro na preparação da query: " . $conn->error);
    }

    // Associa os parâmetros
    $stmt->bind_param("idsss", $id_conta_origem, $valor, $data_transacao, $descricao_manual, $tipo_transacao);

    // Executa a declaração
    if ($stmt->execute()) {
        saldoContaOrigemReceita($conn, $id_conta_origem, $valor);
        // Redirecionamento ou mensagem de sucesso
        echo "<script>
        alert('Transação efetivada com sucesso.');
        window.location.href = 'index.php?pg=transacoesReceitas';
        </script>";
        exit;
    } else {
        die("Erro ao executar a query: " . $stmt->error);
    }

    // Fecha a declaração e a conexão
    $stmt->close();
    $conn->close();
}

 function transacaoEstornoTransferencia($conn,$id_conta_origem, $id_conta_destino, $valor, $data_transacao, $tipo_transacao, $descricao_manual, $id_categoria, $id_transacao ){
    

// Prepara a query SQL
$sql = "DELETE FROM transacoes  WHERE id_transacao = ?"; 

// Prepara a declaração
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Erro na preparação da query: " . $conn->error);
}

// Associa os parâmetros
$stmt->bind_param("i", $id_transacao);

// Executa a declaração
if ($stmt->execute()) {
 
    //entrar na de origem
    saldoContaOrigemReceita($conn,$id_conta_origem,$valor);
    
    // sair na de destino
    saldoContaOrigemDespesa($conn,$id_conta_destino,$valor);
    

        // Redirecionamento ou mensagem de sucesso
    echo "<script>
    alert('Transação efetivada com sucesso.');
    window.location.href = 'index.php?pg=transacoesLista';
        </script>";
    exit;
} else {
    die("Erro ao executar a query: " . $stmt->error);
}

// Fecha a declaração e a conexão
$stmt->close();
$conn->close();


 }

 function transacaoEstornoReceita($conn,$id_conta_origem, $id_conta_destino, $valor, $data_transacao, $tipo_transacao, $descricao_manual, $id_categoria , $id_transacao){
        // Prepara a query SQL
        $sql = "DELETE FROM transacoes  WHERE id_transacao = ?";

    // Prepara a declaração
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Erro na preparação da query: " . $conn->error);
    }

    // Associa os parâmetros
    $stmt->bind_param("i", $id_transacao);

    // Executa a declaração
    if ($stmt->execute()) {
        saldoContaOrigemDespesa($conn, $id_conta_origem, $valor);
        // Redirecionamento ou mensagem de sucesso
        echo "<script>
        alert('Transação efetivada com sucesso.');
        window.location.href = 'index.php?pg=transacoesLista';
        </script>";
        exit;
    } else {
        die("Erro ao executar a query: " . $stmt->error);
    }

    // Fecha a declaração e a conexão
    $stmt->close();
    $conn->close();




 }

 function transacaoEstornoDespesa($conn,$id_conta_origem, $id_categoria,  $valor, $data_transacao, $descricao_manual, $tipo_transacao , $id_transacao ){
    // Prepara a query SQL
    
    $sql = "DELETE FROM transacoes  WHERE id_transacao = ?"; 
    // Prepara a declaração
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Erro na preparação da query: " . $conn->error);
    }

    // Associa os parâmetros
    $stmt->bind_param("i", $id_transacao);

    // Executa a declaração
    if ($stmt->execute()) {
        saldoContaOrigemReceita($conn, $id_conta_origem, $valor);
        // Redirecionamento ou mensagem de sucesso
        echo "<script>
        alert('Transação efetivada com sucesso.');
        window.location.href = 'index.php?pg=transacoesLista';
        </script>";
        exit;
    } else {
        die("Erro ao executar a query: " . $stmt->error);
    }

    // Fecha a declaração e a conexão
    $stmt->close();
    $conn->close();





 }





function listaTransacaoPorID($conn, $id){
    $sql = "SELECT * FROM transacoes where id_transacao =  $id";
    $result = $conn->query($sql);

    // Verificando o resultado
    if ($result && $result->num_rows > 0) {
        // Criando um array para armazenar os usuários
        $transacao = [];
        
        while ($row = $result->fetch_assoc()) {
            $transacao[] = $row;
        }

        // Retorna a lista de usuários
        return $transacao;
    } else {
        // Retorna um array vazio caso não haja resultados
        return [];
    }


}


function excluirTransacao($conn, $id){
    $sql = "DELETE FROM transacoes WHERE id_transacao = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        return false;
    }
    $stmt->bind_param('i', $id);
    return $stmt->execute();

}


function listartransacoes($conn){
// Escrevendo a consulta SQL para listar todos as transacoes
    $sql = "SELECT * FROM transacoes  order by id_transacao DESC ";
    $result = $conn->query($sql);

    // Verificando o resultado
    if ($result && $result->num_rows > 0) {
        // Criando um array para armazenar os usuários
        $transacao = [];
        
        while ($row = $result->fetch_assoc()) {
            $transacao[] = $row;
        }

        // Retorna a lista de usuários
        return $transacao;
    } else {
        // Retorna um array vazio caso não haja resultados
        return [];
    }

}

function listartransacoesFiltro($conn,$filtro){
    // Escrevendo a consulta SQL para listar todos as transacoes
       $sql = "SELECT * FROM transacoes Where $filtro  order by id_transacao DESC ";
        $result = $conn->query($sql);
    
        // Verificando o resultado
        if ($result && $result->num_rows > 0) {
            // Criando um array para armazenar os usuários
            $transacao = [];
            
            while ($row = $result->fetch_assoc()) {
                $transacao[] = $row;
            }
    
            // Retorna a lista de usuários
            return $transacao;
        } else {
            // Retorna um array vazio caso não haja resultados
            return [];
        }
    
    }

function pegarNomeBanco($conn, $id_banco) {
    $sql = "SELECT banco FROM banco WHERE id_banco = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_banco);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['banco'];
    } else {
        return "Banco não encontrado";
    }
}




function listartransacoesReceitas($conn, $receita) {
    // Inicializa o array de transações
    $transacao = [];

    // Preparação da consulta
    $stmt = $conn->prepare("SELECT * FROM transacoes WHERE tipo_transacao = ?");
    if (!$stmt) {
        die("Erro na preparação da consulta: " . $conn->error);
    }

    // "s" indica que $receita é uma string. Se for inteiro, use "i".
    $stmt->bind_param("s", $receita);

    // Execução da consulta
    $stmt->execute();

    // Obtenção do resultado
    $resultado = $stmt->get_result();

    // Verificação se o resultado foi encontrado
    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $transacao[] = $row; // Adiciona cada linha ao array
        }
        return $transacao; // Retorna todas as transações encontradas
    } else {
        echo "Transações não encontradas.";
        return []; // Retorna um array vazio se não houver resultados
    }

    // Fechamento do statement
    $stmt->close();
    $conn->close();
}

function listartransacoesDespesa($conn, $despesa){

    // Inicializa o array de transações
    $transacao = [];

    // Preparação da consulta
    $stmt = $conn->prepare("SELECT * FROM transacoes WHERE tipo_transacao = ?");
    if (!$stmt) {
        die("Erro na preparação da consulta: " . $conn->error);
    }

    // "s" indica que $receita é uma string. Se for inteiro, use "i".
    $stmt->bind_param("s", $despesa);

    // Execução da consulta
    $stmt->execute();

    // Obtenção do resultado
    $resultado = $stmt->get_result();

    // Verificação se o resultado foi encontrado
    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $transacao[] = $row; // Adiciona cada linha ao array
        }
        return $transacao; // Retorna todas as transações encontradas
    } else {
        echo "Transações não encontradas.";
        return []; // Retorna um array vazio se não houver resultados
    }

    // Fechamento do statement
    
    $stmt->close();
    $conn->close();
}
    
function compra($conn, $id_usuario, $id_cartao, $id_categoria, $item, $valor_Total, $numero_Parcelas, $valor_Parcela , $data_compra, $data_primeiraFatura){
    $sql = "INSERT INTO cartao_fatura (id_comprador, id_cartao, id_categoria, produto, valor_Total, valor_Parcela, numero_Parcelas, data_compra, primeira_fatura) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?,? )";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("iissddiss", $id_usuario, $id_cartao, $id_categoria, $item, $valor_Total, $valor_Parcela, $numero_Parcelas, $data_compra, $data_primeiraFatura);
        if ($stmt->execute()) {

            // Redirecionamento ou mensagem de sucesso
        echo "<script>
        alert('Transação efetivada com sucesso.');
        window.location.href = 'index.php?pg=cartaoCompras';
        </script>";

        } else {
            echo "<p>Erro ao inserir registro: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }
   
}





function listarCategoriaDespesa($conn){
   // Escrevendo a consulta SQL para listar todos os usuários
   $sql = "SELECT * FROM despesa_categoria ORDER BY categoria ASC;";
   $result = $conn->query($sql);

   // Verificando o resultado
   if ($result && $result->num_rows > 0) {
       // Criando um array para armazenar os usuários
       $categoria = [];
       
       while ($row = $result->fetch_assoc()) {
           $categoria[] = $row;
       }

       // Retorna a lista de usuários
       return $categoria;
   } else {
       // Retorna um array vazio caso não haja resultados
       return [];
   }




}

function listarCategoriaCartoes($conn){
    // Escrevendo a consulta SQL para listar todos os usuários
    $sql = "SELECT * FROM Cartao_categoria ORDER BY categoria_cartao ASC;";
    $result = $conn->query($sql);
 
    // Verificando o resultado
    if ($result && $result->num_rows > 0) {
        // Criando um array para armazenar os usuários
        $categoria = [];
        
        while ($row = $result->fetch_assoc()) {
            $categoria[] = $row;
        }
 
        // Retorna a lista de usuários
        return $categoria;
    } else {
        // Retorna um array vazio caso não haja resultados
        return [];
    }
 
 
 
 
 }



    
function listarCompras($conn){
 // Escrevendo a consulta SQL para listar todos os usuários
 //$sql = "SELECT * FROM cartao_fatura";

$sql = " SELECT 
    cf.id_fatura,
    cc.comprador, 
    c.cartao,     
    cat.categoria_cartao, 
    cf.produto,
    cf.valor_Total,
    cf.valor_Parcela,
    cf.numero_Parcelas,
    cf.data_compra,
    cf.primeira_fatura
FROM 
    cartao_fatura cf
JOIN 
    cartao_comprador cc ON cf.id_comprador = cc.id_comprador
JOIN 
    cartao c ON cf.id_cartao = c.id_cartao
JOIN 
    cartao_categoria cat ON cf.id_categoria = cat.id_categoria_cartao
ORDER BY 
    c.cartao ASC,
    cc.comprador ASC;";




 $result = $conn->query($sql);

 // Verificando o resultado
 if ($result && $result->num_rows > 0) {
     // Criando um array para armazenar os usuários
     $compra = [];
     
     while ($row = $result->fetch_assoc()) {
         $compra[] = $row;
     }

     // Retorna a lista de usuários
     return $compra;
 } else {
     // Retorna um array vazio caso não haja resultados
     return [];
 }
}


function listarComprasFiltro($conn,$Filtro){
    // Escrevendo a consulta SQL para listar todos os usuários
    //$sql = "SELECT * FROM cartao_fatura";
   
   $sql = " SELECT 
    cf.id_fatura,
    cc.id_comprador,
    cc.comprador,
    c.cartao,     
    cat.categoria_cartao, 
    cf.produto,
    cf.valor_Total,
    cf.valor_Parcela,
    cf.numero_Parcelas,
    cf.data_compra,
    cf.primeira_fatura
FROM 
    cartao_fatura cf
JOIN 
    cartao_comprador cc ON cf.id_comprador = cc.id_comprador
JOIN 
    cartao c ON cf.id_cartao = c.id_cartao
JOIN 
    cartao_categoria cat ON cf.id_categoria = cat.id_categoria_cartao
WHERE 
    $Filtro
ORDER BY 
    c.cartao ASC,
    cc.comprador ASC;";
   
   
   
   
    $result = $conn->query($sql);
   
    // Verificando o resultado
    if ($result && $result->num_rows > 0) {
        // Criando um array para armazenar os usuários
        $compra = [];
        
        while ($row = $result->fetch_assoc()) {
            $compra[] = $row;
        }
   
        // Retorna a lista de usuários
        return $compra;
    } else {
        // Retorna um array vazio caso não haja resultados
        return [];
    }
   }



// funcoes listar valores a receber e alteracoes
function listaValorAReceber($conn){
    // Escrevendo a consulta SQL para listar todos os as dividas a receber
 $sql = "SELECT * FROM receber";
 $result = $conn->query($sql);

 // Verificando o resultado
 if ($result && $result->num_rows > 0) {
     // Criando um array para armazenar os usuários
     $receber = [];
     
     while ($row = $result->fetch_assoc()) {
         $receber[] = $row;
     }

     // Retorna a lista dividas a serem recebidas
     return $receber;
 } else {
     // Retorna um array vazio caso não haja resultados
     return [];
 }
}

function listaValorAReceberID($conn , $id){

       
     // Escrevendo a consulta SQL para listar todos os as dividas a receber
 $sql = "SELECT * FROM receber where id_receber = $id ";
 $result = $conn->query($sql);

 // Verificando o resultado
 if ($result && $result->num_rows > 0) {
     // Criando um array para armazenar os usuários
     $receber = [];
     
     while ($row = $result->fetch_assoc()) {
         $receber[] = $row;
     }

     // Retorna a lista dividas a serem recebidas
     return $receber;
 } else {
     // Retorna um array vazio caso não haja resultados
     return [];
 }
 
}





function cadastrarValorAReceber($conn , $devedor, $valor, $data_prevista){
    try {
        // Consulta SQL para inserir a divida a ser recebida
        $sql = "INSERT INTO receber (devedor, valor, data_prevista) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Erro ao preparar a consulta: " . $conn->error);
        }

        // Liga os parâmetros à consulta
        $stmt->bind_param("sds", $devedor, $valor, $data_prevista);

        // Executa a consulta
        if (!$stmt->execute()) {
            throw new Exception("Erro ao executar a consulta: " . $stmt->error);
        }
//window.location.href = 'index.php?pg=proventoAReceberLista';
        echo "<script>
        alert('Divida a receber cadastrado com sucesso!.');
        
        </script>";
        
        // Fecha o statement
        $stmt->close();
    } catch (Exception $e) {
        // Exibe mensagem de erro sem encerrar abruptamente
        echo "Erro: " . $e->getMessage();
    }



}
function excluirValorAReceber($conn, $id_receber ){
    $sql = "DELETE FROM receber WHERE id_receber = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        return false;
    }
    $stmt->bind_param('i', $id_receber);
    return $stmt->execute();


}



function alterarValorAReceber($conn , $id_receber, $devedor, $valor, $data_prevista){

    
    // Escrevendo a consulta SQL com placeholders
    $sql = "UPDATE receber SET `devedor` = ?, `valor` = ?, `data_prevista` = ? WHERE `id_receber` = ?";

    // Preparando a consulta para evitar SQL Injection
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        return false; // Caso algo dê errado na preparação
    }

    // Associando os parâmetros: 'ssii' -> string, string, inteiro, inteiro
    $stmt->bind_param('sdsi', $devedor, $valor, $data_prevista,$id_receber);

    // Executando a consulta
    if ($stmt->execute()) {
        
        echo "<script>
        alert('Transação efetivada com sucesso.');
        window.location.href = 'index.php?pg=proventoAReceberLista';
        </script>";


    } else {
        return false; // Falha na execução
    }


}



function cadastrarDividas($conn, $divida, $valor, $data_prevista){

    try {
        // Consulta SQL para inserir a divida a ser recebida
        $sql = "INSERT INTO dividas (divida, valor, data_prevista) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Erro ao preparar a consulta: " . $conn->error);
        }

        // Liga os parâmetros à consulta
        $stmt->bind_param("sds", $divida, $valor, $data_prevista);

        // Executa a consulta
        if (!$stmt->execute()) {
            throw new Exception("Erro ao executar a consulta: " . $stmt->error);
        }

        echo "<script>
        alert('Divida cadastrado com sucesso!.');
        window.location.href = 'index.php?pg=dividaAPagarLista';
        </script>";
        
        // Fecha o statement
        $stmt->id_divida();
    } catch (Exception $e) {
        // Exibe mensagem de erro sem encerrar abruptamente
        echo "Erro: " . $e->getMessage();
    }


}

// funcoes listar e alterar dividas
function listarDividas($conn){
    // Escrevendo a consulta SQL para listar todos os as dividas a receber
 $sql = "SELECT * FROM dividas";
 $result = $conn->query($sql);

 // Verificando o resultado
 if ($result && $result->num_rows > 0) {
     // Criando um array para armazenar os usuários
     $dividas = [];
     
     while ($row = $result->fetch_assoc()) {
         $dividas[] = $row;
     }

     // Retorna a lista dividas a serem recebidas
     return $dividas;
 } else {
     // Retorna um array vazio caso não haja resultados
     return [];
 }
}

function excluirDividas($conn, $id_divida){
    $sql = "DELETE FROM dividas WHERE id_divida = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        return false;
    }
    $stmt->bind_param('i', $id_divida);
    return $stmt->execute();
}

function listaDividasPorID($conn , $id){

       
    // Escrevendo a consulta SQL para listar todos os as dividas a receber
$sql = "SELECT * FROM dividas where id_divida = $id ";
$result = $conn->query($sql);

// Verificando o resultado
if ($result && $result->num_rows > 0) {
    // Criando um array para armazenar os usuários
    $dividas = [];
    
    while ($row = $result->fetch_assoc()) {
        $dividas[] = $row;
    }

    // Retorna a lista dividas a serem recebidas
    return $dividas;
} else {
    // Retorna um array vazio caso não haja resultados
    return [];
}

}

        
function AlterarDividas($conn, $id_divida, $divida, $valor, $data_prevista){

// Escrevendo a consulta SQL com placeholders
$sql = "UPDATE dividas SET `divida` = ?, `valor` = ?, `data_prevista` = ? WHERE `id_divida` = ?";

// Preparando a consulta para evitar SQL Injection
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    return false; // Caso algo dê errado na preparação
}

// Associando os parâmetros: 'ssii' -> string, string, inteiro, inteiro
$stmt->bind_param('sdsi', $divida, $valor, $data_prevista, $id_divida);

 // Executando a consulta
 if ($stmt->execute()) {
        
    echo "<script>
    alert('Transação efetivada com sucesso.');
    window.location.href = 'index.php?pg=dividaAPagarLista';
    </script>";


} else {
    return false; // Falha na execução
}
}




function listaToDoCategoria($conn){
    $sql = "SELECT * FROM  todo_lista_categoria where id_categoria != 1";
 $result = $conn->query($sql);

 // Verificando o resultado
 if ($result && $result->num_rows > 0) {
     // Criando um array para armazenar os usuários
     $todolistaCat = [];
     
     while ($row = $result->fetch_assoc()) {
         $todolistaCat[] = $row;
     }

     // Retorna a lista todolistaCat a serem recebidas
     return $todolistaCat;
 } else {
     // Retorna um array vazio caso não haja resultados
     return [];
 }
}


function listaToDoCategoriaEditar($conn){
    $sql = "SELECT * FROM  todo_lista_categoria ";
 $result = $conn->query($sql);

 // Verificando o resultado
 if ($result && $result->num_rows > 0) {
     // Criando um array para armazenar os usuários
     $todolistaCat = [];
     
     while ($row = $result->fetch_assoc()) {
         $todolistaCat[] = $row;
     }

     // Retorna a lista todolistaCat a serem recebidas
     return $todolistaCat;
 } else {
     // Retorna um array vazio caso não haja resultados
     return [];
 }
}




function listaToDoItensRotina($conn, $id_categoria) {
    $sql = "SELECT * FROM todo_lista WHERE id_categoria = ? and status != 'concluido' ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_categoria);
    $stmt->execute();
    $result = $stmt->get_result();

    // Certifique-se de que a consulta está retornando múltiplos itens
    $itens = [];
    while ($row = $result->fetch_assoc()) {
        $itens[] = $row;  // Armazena todos os itens
    }

    return $itens;


}










function listaToDoCategoriaPorID($conn, $id_categoria){
    $sql = "SELECT * FROM todo_lista_categoria WHERE id_categoria = ?  ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_categoria);
    $stmt->execute();
    $result = $stmt->get_result();

    // Certifique-se de que a consulta está retornando múltiplos itens
    $itens = [];
    while ($row = $result->fetch_assoc()) {
        $itens[] = $row;  // Armazena todos os itens
    }

    return $itens;
}






function adicionarCategoriaToDo($conn, $categoria){
    $sql = "INSERT INTO todo_lista_categoria (categoria_lista) VALUES (?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $categoria);
        if ($stmt->execute()) {

            // Redirecionamento ou mensagem de sucesso
        echo "<script>
        alert('Categoria Adicionada  com sucesso.');
        window.location.href = 'index.php?pg=toDoLista';
        </script>";

        } else {
            echo "<p>Erro ao inserir registro: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }


}


function excluirToDoCategoria($conn, $id_categoria) {
    // Definindo a consulta SQL para excluir a categoria com o id fornecido
    $sql = "DELETE FROM todo_lista_categoria WHERE id_categoria = ?";
    
    // Preparando a consulta
    $stmt = $conn->prepare($sql);
    
    // Verificando se houve erro na preparação da consulta
    if ($stmt === false) {
        error_log("Erro ao preparar a consulta: " . $conn->error);
        return false;
    }

    // Ligando o parâmetro à consulta preparada
    $stmt->bind_param('i', $id_categoria);
    
    // Executando a consulta
    if ($stmt->execute()) {
        // Redirecionando para a página index após a exclusão bem-sucedida
        
        echo "<script>
            alert('Categoria Excluida  com sucesso.');
            window.location.href = 'index.php?pg=toDoLista';
            </script>";

        exit(); // Importante para garantir que o redirecionamento aconteça imediatamente
    } else {
        error_log("Erro ao executar a consulta: " . $stmt->error);
        return false;
    }
}


function alterarCategoriaToDo($conn, $id_categoria, $categoria_Lista){
    
// Escrevendo a consulta SQL com placeholders
$sql = "UPDATE todo_lista_categoria SET `categoria_lista` = ?  WHERE `id_categoria` = ?";

// Preparando a consulta para evitar SQL Injection
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    return false; // Caso algo dê errado na preparação
}

// Associando os parâmetros: 'ssii' -> string, string, inteiro, inteiro
$stmt->bind_param('si',  $categoria_Lista, $id_categoria,);

// Executando a consulta
if ($stmt->execute()) {
    
    echo "<script>
    alert('Nome de categoria alterado com Sucesso !!!!');
    window.location.href = 'index.php?pg=toDoLista';
    </script>";


} else {
    return false; // Falha na execução
}



}




function adicionaritemToDo($conn, $id_categoria, $itemCategoria, $dataASerCumprida){

    $sql = "INSERT INTO todo_lista  (id_categoria, itemCategoria, dataASerCumprida) VALUES (?,?,?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("iss", $id_categoria, $itemCategoria, $dataASerCumprida);
        if ($stmt->execute()) {

            // Redirecionamento ou mensagem de sucesso
        echo "<script>
        alert('Categoria Adicionada  com sucesso.');
        window.location.href = 'index.php?pg=toDoLista';
        </script>";

        } else {
            echo "<p>Erro ao inserir registro: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }



}

function excluirItemToDo($conn, $id_lista_todo ){

    // Definindo a consulta SQL para excluir a categoria com o id fornecido
    $sql = "DELETE FROM todo_lista WHERE id_lista_todo = ?";
    
    // Preparando a consulta
    $stmt = $conn->prepare($sql);
    
    // Verificando se houve erro na preparação da consulta
    if ($stmt === false) {
        error_log("Erro ao preparar a consulta: " . $conn->error);
        return false;
    }

    // Ligando o parâmetro à consulta preparada
    $stmt->bind_param('i', $id_lista_todo);
    
    // Executando a consulta
    if ($stmt->execute()) {
        // Redirecionando para a página index após a exclusão bem-sucedida
        
        echo "<script>
            alert('Item da lista Excluido com sucesso.');
            window.location.href = 'index.php?pg=toDoLista';
            </script>";

        exit(); // Importante para garantir que o redirecionamento aconteça imediatamente
    } else {
        error_log("Erro ao executar a consulta: " . $stmt->error);
        return false;
    }

}

function  alterarItemListaToDo($conn, $id_categoria, $itemCategoria, $dataASerCumprida, $status, $id_lista_todo){

    // Escrevendo a consulta SQL com placeholders
$sql = "UPDATE todo_lista SET `id_categoria` = ? , `itemCategoria` = ? , `dataASerCumprida` = ? , `status` = ?  WHERE `id_lista_todo` = ?";

// Preparando a consulta para evitar SQL Injection
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    return false; // Caso algo dê errado na preparação
}

// Associando os parâmetros: 'ssii' -> string, string, inteiro, inteiro
$stmt->bind_param('isssi',  $id_categoria, $itemCategoria, $dataASerCumprida, $status, $id_lista_todo);

// Executando a consulta
if ($stmt->execute()) {
    
    echo "<script>
    alert('Item alterado com Sucesso !!!!');
    window.location.href = 'index.php?pg=toDoLista';
    </script>";


} else {
    return false; // Falha na execução
}



}




function listaToDoItens($conn, $id_categoria) {
    $sql = "SELECT * FROM todo_lista WHERE id_categoria = ? and status != 'concluido' ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_categoria);
    $stmt->execute();
    $result = $stmt->get_result();

    // Certifique-se de que a consulta está retornando múltiplos itens
    $itens = [];
    while ($row = $result->fetch_assoc()) {
        $itens[] = $row;  // Armazena todos os itens
    }

    return $itens;


}

function listaItemToDoPorID($conn, $id_lista_todo){
    $sql = "SELECT * FROM todo_lista WHERE id_lista_todo = ? ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_lista_todo);
    $stmt->execute();
    $result = $stmt->get_result();

    // Certifique-se de que a consulta está retornando múltiplos itens
    $itens = [];
    while ($row = $result->fetch_assoc()) {
        $itens[] = $row;  // Armazena todos os itens
    }

    return $itens;
}


function concluidoItemToDo($conn, $status , $id_lista_todo){


// Escrevendo a consulta SQL com placeholders
$sql = "UPDATE todo_lista SET `status` = ?  WHERE `id_lista_todo` = ?";

// Preparando a consulta para evitar SQL Injection
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    return false; // Caso algo dê errado na preparação
}

// Associando os parâmetros: 'ssii' -> string, string, inteiro, inteiro
$stmt->bind_param('si', $status , $id_lista_todo);

// Executando a consulta
if ($stmt->execute()) {
    
    echo "<script>
    alert('Status alterado com sucesso.');
    window.location.href = 'index.php?pg=toDoLista';
    </script>";


} else {
    return false; // Falha na execução
}


}


function listaToDoHoje($conn){
    
    $sql = "SELECT 
        c.categoria_lista, 
        t.id_lista_todo, 
        t.id_categoria, 
        t.itemCategoria, 
        t.dataASerCumprida, 
        t.status
    FROM todo_lista t
    INNER JOIN todo_lista_categoria c ON t.id_categoria = c.id_categoria
    WHERE t.dataASerCumprida = CURDATE() AND STATUS != 'concluido';
    ";
 
 $result = $conn->query($sql);

 // Verificando o resultado
 if ($result && $result->num_rows > 0) {
     // Criando um array para armazenar os usuários
     $todolistaCat = [];
     
     while ($row = $result->fetch_assoc()) {
         $todolistaCat[] = $row;
     }

     // Retorna a lista todolistaCat a serem recebidas
     return $todolistaCat;
 } else {
     // Retorna um array vazio caso não haja resultados
     return [];
 }
}

function listaToDoAtradado($conn){
    
    $sql = "SELECT 
        c.categoria_lista, 
        t.id_lista_todo, 
        t.id_categoria, 
        t.itemCategoria, 
        t.dataASerCumprida, 
        t.status
    FROM todo_lista t
    INNER JOIN todo_lista_categoria c ON t.id_categoria = c.id_categoria
    WHERE t.dataASerCumprida BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) 
                                 AND DATE_SUB(CURDATE(), INTERVAL 1 DAY)
    AND t.status != 'concluido'";


 
 $result = $conn->query($sql);

 // Verificando o resultado
 if ($result && $result->num_rows > 0) {
     // Criando um array para armazenar os usuários
     $todolistaCat = [];
     
     while ($row = $result->fetch_assoc()) {
         $todolistaCat[] = $row;
     }

     // Retorna a lista todolistaCat a serem recebidas
     return $todolistaCat;
 } else {
     // Retorna um array vazio caso não haja resultados
     return [];
 }
}

#USUARIO

// Cadastrar usuario

function cadastrarUsuario($conn,$usuario,$senha,$nome_completo,$estado,$cidade,$dataAniversario, $ativo ){
    try {

     // Validar campos obrigatórios
     if (empty($usuario) || empty($senha) || empty($nome_completo) || empty($estado) || empty($cidade) || empty($dataAniversario)) {
        throw new Exception("Todos os campos são obrigatórios.");
    }

    // Criptografar a senha
    
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);   
    // Consulta SQL para inserir o cartão
    $sql = "INSERT INTO usuario (usuario , senha, nome, estado, cidade, dataNascimento, ativo) VALUES (?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
    throw new Exception("Erro ao preparar a consulta: " . $conn->error);
    }
    // Liga os parâmetros à consulta
    $stmt->bind_param("sssssss", $usuario,$senhaHash,$nome_completo,$estado,$cidade,$dataAniversario, $ativo);
    // Executa a consulta
    if (!$stmt->execute()) {
    throw new Exception("Erro ao executar a consulta: " . $stmt->error);
    }
    echo "<script>
    alert('usuario cadastrado com sucesso!.');
    window.location.href = 'login.php';
    </script>";
    
    // Fecha o statement
    $stmt->close();
    } catch (Exception $e) {
    // Exibe mensagem de erro sem encerrar abruptamente
    echo "Erro: " . $e->getMessage();
    }




}



// Função para verificar se há algum usuário na tabela 'usuario'(tela login)

function verificarUsuario($conn, $usuario, $senha) {
    // Consulta SQL
    $sql = "SELECT id_usuario, senha FROM usuario WHERE usuario = ?";
    
    // Preparando a consulta para evitar SQL Injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificando o resultado
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Verifica a senha usando password_verify()
        if (password_verify($senha, $row['senha'])) {
            return $row['id_usuario']; // Retorna o ID do usuário autenticado
        }
    }
    
    // Caso algo dê errado, retorna null
    
    echo "<script>
    alert('USUARIO OU SENHA INVALIDO !!!!!!');
    window.location.href = 'login.php';
    </script>";

}


    




function cadastrarCartaoCategoria($conn, $categoria){
// Consulta SQL para inserir o usuário
$sql = "INSERT INTO cartao_categoria (categoria_cartao) VALUES (?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Erro ao preparar a consulta: " . $conn->error);
}

// Liga os parâmetros à consulta
$stmt->bind_param("s", $categoria); 

// Executa a consulta
if ($stmt->execute()) {

echo "<script>
        alert('categoria cadastrada com sucesso!.');
        window.location.href = 'index.php?pg=cartaoCompras';
</script>";
    

    
} else {
    
    echo "Erro ao cadastrar o categoria: " . $stmt->error;
}

// Fecha a conexão
$stmt->close();
$conn->close();



}


function cadastrarDespesaCategoria($conn, $categoria){
// Consulta SQL para inserir o usuário
$sql = "INSERT INTO despesa_categoria (categoria) VALUES (?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Erro ao preparar a consulta: " . $conn->error);
}

// Liga os parâmetros à consulta
$stmt->bind_param("s", $categoria); 

// Executa a consulta
if ($stmt->execute()) {

echo "<script>
        alert('categoria cadastrada com sucesso!.');
        window.location.href = 'index.php?pg=transacoesDespesas';
</script>";
    

    
} else {
    
    echo "Erro ao cadastrar o categoria: " . $stmt->error;
}

// Fecha a conexão
$stmt->close();
$conn->close();

}


?>

