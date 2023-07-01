<?php
error_reporting(E_ALL ^ E_NOTICE);
$pass = "";
$usuario = "";
$rol = "";
if (!isset($_SESSION)) {
  session_start();
}
if (isset($_SESSION['codigo'])){
  $pass = $_SESSION['codigo'];
  $usuario = $_SESSION['usuario'];
  $rol = $_SESSION['rol'];
}

if (isset($_POST['idventaProducto2'])) {
  $idventaProducto2 = $_POST['idventaProducto2'];
}

if (!isset($_SESSION['codigo'])) {
  header("location: login.php");
} else {
?>


  <?php
  include('lib/templates/header.php');
  ?>
  <title>inicio</title>
  </head>

  <body>
    <header>

    </header>
    <?php
    $pagina = 0;
    include('lib/templates/nav2.php');
    ?>

    <main>
      <div class="page-body">
        <div class="container-fluid card shadow mt-4 card-principal-page">
          <!-- Aqui imprimmimos el producto-->

          <div class="card-body">
            <span class="text-dark text-center">
              <h1>EasyVentas gt</h1>
            </span>
            <br>
            <span class="text-success text-center">
              <h3>Tu mejor opcion en ventas</h3>
            </span>


            <div class="container-fluid">
              <div class="card-body">
                <span class="text-danger">
                  <h2>VENTAS DIARIAS</h2>
                </span>
                <canvas class="btn-outline" id="ventasDia" style="position: relative; height: 40vh; width: 80vw;"></canvas>
              </div>
              <div class="card-body">
                <span class="text-danger">
                  <h2>VENTAS POR MES</h2>
                </span>
                <canvas class="btn-outline" id="ventasMes" style="position: relative; height: 40vh; width: 80vw;"></canvas>
              </div>
              <div class="card-body">
                <span class="text-danger">
                  <h2>VENTAS POR MARCA</h2>
                </span>
                <canvas class="btn-outline" id="ventasRepuesto" style="position: relative; height: 40vh; width: 80vw;"></canvas>
              </div>
              <!--
              <div class="card-body">
                <span class="text-danger">
                  <h2>VENTAS POR MARCA</h2>
                </span>
                <canvas id="ventasMarca" style="position: relative; height: 40vh; width: 80vw;"></canvas>
              </div>
              -->
            </div>
          </div>
        </div>
      </div>
    </main>
    <footer>
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php include('lib/templates/footer.php');
  }
    ?>
    </footer>


    <script>
      var ctx = document.getElementById('ventasDia')
      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          datasets: [{
            label: 'Ventas en Quetzales',
            backgroundColor: "#4e73df",
            hoverBackgroundColor: "#2e59d9",
            borderColor: "#4e73df",
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          scales: {
            yAxes: [{
              ticks: {
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
        .then(response => response.json())
        .then(datos => mostrar(datos))
        .catch(error => console.log(error))


      const mostrar = (ventas) => {
        ventas.forEach(element => {
          myChart.data['labels'].push(element.fecha)
          myChart.data['datasets'][0].data.push(element.venta)
          myChart.update()
        });
      }

      chartMes();
      chartRepuesto();
      //chartMarca();

      function chartRepuesto() {
	var ctx = document.getElementById('ventasRepuesto')
	var myChart = new Chart(ctx, {
		type: 'pie',
		data: {

			
			datasets: [{
				label: 'Ventas en Quetzales',
				lineTension: 0.3,
				backgroundColor: [
        'rgb(17, 84, 226)',
        'rgb( 178, 9, 9 )',
        'rgb( 8, 158, 35 )',
        'rgb( 205, 184, 5 )',
        'rgb( 225, 60, 248 )',
        'rgb( 7, 150, 139 )',
    ],// Color de fondo
    borderColor: [
        'rgb( 17, 84, 226 )',
        'rgb( 178, 9, 9 )',
        'rgb( 8, 158, 35 )',
        'rgb( 205, 184, 5 )',
        'rgb( 225, 60, 248 )',
        'rgb( 7, 150, 139 )',
    ],// Color del borde
    borderWidth: 1,// Ancho del borde
			}]
		},
		options: {
			responsive: true,
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero: true
					}

				}]
			}
		}
	})

	let url = 'Controller/cargarVentasReporteRepuesto.php'
	fetch(url)
		.then(response => response.json())
		.then(datos => mostrar(datos))
		.catch(error => console.log(error))


	const mostrar = (ventas) => {
		ventas.forEach(element => {
			myChart.data['labels'].push(element.marca)
			myChart.data['datasets'][0].data.push(element.venta)
			myChart.update()
		});

	}


}

    </script>

