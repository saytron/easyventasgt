<?php
error_reporting(E_ALL ^ E_NOTICE);
include ('lib/templates/header.php');
if(isset($_GET['num'])){$num = $_GET['num'];}
if(isset($_GET['nacimiento'])){$cod = $_GET['nacimiento'];}
if(isset($_GET['idVenta'])){$idVenta = $_GET['idVenta'];}


if (isset($_GET['eliminar'])) {eliminarUsuario($_GET['eliminar']);}

if (!isset($_SESSION)){session_start();}
$pass = $_SESSION['codigo'];
$usuario = $_SESSION['usuario'];
$rol = $_SESSION['rol'];
if (isset($_POST['idventaProducto2'])){ $idventaProducto2 = $_POST['idventaProducto2'];}

if (!isset($_SESSION['codigo'])) {
  header("location: login.php");
}else {
  ?>


<?php
include ('lib/templates/header.php');
?>
 <title>inicio</title>
</head>
<body>
<header>
 
</header>
<?php
  $pagina = 0;
    include ('lib/templates/nav2.php');
  ?>

  <main>
  <div class="page-body" id="app">
    <div class="container-fluid">
                   <!-- Aqui imprimmimos el producto-->
           
         
      <div class="card shadow">
        <div class="card-body bg-light">
          <span class="text-dark text-center"><h1>EasyVentas gt</h1></span>
          <br>
          <span class="text-success text-center"><h3>Tu mejor opcion en ventas</h3></span>
          
        
          <div class="container-fluid">
            <div class="card-body bg-light">
            <span class="text-danger"><h2>VENTAS DIARIAS</h2></span>
            <canvas id="ventasDia" style="position: relative; height: 40vh; width: 80vw;"></canvas>
            </div>
            <div class="card-body bg-light">
            <span class="text-danger"><h2>VENTAS POR MES</h2></span>
            <canvas id="ventasMes" style="position: relative; height: 40vh; width: 80vw;"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>  
</div>
</main>
<footer>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <?php include ('lib/templates/footer.php'); 
  
    }
  ?>
</footer> 
<script>
const app = new Vue({
  el: '#app',
  data:{
    mensaje: 'EASYVENTAS GT',
    mensaje2: 'Tu mejor opcion en ventas',
    mensaje3: 'Ventas diarias'

 
  }
})

</script>


<script>
 
    var ctx = document.getElementById('ventasDia')
    var myChart = new Chart(ctx, {
        type:'bar',
        data:{
            datasets: [{
                label: 'Ventas en Quetzales',
                backgroundColor: "#4e73df",
      hoverBackgroundColor: "#2e59d9",
      borderColor: "#4e73df",
                borderWidth:1
            }]
        },
        options:{
          responsive: true,
            scales:{
                yAxes:[{
                  ticks:{
                    min: 0,
                    max: 15000,
                    maxTicksLimit: 5,
                    padding: 10,
                 
                  }

                }],
                
            },
            
        },
        
    })

    let url = 'Controller/cargarVentasFecha.php'
    fetch(url)
        .then( response => response.json() )
        .then( datos => mostrar(datos) )
        .catch( error => console.log(error) )


    const mostrar = (ventas) =>{
        ventas.forEach(element => {
            myChart.data['labels'].push(element.fecha)
            myChart.data['datasets'][0].data.push(element.venta)
            myChart.update()
        });
        console.log(myChart.data)
    }    

    chartMes();

</script>
