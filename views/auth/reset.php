<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>
    <p class="auth__texto">Coloca tu nuevo password</p>

    <?php include_once __DIR__.'/../templates/alertas.php'; ?>
    <?php if($token_valido) { ?>
    <form class="formulario" method="POST">
        <div class="formulario__campo">
            <label for="password" class="formulario__label">Nuevo Password</label>
            <input 
                type="password"
                name="password"
                id="password"
                class="formulario__input"
                placeholder="Tu Password">
        </div>

        <input type="submit" value="Enviar instrucciones" class="formulario__submit">
    </form>

    <?php } ?>

    <div class="acciones">
        <a href="/login" class="acciones__links">Ya tienes una cuenta? Inicia Sesión</a>
        <a href="/registro" class="acciones__links">Aùn no tienes Cuenta? Crea una</a>
    </div>
</main>