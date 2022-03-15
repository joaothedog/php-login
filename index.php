<?php
    //conexao db
    require_once 'db_connect.php';

    //sessoes
    session_start();

    //footer
    include_once 'includes/header.php';

    //BOTAO ENTRAR
    if(isset($_POST['btn-entrar'])):
        $erros = array();
        $login = mysqli_escape_string($connect, $_POST['login']);
        $senha = mysqli_escape_string($connect, $_POST['senha']);

        if(empty($login) or empty($senha)):
            $erros[] = "<li> O campo login/senha precisa ser preenchido </li>";
        else:
            $sql = "SELECT login FROM usuarios WHERE login = '$login'";
            $resultado = mysqli_query($connect, $sql);

            if(mysqli_num_rows($resultado) > 0):  
                $senha = md5($senha);          
                $sql = "SELECT * FROM usuarios WHERE login = '$login' AND senha = '$senha'";
                $resultado = mysqli_query($connect, $sql);

                    if(mysqli_num_rows($resultado) == 1):
                        $dados = mysqli_fetch_array($resultado);
                        $_SESSION['logado'] = true;
                        $_SESSION['id_usuario'] = $dados['id'];
                        header('Location: home.php');
                    else:
                        $erros[] = "<li> Usuário e senha nao estão corretas! </li>";
                    endif;
            else:
                $erros[] ="<li> User inexistente </li>";
            endif;
        endif;

    endif;
?>

    <div class="container">
    <h3 class="light" style="text-align: center;">Login</h3>

    <?php
    if(!empty($erros)):
        foreach($erros as $erro):
            echo $erro;
        endforeach;
    endif;
    ?>

    <div class="container">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        Login: <input type="text" name="login"><br>
        Senha: <input type="password" name="senha"><br>
        <button class="btn" type="submit" name="btn-entrar">Entrar</button>

    </form>
    </div>
    </div>

<?php
//footer
include_once 'includes/footer.php';
?>