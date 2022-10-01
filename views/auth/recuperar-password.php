<h1 class="nombre-pagina">Recuperar Password</h1>
<h1 class="descripcion-pagina">Digita tu nuevo password acontinuación</h1>

<?php include_once __DIR__ . '/../templates/alertas.php';?>   <!--incluir template de alertas-->

<?php if($error) return;?>                          <!--temina las sentencias de codigo en el html o vista-->

<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Password</label>
        <input 
            type="password"
            id="password"
            name="password"
            placeholder="Tu Nuevo Password"
        >
    </div>
    <input type="submit" class="boton" value="Guardar Nuevo Password">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/crear-cuenta">¿Aún no tienes una cuenta?</a>
</div>