<?php

//pegando nossos campos de user
class User
{

  public $id;
  public $name;
  public $lastname;
  public $email;
  public $password;
  public $image;
  public $bio;
  public $token;

  public function generateToken()
  {
    return bin2hex(random_bytes(50));
  }
  public function generatePassword($password)
  {
    return password_hash($password, PASSWORD_DEFAULT);
  }
  public function getFullName($user)
  {
    return $user->name . " " . $user->lastname;
  }
}

//contrato para utilização dos métodos corretos para ser implementados na classe em UserDao
interface UserDAOInterface
{

  public function buildUser($data);
  public function create(User $user, $authUser = false);
  public function update(User $user, $redirect = true);
  public function findByToken($token);
  public function verifyToken($protected = true);
  public function setTokenToSession($token, $redirect = true);
  public function destroyToken();
  public function authenticateUser($email, $password);
  public function findByEmail($email);
  public function changePassword(User $user);
  public function delete($id);
}
