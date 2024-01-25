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
  if($type === "register") {

    // Recebendo os inputs do formulário
    $name = filter_input(INPUT_POST, "name");
    $lastname = filter_input(INPUT_POST, "lastname");
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, "password");
    $confirmPassword = filter_input(INPUT_POST, "confirmpassword");

    // Verificação de campos necessários para registro
    if($name && $lastname && $email && $password) {



    } else {

        $message->setMessage("Por favor preencha todos os campos", "error", "auth.php");

    }

    // Fazer o login do usuário
    } else if($type === "login") {

    }