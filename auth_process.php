<?php

require_once("db.php");
require_once("globals.php");
require_once("models/User.php");
require_once("dao/UserDAO.php");
require_once("models/Message.php");

$message = new Message($BASE_URL);

$userDao = new UserDAO($conn, $BASE_URL);

// Verificando o tipo do formulário
$type = filter_input(INPUT_POST, "type");

// Verificação do tipo de formulário
if ($type === "register") {

  // Recebendo os inputs do formulário
  $name = filter_input(INPUT_POST, "name");
  $lastname = filter_input(INPUT_POST, "lastname");
  $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
  $password = filter_input(INPUT_POST, "password");
  $confirmPassword = filter_input(INPUT_POST, "confirmpassword");

  // Verificação de campos necessários para registro
  if ($name && $lastname && $email && $password) {

    // Verificar se as senhas batem
    if ($password === $confirmPassword) {
      //verificando se e-mail já existe no sistema
      if ($userDao->findByEmail($email) === false) {
        $user = new User();
        //Criação de token e senha
        $userToken = $user->generateToken();
        $finalPassword = $user->generatePassword($password);
        //montando objeto user
        $user->name = $name;
        $user->lastname = $lastname;
        $user->email = $email;
        $user->password = $finalPassword;
        $user->token = $userToken;

        $auth = true;
        $userDao->create($user, $auth);
      } else {
        //envia uma msg de erro caso e-mail já exista
        $message->setMessage("User já cadastrado, tente outro E-mail", "error", "auth.php");
      }
    } else {
      //envia uma msg de erro caso as senhas não batam 
      $message->setMessage("As senhas não são iguais", "error", "auth.php");
    }
  } else {
    //envia uma msg de erro caso os campos não sejam todos preenchidos
    $message->setMessage("Por favor preencha todos os campos", "error", "auth.php");
  }

  // Fazer o login do usuário
} else if ($type === "login") {
  $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
  $password = filter_input(INPUT_POST, "password");

  //tentar autenticar user
  if ($userDao->authenticateUser($email, $password)) {
    $message->setMessage("Seja bem vindo", "error", "editprofile.php");
    //redireciona o user, caso não consiga autenticar
  } else {
    $message->setMessage("User e/ou senhas incorretos", "error", "auth.php");
  }
} else {
  $message->setMessage("Informações inválidas", "error", "auth.php");
}
