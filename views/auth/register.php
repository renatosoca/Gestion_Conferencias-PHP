<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo ?></h2>
    <p class="auth__texto">Registrate en DevWebCamp</p>

    <?php include_once __DIR__.'/../templates/alertas.php'; ?>

    <form action="/registro" class="formulario" method="POST">
    <div class="formulario__campo">
            <label for="nombre" class="formulario__label">Nombre</label>
            <input 
                type="text"
                name="nombre" 
                id="nombre" 
                class="formulario__input"
                placeholder="Tu Nombre"
                value="<?php echo $usuario->nombre ?>">
        </div>
        
        <div class="formulario__campo">
            <label for="apellido" class="formulario__label">Apellido</label>
            <input 
                type="text" 
                name="apellido" 
                id="apellido" 
                class="formulario__input"
                placeholder="Tu Apellido"
                value="<?php echo $usuario->apellido ?>">
        </div>

        <div class="formulario__campo">
            <label for="email" class="formulario__label">Email</label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                class="formulario__input"
                placeholder="Tu Email"
                value="<?php echo $usuario->email ?>">
        </div>
        
        <div class="formulario__campo">
            <label for="password" class="formulario__label">Password</label>
            <input 
                type="password" 
                name="password" 
                id="password" 
                class="formulario__input"
                placeholder="Tu Password">
        </div>

        <div class="formulario__campo">
            <label for="password2" class="formulario__label">Repite Tu Password</label>
            <input 
                type="password" 
                name="password2" 
                id="password2" 
                class="formulario__input"
                placeholder="Repite Tu Password">
        </div>

        <input type="submit" value="Crear Cuenta" class="formulario__submit">
    </form>

    <div class="acciones">
        <a href="/login" class="acciones__links">Ya tienes una cuenta? Inicia Sesión</a>
        <a href="/olvide" class="acciones__links">Olvidaste tu password?</a>
    </div>
</main>