<?php
    include ("cl_contato.php");
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
   
    include("vsessao.php");  

    //Listagem de Usuários
    if($op=="lc")
    {
        $conec=conec::conecta_mysql("localhost", "root", "", "TrabalhoMurylo");
        try
        {
            $conec->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sth=$conec->prepare("SELECT * FROM contato");
            $sth->execute();
            print "<h2 align='center'>Listagem de Contatos</h2>";
            print "<table align='center' border='1'> <tr><td>Id</td><td>Nome</td><td>Email</td></tr>";
            if($sth->rowCount()==0)
            {
                print "<tr><td>Nada para listar</td></tr></table> <br><a href='sistema.php'>Voltar</a>"; 
                exit;
            }
            $linha=$sth->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_FIRST);
            do
            {
                $ous= new contato($linha[0], $linha[2], $linha[1]);
                print "<TR><TD>". $ous->getId()."</TD>". "<TD>".$ous->getNome()."</TD>". "<TD>".$ous->getEmail()."</TD></TR>";
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
  exit;
?>