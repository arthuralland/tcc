<?php

session_start();
if(isset($_SESSION['user'])){
header("location: message.php");
}
require "../db.php";

if(isset($_POST['btn_login'])){
    $matricula = $_POST['matricula'];
    $senha = $_POST['senha'];
    $messeg = "";
    
    if(empty($matricula) || empty($senha)) {
        $messeg = "Username/Password con't be empty";
        header("location: login.php");
        echo "$messeg";
    } else {
        $sql = "SELECT matricula, senha, nome FROM usuario WHERE matricula=? AND 
      senha=? AND administrador='true'";
        $query = $pdo->prepare($sql);
        $query->execute(array($matricula,$senha));

        if($query->rowCount() >= 1) {

            $row = $query->fetch(PDO::FETCH_ASSOC);

            $_SESSION['user'] = $row['nome'];
            header("location: index.php");
        } else {
            $messeg = "Username/Password is wrong";
            echo "$messeg";
        }
}
}
?>