<?php
    include ("cl_usuario.php");
    include ("cl_banco.php");
    if(isset($_GET['op'])) 
        $op=$_GET['op'];
    else 
        $op="";
    if($op=="") 
    {
        header("Location: index.php"); 
        exit;
    }
    if($op=="asu") 
    {
        header("Location: asenha.php"); 
        exit;
    }
    include("vsessao.php");
    if($_SESSION["cat"]!="00")
    {
        header("Location: index.php"); 
        exit;
    }

    //Verificação de ação de Inclusão do Usuário
    if($op=="iu")
    {
        print "<p align='center'>Novo Usuário</p>
        <form method='post' action='musuario.php?op=iiu'>
        <p align='center'>
        <br>Usuário<input type='text' name='usuario' size='8' maxglength='8'>
        <br>Nome<input type='text' name='nome' size='50' maxglength='50'>
        <br>Categoria:<select name='cat'>
        <option value=''>Selecione <option value='01'>Diretoria
        <option value='02'>Chefia <option value='03'>Subordinado
        </select>
        <br><input type='submit' value='Incluir'></p></form>"; 
        exit;
    }

    //Inclusão do Usuário
    if($op=="iiu")
    {
        $mensagem="";
        $usuario=new usuario($_POST['usuario'],$_POST['usuario'], $_POST['nome'],$_POST['cat']);
        if($usuario->getUsuario()=="") 
            $mensagem.="<br>Usuário é obrigatório";
        if($usuario->getNome()=="") 
            $mensagem.="<br>Nome é obrigatório";
        if($usuario->getCat()=="") 
            $mensagem.="<br>Selecione a categoria";
        if($mensagem!="")
        {
            print $mensagem;
            print"<br><a href='musuario.php?op=iu'>Voltar</a>";
            exit;
        }
        $conec=conec::conecta_mysql("localhost","root","","contatos");
        try
        {
            $conec->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sth=$conec->prepare("INSERT INTO usuario values(?,?,?,?)");
            $sth->execute(array ($usuario->getUsuario(), SHA1($usuario->getSenha()), $usuario->getNome(), $usuario->getCat()));
            print "<br>Usuário incluido com sucesso <br><a href='sistema.php'>Voltar</a>";
        }
        catch(Exception $e)
        {
            print "Erro ".$e->getMessage(). "<br><a href='sistema.php'>Voltar</a>"; 
            exit;
        }
        exit;
    }

    //Listagem de Usuários
    if($op=="lu")
    {
        $conec=conec::conecta_mysql("localhost", "root", "", "contatos");
        try
        {
            $conec->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sth=$conec->prepare("SELECT * FROM usuario");
            $sth->execute();
            print "<table border='1'> <tr><td>Usuário</td><td>Nome</td><td>Categoria</td></tr>";
            if($sth->rowCount()==0)
            {
                print "<tr><td>Nada para listar</td></tr></table> <br><a href='sistema.php'>Voltar</a>"; 
                exit;
            }
            $linha=$sth->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_FIRST);
            do
            {
                $ous= new usuario($linha[0],"", $linha[2], $linha[3]);
                print "<TR><TD>". $ous->getUsuario()."</TD>". "<TD>".$ous->getNome()."</TD>". "<TD>".$ous->getCat()."</TD></TR>";
            }
            while($linha=$sth->fetch(PDO::FETCH_NUM,PDO::FETCH_ORI_NEXT));
                print"</TABLE><br><a href='sistema.php'>Voltar</a>";
        }
        catch(Exception $e)
        { 
            print"<br>Falha: Usuários não listados“. $e->getMessage() ";
            print "<br><a href='sistema.php'> Voltar</a>";
            exit; 
        }
        exit;
    }

    //Listagem para exclusão de Usuários
    if($op=="eu")
    {
        $conec=conec::conecta_mysql("localhost", "root", "", "contatos");
        try
        {
            $conec->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sth=$conec->prepare("SELECT * FROM usuario");
            $sth->execute();
            if($sth->rowCount()==1)
            {
                print " <p>Nenhum Usuário para excluir</p>";
                print "<br><a href='sistema.php'> Voltar</a>"; 
                exit; 
            }
            print "<form method= 'post' action= 'musuario.php?op=eeu'> <select name='usuario'> 
            <option value= '' >Selecione para excluir";
            $linha=$sth->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_FIRST);
            do
            {
                $ous= new usuario($linha[0],"", $linha[2], $linha[3]);
 
                if($ous->getCat() != "00")
                    print "<option value='".$ous->getUsuario(). "'>".$ous->getNome();
            }
            while($linha=$sth->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT));
                print"</SELECT><br><input type='submit' value='Excluir'> </form><br><a href='sistema.php'>Voltar</a>";
        }
        catch (Exception $e)
        { 
            print"<br>Falha: ". $e->getMessage();
            print "<br><a href='sistema.php'>Voltar</a>"; 
            exit; 
        }
        exit;
    }

    //Exclusão do Usuário
    if($op=="eeu")
    { 
        $usuario= new usuario($_POST["usuario"], "", "", "", "");
        if($usuario->getusuario()=="")
        { 
            print "Selecione um usuario para Excluir";
            print "<br><a href='sistema.php'>Voltar</a>"; 
            exit;
        }
        $conec=conec::conecta_mysql ("localhost", "root", "", "contatos");
        try
        {
            $conec->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sth=$conec->prepare("DELETE FROM usuario WHERE usuario=?");
            $sth->execute(array($usuario->getusuario()));
            if($sth->rowCount()==0) 
                print "Usuário não excluído";
            else 
                print "Usuário ".$usuario->getnome(). "Excluído com sucesso";
                print "<br><a href='sistema.php'>Voltar</a>";
        }
        catch(Exception $e)
        {
            print "<br>Falha: Usuário não excluido " . $e->getMessage(). "<br><a href='sistema.php'>Voltar</a>"; 
            exit; 
        }
        exit;
    }

    //Seleção para alteração de Usuário
    if($op=="au")
    {
        $conec=conec::conecta_mysql ("localhost", "root", "", "contatos");
        try 
        { 
            $conec->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            print "<h2>Alteração de usuário</h2>";
            $sth=$conec->prepare("SELECT * FROM usuario WHERE cat <> '00'",
            array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $sth->execute();
            if($sth->rowCount()==0)
            {
                print "Nenhum usuário para alterar <br><a href='sistema.php'>Voltar</a>";
                exit;
            }
            $linha = $sth->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_FIRST);
            print "<form method='post' action='musuario.php?op=aeu'>";
            print "<SELECT name='usuario'>";
            do
            {
                $ous= new usuario($linha[0],"", $linha[2], $linha[3]);
                print "<option value='".$ous->getUsuario(). "'>".$ous->getNome();
            } 
            while($linha=$sth->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT));
                print"</SELECT><INPUT type='submit' value='Editar'></form> <br><a href='sistema.php'>Voltar</a>";
        } 
        catch (Exception $e)
        {   
            print "<br>Falha: " . $e->getMessage(). "<br><a href='sistema.php'>Voltar</a>";
            exit; 
        }
        exit;
    }

    //Alteração de Usuário
    if ($op=="aeu")
    {
        $usuario=$_POST["usuario"];
        $conec=conec::conecta_mysql ("localhost", "root", "", "contatos");
        try 
        {
            $conec->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sth=$conec->prepare("SELECT * FROM usuario WHERE usuario='$usuario'",
            array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $sth->execute();
            $linha = $sth->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_FIRST);
            $ous= new usuario($linha[0],"", $linha[2], $linha[3]);
            print "<h2>Alteração de usuário</h2>";
            print "<form method='post' action='musuario.php? op=acu'>";
            print "Usuário:<INPUT type='text' name='usuario' value='".$ous->getUsuario()."' readonly>";
            print "Nome:<INPUT type='text' name='nome' value='".$linha[2]."'>";
            print "Categoria:<SELECT name='cat'>";
            if($ous->getCat()=="01")
                print "<OPTION value='01' selected>Diretoria";
            else 
                print "<OPTION value='01'>Diretoria";
            if($ous->getCat()=="02")
                print "<OPTION value='02' selected>Chefia";
            else 
                print "<OPTION value='02'>Chefia";
            if($ous->getCat()=="03")
                print "<OPTION value='03' selected>Subordinado";
            else 
                print "<OPTION value='03'>Subordinado";
                print "</SELECT><INPUT type='submit' value='Confirmar'></form> <br><a href='sistema.php'>Voltar</a>";
        }
        catch(Exception $e)
        {
            print "<br>Falha: " . $e->getMessage(). "<br><a href='sistema.php'>Voltar</a>";
            exit; 
        }
        exit;
    }
    //Confirmação da Alteração do Usuário
    if ($op=="acu")
    {
        $ous= new usuario($_POST["usuario"],"",$_POST["nome"], $_POST["cat"]);
        if($ous->getusuario()=="") 
            print "<br>Selecione para Alterar";
        if($ous->getnome()=="") 
            print "<br>O nome em branco";
        if($ous->getcat()=="") 
            print "<br>Selecione uma categoria";
        if($ous->getusuario()=="" || $ous->getnome()=="" || $ous->getcat()=="")
        {
            print "<br><a href='musuario.php?op=au'>Voltar</a>";
            exit;
        }
        $conec=conec::conecta_mysql ("localhost", "root", "", "contatos");
        try 
        {
            $conec->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sth=$conec->prepare("UPDATE usuario set nome=?,cat=? WHERE usuario=?");
            $sth->execute(array($ous->getnome(), $ous->getcat(), $ous->getusuario()));
            if($sth->rowCount()==0) 
                print "<br>Usuário não alterado";
            else 
                print "<br>Usuário ".$ous->getnome()." Alterado com sucesso";
                print "<br><a href='sistema.php'>Voltar</a>";
        }
        catch (Exception $e)
        {
            print "<br>Falha: Usuário não alterado ".$e->getMessage(). "<br><a href='sistema.php'>Voltar</a>";
            exit;
        }
        exit;
    }
?>