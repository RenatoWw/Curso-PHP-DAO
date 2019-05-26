<?php

class Usuario
{
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
		$results = $sql->selectData("SELECT * FROM usuarios WHERE id = :ID", array(
			":ID"=>$id
		));
    if (count($resultado) > 0)
    {
      $this->setData($resultado[0]);
    }
  }
  public function getList()
  {
    $sql = new Sql();
    return $sql->selectData("SELECT * FROM usuarios ORDER BY login;");
  }

  public function search($login)
  {
    $sql = new Sql();
    return $sql->selectData("SELECT * FROM usuarios WHERE login LIKE :SEARCH ORDER BY login", array(
      ':SEARCH'=>"%".$login."%"
    ));
  }
  public function login($login, $password)
  {
    $sql = new Sql();
    $results = $sql->selectData("SELECT * FROM usuarios WHERE login = :LOGIN AND senha = :PASSWORD", array(
      ":LOGIN"=>$login,
      ":PASSWORD"=>$password
    ));
    if (count($resultado) > 0)
    {
      $this->setData($resultado[0]);
    }else
    {
      throw new Exception("Login e/ou senha inválidos.");
    }
  }
  public function setData($dados)
  {
    $this->setId(($dados['id']));
    $this->setLogin(($dados['login']));
    $this->setSenha(($dados['senha']));
    $this->setCadastro(new DateTime($dados['cadastro']));

  }
  public function insert()
  {
    $sql = new Sql();
    $resultado = $sql->selectData("CALL sp_usuarios_insert(:LOGIN, :SENHA)", array(
      ":LOGIN"=>$this->getLogin(),
      ":PASSWORD"=>$this->getSenha()
    ));
    if(count($resultado) > 0)
    {
      $this->setData($resultado[0]);
    }
  }
  public function __construct($login = "", $password = "")
  {
    $this->setLogin($login);
    $this->setSenha($password);
  }
  public function __toString()
  {
    try
    {
      if ($this->getId())
      {
        return json_encode(array(
          "idusuario"=>$this->getId(),
          "deslogin"=>$this->getLogin(),
          "dessenha"=>$this->getSenha(),
          "dtcadastro"=>$this->getCadastro()->format("d/m/Y H:i:s")));
      } else {
          throw new Exception("Usuário inexistente.");
        }
      }
        catch (Exception $e) {
          return $e->getMessage();
    } 
  }
}

