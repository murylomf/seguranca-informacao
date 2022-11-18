<?php
include ("cl_usuario.php");

include ("cl_banco.php");

$usuario=new usuario($_POST["usuario"],$_POST["senha"],"");

$conec=conec::conecta_mysql("localhost","root","","TrabalhoMurylo");

try
{
    {
        $conec->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $sth=$conec->prepare("SELECT * FROM usuario WHERE usuario='".$usuario->getUsuario()."' AND senha=SHA1('".$usuario->getSenha()."')",
        array(PDO::ATTR_CURSOR=>PDO::CURSOR_SCROLL));
        $sth->execute();

        if ($sth->rowCount()==0)
        {
            print "Usuário/senha inválidos";
            print "<br><a href='index.php'>Voltar</a>";
            exit;
        }

        $linha=$sth->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_FIRST);
        $usuario->setNome($linha[2]); 

        session_start(); 
        $_SESSION = array(); 
        $_SESSION['usuario']=$usuario->getUsuario(); 
        $_SESSION['nome']=$usuario->getNome(); 
        $_SESSION['timeout']=time(); 
        header("Location: sistema.php");
    }
}
catch (Exception $e)
{   
    print $e->getMessage();
    print "<br><a href='index.php'>Voltar</a>"; 
    exit;
}

?>