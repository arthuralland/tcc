<!DOCTYPE html>
<html>
<head>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

  <link href="css/login.css" rel="stylesheet">

  <meta charset="UTF-8">
  <title>Login</title>
</head>

<body class="text-center">
  <form class="form-signin" action="http://snapdark.com/servidorTCC/web/validacao.php" method="post">
    <img class="mb-4" src="img/logo-if.png" alt="" width="71" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Preencha os campos</h1>
    
    <input name="matricula" type="login" id="matricula" class="form-control" placeholder="Matrícula" required autofocus>
    
    <input name="senha" type="password" id="inputPassword" class="form-control" placeholder="Senha" required>
    
    <button class="btn btn-lg btn-primary btn-block form-control" name="btn_login" type="submit">Entrar</button>
  </form>
</body>

</html>