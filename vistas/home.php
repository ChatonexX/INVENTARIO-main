<!--<div class="container is-fluid">
	<h1 class="title">Hola</h1>
	<h2 class="subtitle">¡Bienvenido <?php echo $_SESSION['nombre']." ".$_SESSION['apellido']; ?>!</h2>
</div>-->

<div class="card">
  <div class="card-content">
    <div class="media">
      <div class="media-left">
        <figure class="image is-48x48">
          <img src="./img/perfil.webp" alt="Placeholder image">
        </figure>
      </div>
      <div class="media-content">
	  <h1 class="title">Hola</h1>
	<h2 class="subtitle">¡Bienvenido <?php echo $_SESSION['nombre']." ".$_SESSION['apellido']; ?>!</h2>
      </div>
    </div>
  </div>
</div> <br>

<hr>

<?php

include "departures_list.php";

?>