<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart MySQL</title>

    <style>        
    </style>
</head>
<body>
    
    <canvas id="myChart" style="position: relative; height: 40vh; width: 80vw;"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        var ctx = document.getElementById('myChart')
        var myChart = new Chart(ctx, {
            type:'bar',
            data:{
                datasets: [{
                    label: 'Ventas en Quetzales',
                    backgroundColor: ['#6bf1ab','#63d69f', '#438c6c', '#509c7f', '#1f794e', '#34444c', '#90CAF9', '#64B5F6', '#42A5F5', '#2196F3', '#0D47A1'],
                    borderColor: ['black'],
                    borderWidth:1
                }]
            },
            options:{
                scales:{
                    y:{
                        beginAtZero:true
                    }
                }
            }
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



    </script>
</body>
</html>