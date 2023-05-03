<?php include("template/cabecera.php"); ?>
<!-- Tabla donde se mostrarán los datos -->
<table>
  <thead>
    <tr>
      <th>Fecha y hora</th>
      <th>Consumo</th>
    </tr>
  </thead>
  <tbody id="tabla-datos">
  </tbody>
</table>

<script>
// Autenticación mediante clave API
const apiKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJkZXYiOiJFU1AzMiIsImlhdCI6MTY4MjQ2MzUyMSwianRpIjoiNjQ0ODViMjFkNzQ5ZjYyZDk3MGY2NWRmIiwic3ZyIjoidXMtZWFzdC5hd3MudGhpbmdlci5pbyIsInVzciI6IklzYWlNYWRyaWdhbCJ9.r6RjLww9L7mVDC0UgiatlLabyjZoXgtY8P9TURtdl3g';
const authHeader = {'Authorization': 'Bearer ' + apiKey};

// Variable para almacenar el último valor
let ultimoValor = 0;

// Función para actualizar los datos y mostrarlos en la tabla
function actualizarDatos() {
  fetch('https://backend.thinger.io/v3/users/IsaiMadrigal/devices/ESP32/resources/datos', {
    method: 'GET',
    headers: authHeader
  })
  .then(response => response.json())
  .then(data => {
    // Obtenemos el nuevo valor y lo almacenamos en la variable
    const nuevoValor = [data['Consumo En Tiempo Real']];
    ultimoValor = nuevoValor;
  
    // Actualizamos la tabla con el nuevo y último valor
    const tabla = document.getElementById('tabla-datos');
    const fila = document.createElement('tr');
    const celdaFecha = document.createElement('td');
    const celdaConsumo = document.createElement('td');
    const fechaActual = new Date().toLocaleString();
  
    celdaFecha.innerText = fechaActual;
    celdaConsumo.innerText = nuevoValor.toFixed(2) + ' litros';
  
    fila.appendChild(celdaFecha);
    fila.appendChild(celdaConsumo);
    tabla.insertBefore(fila, tabla.firstChild);
  })
  .catch(error => {
    console.error(error);
  });
}

actualizarDatos(); // Llamamos a la función para que actualice los datos la primera vez

setInterval(actualizarDatos, 1000); // Llamamos a la función cada 1 segundo para actualizar los datos de la tabla
</script>

<?php include("template/pie.php"); ?>