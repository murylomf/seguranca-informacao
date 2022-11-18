<?php
class contato 
{
    private $id; 
    private $email;
    private $nome; 
    function __construct($v_id, $v_email, $v_nome)
    {
        $this->id=$v_id; 
        $this->email=$v_email;
        $this->nome=$v_nome;
    }

    public function getId(){ return $this->id; }
    public function getEmail(){ return $this->email; } 
    public function getNome(){ return $this->nome; }

    PUBLIC FUNCTION setId ($v_id)
    {
        $this->id=$v_id;
    }

    PUBLIC FUNCTION setEmail ($v_email)
    {
        $this->email=$v_email;
    }

    PUBLIC FUNCTION setNome ($v_nome)
    {
        $this->nome=$v_nome;
    }
}
?>