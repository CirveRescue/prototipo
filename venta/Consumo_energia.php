<?php include("template/cabecera.php"); ?>


<h1>Gráfica</h1>
    <canvas width="100" height="1 00" id="miGrafica"></canvas>
    <div >  
      <label>Consumo de agua:</label> 
      <label id="miGrafica"></label> 
    </div>
    

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.3.2"></script>
<script>
// Autenticación mediante clave API
const apiKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJkZXYiOiJFU1AzMiIsImlhdCI6MTY4MjQ2MzUyMSwianRpIjoiNjQ0ODViMjFkNzQ5ZjYyZDk3MGY2NWRmIiwic3ZyIjoidXMtZWFzdC5hd3MudGhpbmdlci5pbyIsInVzciI6IklzYWlNYWRyaWdhbCJ9.r6RjLww9L7mVDC0UgiatlLabyjZoXgtY8P9TURtdl3g';
const authHeader = {'Authorization': 'Bearer ' + apiKey};




const miGrafica = document.getElementById('miGrafica').getContext('2d');
const grafica = new Chart(miGrafica, {
  type: 'bar',
  data: {
    labels: ['Consumo En Tiempo Real del flujo de Agua'],
    datasets: [{
      label: 'Consumo En Tiempo Real del flujo de Agua',
      data: [0],
      backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)'
      ],
      borderColor: [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)'
      ],
      borderWidth: 1
    }]
  },
  options: {
    maintainAspectRatio: true,
    aspectRatio: 3,
    scales: {
      y: {
        beginAtZero: true
      }
    }
    }

});
function actualizarDatos() {
  fetch('https://backend.thinger.io/v3/users/IsaiMadrigal/devices/ESP32/resources/datos', {
    method: 'GET',
    headers: authHeader
  })
  .then(response => response.json())
  .then(data => {
    
    const potencia = [data['Potencia']];
    grafica.data.datasets[0].data[0] = potencia;
    grafica.update();
    // console.log(data);
  })
  .catch(error => {
    console.error(error);
  });
}

actualizarDatos(); // Llamamos a la función para que actualice los datos la primera vez

setInterval(actualizarDatos, 1000); // Llamamos a la función cada 1 segundo para actualizar los datos de la gráfica

</script>

<?php include("template/pie.php"); ?>