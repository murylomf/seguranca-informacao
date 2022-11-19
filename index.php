<HTML>
    <HEAD>
        <TITLE>Projeto Final</TITLE>
    </HEAD>
    <BODY>
        <?php 
            session_start();
            session_destroy();
        ?>
        <h2 align="center">Login</h2>
        <form method="post" action="login.php">
            <p align="center">Usuário:<input type="text" name="usuario" size="8" maxlength="8"></p>
            <p align="center">Senha:<input type="password" name="senha" size="8" maxlength="8"></p>
            <p align="center"><input type="submit" value="Login"></p>
        </form>
    </BODY>
</HTML>