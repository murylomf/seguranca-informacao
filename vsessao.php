<?php
$limite=120; 
session_start(); 
if (!isset($_SESSION['usuario']))

 {print "<H2>Área restrita</H2>";
 print "<p><a href='index.php'>Login</a></p>"; 
 exit;}
else {$duracao=time() - $_SESSION['timeout']; 
 if ($duracao > $limite)
 {session_destroy();
 header ("Location: index.php");}}
 
$_SESSION['timeout'] = time(); // Restaura o timeout da sessão
?>