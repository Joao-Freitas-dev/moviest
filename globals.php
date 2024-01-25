<?php
    // armazenamento de dados temporários 
    session_start();
    // construção da url 
    $BASE_URL ="http://" . $_SERVER["SERVER_NAME"] . dirname($_SERVER["REQUEST_URI"]. "?") . "/";