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
		$resultado = $sql->selectData("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(
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
    return $sql->selectData("SELECT * FROM tb_usuarios ORDER BY deslogin;");
  }

  public function search($login)
  {
    $sql = new Sql();
    return $sql->selectData("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(
      ':SEARCH'=>"%".$login."%"
    ));
  }
  public function login($login, $password)
  {
    $sql = new Sql();
    $resultado = $sql->selectData("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD", array(
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
    $this->setId(($dados['idusuario']));
    $this->setLogin(($dados['deslogin']));
    $this->setSenha(($dados['dessenha']));
    $this->setCadastro(new DateTime($dados['dtcadastro']));

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
  public function update($login, $senha)
  {
    $this->setLogin($login);
    $this->setSenha($senha);
    $sql = new Sql();
    $sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :SENHA WHERE idusuario = :ID", array(
      ":LOGIN"=>$this->getLogin(),
      ":SENHA"=>$this->getSenha(),
      ":ID"=>$this->getId()
    ));
  }
  public function delete()
  {
    $sql = new Sql();
    $sql->query("DELETE FROM tb_usuarios WHERE idusuario = :ID", array(
      ":ID"=>$this->getId()
    ));
    $this->setId(0);
    $this->setLogin(NULL);
    $this->setSenha(NULL);
    $this->setCadastro(new DateTime());
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

