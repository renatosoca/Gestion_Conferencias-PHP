<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo ?></h2>
    <p class="auth__texto">Inicia sesión en Dev Web Camp</p>

    <?php include_once __DIR__.'/../templates/alertas.php'; ?>

    <form action="/login" class="formulario" method="post">
        <div class="formulario__campo">
            <label for="email" class="formulario__label">Email</label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                class="formulario__input"
                placeholder="Tu Email">
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

        <input type="submit" value="Ingresar" class="formulario__submit">
    </form>

    <div class="acciones">
        <a href="/registro" class="acciones__links">Aùn no tienes Cuenta? Crea una</a>
        <a href="/olvide" class="acciones__links">Olvidaste tu password?</a>
    </div>
</main>