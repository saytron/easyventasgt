<?php
error_reporting(E_ALL ^ E_NOTICE);
include ('lib/templates/header.php'); ?>



</head> 
<body>

<?php include ('lib/templates/nav.php'); ?>
	
	<div class="container">
		<section>
   		 	<article class="col-xs-12 col-sm-8 col-md-9">
      			<h1>NUEVA MARCA</h1>
    		</article>
    		<article class="col-xs-12 col-sm-4 col-md-3">
      			
    		</article>
  		</section>
  		<article class="col-xs-12 col-sm-8 col-md-4">
      			
    		</article>
    		<article class="col-xs-12 col-sm-4 col-md-4">
            <form method="post" id="form1">
            <input class="form-control" type="text" name="descMarca" id="descMarca" placeholder="Marca">
            <input type="button" class="btn btn-primary btn-lg btn-block" id="registrarMarca" value="enviar" onclick="enviar_marca();">
            
          
        </form>
    			
      			<div id="resultado"></div>
    		</article>
    		<article class="col-xs-12 col-sm-4 col-md-4">
      			
    		</article>
  		<section>
  			
  		</section>
		
	</div>
		
				
		
	
<?php include ('lib/templates/footer.php'); ?>
</body>

</html>