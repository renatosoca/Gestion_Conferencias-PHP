<header class="header">
    <div class="header__contenedor">
        <nav class="header__nav">
            <?php if(is_auth()) { ?>
                <a href="<?php echo is_admin() ? '/admin/dashboard' : '/finalizar-registro'; ?>" class="header__link">Administrar</a>
                <form method="POST" action="/logout" class="header__form">
                    <input type="submit" value="Cerrar Sesión" class="header__submit">
                </form>
            <?php } else { ?>
                <a href="/registro" class="header__link">Registro</a>
                <a href="/login" class="header__link">Iniciar Sesión</a>
            <?php } ?>
        </nav>

        <div class="header__contenido">
            <a href="/">
                <h1 class="header__logo">
                    &#60;DevWebCamp/>
                </h1>
            </a>

            <p class="header__texto">Octubre 5-6 - 2023</p>
            <p class="header__texto header__texto--modalidad">En línea - Presencial</p>

            <a href="/registro" class="header__boton">Comprar pase</a>
        </div>
    </div>
</header>

<div class="barra">
    <div class="barra__contenido">
        <a href="/">
            <h2 class="barra__logo">&#60;DevWebCamp/></h2>
        </a>

        <nav class="nav">
            <a href="/eventos" class="nav__link <?php echo pagina_actual('/eventos')? 'activo': ''; ?>">Evento</a>
            <a href="/paquetes" class="nav__link <?php echo pagina_actual('/paquetes')? 'activo': ''; ?>">Paquetes</a>
            <a href="/conferencias" class="nav__link <?php echo pagina_actual('/conferencias')? 'activo': ''; ?>">Workshops / Conferencias</a>
            <a href="/registro" class="nav__link <?php echo pagina_actual('/registro')? 'activo': ''; ?>">Comprar Pase</a>
        </nav>
    </div>
</div>