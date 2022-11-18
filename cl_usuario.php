<?php
class usuario 
{
    private $usuario; 
    private $senha;
    private $nome; 
    function __construct($v_usuario, $v_senha, $v_nome)
    {
        $this->usuario=$v_usuario; 
        $this->senha=$v_senha;
        $this->nome=$v_nome;
    }

    public function getUsuario(){ return $this->usuario; }
    public function getSenha(){ return $this->senha; } 
    public function getNome(){ return $this->nome; }

    PUBLIC FUNCTION setUsuario ($v_usuario)
    {
        $this->usuario=$v_usuario;
    }

    PUBLIC FUNCTION setSenha ($v_senha)
    {
        $this->senha=$v_senha;
    }

    PUBLIC FUNCTION setNome ($v_nome)
    {
        $this->nome=$v_nome;
    }
}
?>