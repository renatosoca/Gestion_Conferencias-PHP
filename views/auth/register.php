<main class="auth">
    <h2 class="auth__heading">Crea tu Cuenta en DevWebCamp</h2>
    <p class="auth__texto">Registrate en DevWebCamp</p>

    <form action="/login" class="formulario">
    <div class="formulario__campo">
            <label for="nombre" class="formulario__label">Nombre</label>
            <input 
                type="text"
                name="nombre" 
                id="nombre" 
                class="formulario__input"
                placeholder="Tu Nombre">
        </div>
        
        <div class="formulario__campo">
            <label for="apellido" class="formulario__label">Apellido</label>
            <input 
                type="text" 
                name="apellido" 
                id="apellido" 
                class="formulario__input"
                placeholder="Tu Apellido">
        </div>

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