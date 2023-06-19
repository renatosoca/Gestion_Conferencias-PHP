<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo ?></h2>
    <p class="auth__texto">Registrate en DevWebCamp</p>

    <?php 
        include_once __DIR__.'/../templates/alertas.php'; 

        if (isset($alertas['exito'])) {
    ?>
            <div class="acciones">
                <a href="/login" class="acciones__links">Inicia Sesión</a>
            </div>
    <?php
        }
    ?>
</main>