<?php

require_once("globals.php");
require_once("db.php");
require_once("models/User.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");

$message = new Message($BASE_URL);

$userDao = new UserDAO($conn, $BASE_URL);

// Resgata o tipo do formulário
$type = filter_input(INPUT_POST, "type");

// deletar user
if ($type === "delete") {

    // Resgata dados do usuário
    $userData = $userDao->verifyToken();

    // Obtém o ID do usuário a ser excluído
    $userIdToDelete = $userData->id;

    // Chama o método delete do UserDAO
    $userDao->delete($userIdToDelete);
}
