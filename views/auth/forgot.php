<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>
    <p class="auth__texto">Inicia sesión en Dev Web Camp</p>

    <form action="/login" class="formulario">
        <div class="formulario__campo">
            <label for="email" class="formulario__label">Email</label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                class="formulario__input"
                placeholder="Tu Email">
        </div>

        <input type="submit" value="Enviar instrucciones" class="formulario__submit">
    </form>

    <div class="acciones">
        <a href="/login" class="acciones__links">Ya tienes una cuenta? Inicia Sesión</a>
        <a href="/registro" class="acciones__links">Aùn no tienes Cuenta? Crea una</a>
    </div>
</main>