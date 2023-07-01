<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
  <meta name="keywords" content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
  <meta name="author" content="pixelstrap">


  <!--google fonts -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
  <link href="lib/fontawesome/css/fontawesome.css" rel="stylesheet">


  <link rel="stylesheet" href="lib/css/estilo.css">

  <link rel="stylesheet" type="text/css" href="lib/assets/css/vendors/sweetalert2.css">

  <!-- ico-font-->




  <link rel="icon" href="./img/favicon.png" type="image/png" />
</head>

<body>
  <!-- login page start-->
  <div class="login-container-fluid">
    <div class="welcome-screen-container">
      <img  src="img/4.webp" alt="looginpage">
    </div>
    <div class="login-contain">

      <div class="login-card">
        <div class="login-border">
          <div class="container-img"><a href=""><img class="" width="200px"  src="img/banner1.png" alt="looginpage"></a>
          </div>

          <form class="form-login" id="form1" class="user">
            <h4>Iniciar sesión en el sistema</h4>
            <p>Ingrese su Usuario y contraseña para iniciar sesión</p>
            <div class="input-login">
              <label class="">Usuario</label>
              <input class="" id="usuario" name="username" type="text" required="" placeholder="usuario..." style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
            </div>
            <div class="input-login">
              <label class="">Contraseña</label>

              <input class="" type="password" id="pass" name="password" required="" placeholder="contraseña" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">


            </div>

            <div class=" btns-group">

              <input type="submit" class="btns btn-color-blue" value="Iniciar Sesión" onclick="enviar_login();">
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="lib/js/acciones.js"></script>

  <script src="lib/js/sweetalert2.js"></script>
  <!-- Plugin used-->
  </div>
</body>

</html>