<HTML>
<HEAD>
    <TITLE>Sistema de Contatos</TITLE>
<style>p, h3{text-align: center;</style></HEAD>
<BODY><font size="4">
<p>Sistema de Contatos</p>
<?php
include ("cl_usuario.php");
include ("cl_banco.php");
if (isset($_GET['op'])) $op=$_GET['op'];
else $op="";
if ($op=="")
 {
 print "<H3>Login</H3>
 <FORM method='post' action='asenha.php?op=asu'>
 <p>Usuário:<INPUT type='text' name='usuario'>
 Senha:<INPUT type='password' name='senha'></P>
 <p>NovaSenha:<INPUT type='password' name='nsenha'>
 Repetir:<INPUT type='password' name='rsenha'></P>
 <p><INPUT type='submit' value='Alterar'></p></FORM>";
 exit;
}
if ($op=="asu")
 {$ous = new usuario($_POST["usuario"], $_POST["senha"],
 "", "");
 $nsenha= trim($_POST["nsenha"]); /*Limpa se há espaços*/
 $rsenha= trim($_POST["rsenha"]); /*no final do campo*/
 if ($nsenha=="" || $nsenha != $rsenha)
 {print "Nova senha inválida ou repetida diferente
 <a href='asenha.php'> Voltar</a>";
 exit;}
$conec=conec::conecta_mysql("localhost","root","","contatos");

try {$conec->setAttribute(PDO::ATTR_ERRMODE,
    PDO::ERRMODE_EXCEPTION);
    $sth=$conec->prepare("SELECT * FROM usuario
    WHERE
    usuario='".$ous->getUsuario()."'
    and
    senha=SHA1('".$ous->getSenha()."')");
    $sth->execute();
    if ($sth->rowCount()==0)
    {print "### Usuário e ou senha invalido(s)
    <a href='asenha.php'> Voltar</a>";
    exit;}

    $sth=$conec->prepare("UPDATE usuario SET senha=
    SHA1('".$nsenha."')
    WHERE usuario='".
    $ous->getUsuario()."'");
    $sth->execute();
    if ($sth->rowCount()==0)
    {print "Senha não alterada
    <a href='asenha.php'> Voltar</a>";}
    else
    {print "Senha alterada
    <a href='index.php'> Voltar</a>";}
    }
    catch (Exception $e) {print "<br>Falha: ". $e->getMessage().
    "<a href='asenha.php'> Voltar</a>";}
    exit;}
   ?>
</BODY>
</HTML>

