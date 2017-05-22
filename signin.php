<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Iniciar sesión</title>
        <link rel="stylesheet" href="css/signin-signup.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto" rel="stylesheet">
    </head>
    <body>
        <header>
            <div id="topbar">
                <div class="logo">
                    <a href="index.php" title="ConcertPush" class="logo-link">ConcertPush</a>
                </div>
            </div>
        </header>
        <div id="signin-signup-container">
            <form action="" method="post">
                <div class="signin-signup-form">
                    <h1>Iniciar sesión</h1>
                    <input type="email" name="email" placeholder="Email" maxlength="80" required>
                    <input type="password" name="password" placeholder="Contraseña" maxlength="32" required>
                    <small>
                        <input type="checkbox" name="remember" value="1">
                        <span>Recordar mis datos</span>
                        <a href="" id="forgot">¿Olvidaste tu contraseña?</a>
                    </small>
                </div>
                <input type="submit" class="btn btn-submit" name="entrar" value="Iniciar sesión">
                <div id="subtext-box">
                    <small>
                        ¿Nuevo en ConcertPush? <a href="signup.php">Regístrate »</a>
                    </small>
                </div>
            </form>
        </div>
    </body>
</html>