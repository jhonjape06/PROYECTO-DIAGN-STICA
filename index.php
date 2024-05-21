<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/estilos_index.css">
    <script src="js/script1.js"></script>
</head>
<body>
    <div class="container">
       <div class="form-box">
            <div class="logo">
                  <img src="images/logo.jpg" alt="logo">
            </div>
            <div class="img_inicio">
                <img src="images/inicio_ses.png" alt="img_inicio">
            </div>
            <form action="validar.php" method="post" id="formLogin" class="group-inicio">
                    <div class="clasea">
                        <label for="user" class="user"><p>Usuario:</p></label>
                        <input class="controls1" id="user" type="text" name="mail" value="" placeholder="Usuario" required>
                    </div>
                    <div class="claseb">
                        <label class="pass"><p>Contraseña:</p></label>
                        <input class="controls2" type="password" name="pass" value="" placeholder="Contraseña" required>
                    </div>
                    <div class="recordar">¿Olvido su contraseña?</div>
                <input type="checkbox" class="checkbox_most_ctr"><span>Mostrar Contraseña</span><br>
                <input type="checkbox" class="checkbox_rec_dat"><span>Recordar mis Datos</span>
                <button type="submit" class="btn_inc_ses">Iniciar sesion</button>
            </form>
        </div>
    </div>
</body>
</html>

