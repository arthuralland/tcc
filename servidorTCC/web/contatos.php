<?php
// A vida da sessão é de uma hora 60 * 60 = 3600
session_start();

if(isset($_SESSION['user'])==false){
  header("location: logout.php");
} 




?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <link href="css/cssIcons.css" rel="stylesheet">


</head>

<body >
	

  <!-- As a heading -->
  <nav class="navbar navbar-dark bg-dark">
    <form class="form-inline">
      <a href="http://snapdark.com/servidorTCC/web/index.php" class="btn btn-secondary active" role="button" aria-pressed="true">
        <i class="small material-icons" style="margin-top: 5px;">arrow_back</i></a>
        <span class=" navbar-brand mb-0 h1" style="margin-left: 7px;"><?php echo "Seja Bem Vindo: ".$_SESSION['user']; ?></span></form>
        <a href="http://snapdark.com/servidorTCC/web/logout.php" class="btn btn-secondary active" role="button" aria-pressed="true">Logout</a>
      </nav>


      <div class="container-fluid">
        <?php 

        include '../db.php';
        $matricula = $_GET['matricula'];


        $query = $pdo->prepare("SELECT nome,foto FROM usuario WHERE matricula=$matricula");
        $query->execute(array($matricula));

        if($query->rowCount() >= 1) {

          $row = $query->fetch(PDO::FETCH_ASSOC);


          echo '<img src="'.$row['foto'].'"class="rounded" style="width:100px;float:left;">'.'<h1 class="display-4" style="margin-top:15px;position:relative;bottom:-26px;"">'.$row['nome'].'</h1>';
          echo '<p class="lead" style="margin-bottom:35px;position:relative;bottom:-26px;">Esta página contém todos os contatos de '.$row['nome'].' capturado pelo app.</p>';
        }
        ?>

        <table class="table table-striped">
          <thead>
            <tr>
              <th>Nome Dos Contatos</th>
              <th>Número Dos Contatos</th>

            </tr>
          </thead>
          <tbody>
            <?php
            include '../db.php';

            $matricula = $_GET['matricula'];


            $select = $pdo->query("SELECT nome_contatos, numero_contatos FROM contatos_do_usuario WHERE matricula=$matricula ORDER BY nome_contatos ASC");

            $resultado = $select->fetchAll(PDO::FETCH_ASSOC);
            foreach ($resultado as $row) {
              echo '<tr>';
              echo '<td>'. $row['nome_contatos'] . '</td>';
              echo '<td>'. $row['numero_contatos'] . '</td>';
              echo '</tr>';
            }

            ?>
          </tbody>
        </table>
      </div>






      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    </body>

    </html>