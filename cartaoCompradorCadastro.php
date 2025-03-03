<?php
    
    if(isset($_POST["usuario"])){;
  //      echo "teste com sucesso USUARIO";

        require_once('config\functions.php');
  
    
        $usuario = $_POST["usuario"];


        // cadastrando usuario
        cadastrarCompradorCartao($conn, $usuario, 1) ;


    }
 
?>



<body class="login-cadastro">
    <div class="login-container">
            <h1>Cadastro de comprador </h1>

            <form action="" method="POST">
                <div class="form-login">
                    <label for="text">Usuario:</label>
                    <input type="text" id="usuario" name="usuario" required>
                </div>

                <button type="submit" class="login-btn">Cadastrar</button>
            </form>


            
    </div>
</body>
    