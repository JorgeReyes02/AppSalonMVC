<h1 class="nombre-pagina">Crear Nueva Cita</h1>
<p class="descripcion-pagina">Elige tus servicios y coloca tus datos</p>

<div class="app">
    <nav class="tabs">
        <button type="button" class="actual" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">información Cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>
    <div id="paso-1" class="seccion">
            <h2>Servicios</h2>
            <p class="text-center">Elige tus servicios a continuación</p>

            <div id="servicios" class="listado-servicios"></div>
    </div>

    <div id="paso-2" class="seccion">
            <h2>Tus Datos y Cita</h2>
            <p class="text-center">Coloca tus datos y fecha de tu cita</p>

            <form class="formulario">
                <div class="campo">
                    <label for="nombre">Nombre:</label>
                    <input type="text" 
                    placeholder="Tu Nombre" 
                    id="nombre"
                    value="<?php echo $nombre;?>"
                    disabled
                    >
                </div>
                
                <div class="campo">
                    <label for="fecha">Fecha:</label>
                    <input type="date" 
                    id="fecha"
                    min="<?php echo date('Y-m-d',strtotime('+1 day'));?>" 
                    >
                </div>
                 
                <div class="campo">
                    <label for="hora">Hora:</label>
                    <input type="time" 
                    id="hora"
                    >
                </div>
            </form>
    </div>

    <div id="paso-3" class="seccion contenido-resumen">
            <h2>Resumen</h2>
            <p class="text-center">verifica que la información sea correcta</p>
    </div>

    <div class="paginacion">
        <button class="boton" id="anterior">&laquo; Anterior</button>
        <button class="boton" id="siguiente">Siguiente &raquo;</button>
    </div>
</div>

 <?php $script = "
    <script src='build/js/app.js'></script>
 ";

?> 