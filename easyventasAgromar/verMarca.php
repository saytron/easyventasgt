<?php
error_reporting(E_ALL ^ E_NOTICE);
if (!isset($_SESSION)) {

  session_start();
}
if (isset($_SESSION['codigo'])){$pass = $_SESSION['codigo'];}
if (isset($_SESSION['usuario'])){$usuario = $_SESSION['usuario'];}
if (isset($_SESSION['rol'])){$rol = $_SESSION['rol'];}

if (!isset($_SESSION['codigo'])) {
  header("location: login.php");
}else{
include ('lib/templates/header.php'); 

require_once('Model/class.conexion.php');
  require_once('Model/class.consultas.php');
   require_once('Controller/cargarDatos.php');


  

?>



</head> 
<body>

<?php include ('lib/templates/nav.php'); ?>
	
	<div class="container">
		<section>
   		 	<article class="col-xs-12 col-sm-8 col-md-9">
      			<h1>MARCAS DISPONIBLES</h1>
    		</article>
    		<article class="col-xs-12 col-sm-4 col-md-3">
      	<div id="resultado">
          
        </div>		 
        
    		</article>
         <article class="col-xs-12 col-sm-4 col-md-4"></article>
        <article class="col-xs-12 col-sm-4 col-md-4">
        <div id="resultado">
          <?php
          //cargar();
          ?>
        </div>     
        
        </article>
        <article class="col-xs-12 col-sm-4 col-md-4"></article>
  		</section>

		
				
		
	
<?php include ('lib/templates/footer.php'); ?>

</body>

</html>

<?php
}
?>