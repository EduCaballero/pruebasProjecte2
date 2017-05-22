<div id="login-modal" class="modal">
    <div class="modal-container" tabindex="-1">
        <div class="modal-content">
            <div class="modal-header">
                <h3 style="text-align: center;">Inicia sesión en ConcertPush</h3>
                <button type="button" class="fa fa-lg fa-close btn-close close-modal"></button>	
            </div>
            <div class="modal-body">
                <form id="login-form" action="process-login.php" method="post">
                    <input type="email" name="email" placeholder="Email" maxlength="80">
                    <input type="password" name="password" placeholder="Contraseña" maxlength="32">
                    <div style="display: block;">
                        <input type="checkbox" name="remember">
                        <span>Recordar mis datos</span>
                        <a href="">¿Olvidaste tu contraseña?</a>
                    </div>
                    <input type="submit" class="btn-submit" name="login" value="Iniciar sesión">
                </form>
            </div>
            <div style="text-align: center;" class="modal-footer">
                ¿Nuevo en ConcertPush? <a href="signup.php">Regístrate »</a>
            </div>
        </div>
    </div>
</div>