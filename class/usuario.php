<?php

class Usuario {
  private $id;
  private $login;
  private $senha;
  private $cadastro;

  public function getId(){
    return $this->id;
  }
  public function setId($valor){
    $this->id = $valor;
  }
  public function getLogin(){
    return $this->login;
  }
  public function setLogin($valor){
    $this->login = $valor;
  }
  public function getSenha(){
    return $this->senha;
  }
  public function setSenha($valor){
    $this->senha = $valor;
  }
  public function getCadastro(){
    return $this->cadastro;
  }
  public function setCadastro($valor){
    $this->cadastro = $valor;
  }

  public function loadById($id){
    $sql = new Sql();
    $resultado = $sql->select("SELECT * FROM usuarios WHERE id = :ID", array(
      ":ID"=>$id
    ));
    if (count($resultado) > 0)
    {
      $linha = $resultado[0];
      $this->setId(($linha['id']));
      $this->setLogin(($linha['login']));
      $this->setSenha(($linha['senha']));
      $this->setCadastro(new DateTime($linha['cadastro']));
    }
  }
  public function __toString()
  {
    return json_encode(array(
      "id"=>$this->getId(),
      "login"=>$this->getLogin(),
      "senha"=>$this->getSenha(),
      "cadastro"=>$this->getCadastro()->format('d/m/Y H:i:s')
    ));
  }
}
