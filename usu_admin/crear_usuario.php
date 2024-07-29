<?php
    // Inicio de la sesión PHP
    session_start();
    // Redirección si no hay usuario autenticado
    if (!isset($_SESSION['user'])) {
        header("Location: ../index.php");
        exit(); // Finaliza el script para evitar ejecución adicional
    }
// Conectar a la base de datos
require("../connect_db.php");

    // Obtener las sedes
$sql_sedes = "SELECT id, nombre_sede FROM sedes";
$result_sedes = $mysqli->query($sql_sedes);
$sedes = [];
if ($result_sedes->num_rows > 0) {
    while ($row_sede = $result_sedes->fetch_assoc()) {
        $sedes[] = $row_sede;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROYECTO DIAGNOSTICA</title>
    <link rel="stylesheet" href="../css/estilos_crear_usuario.css">
</head>
<body>
    <div class="container">
        <!-- Navbar -->
        <nav class="navbar">
            <img class="logo-adm" src="../images/logo-adm.png" alt="logo">
            <ul class="nav pull-right">
                <li>
                    <form method="post" action="../desconectar.php">
                        <button type="submit" class="cerrar_sesion">CERRAR SESIÓN</button>
                    </form>
                </li>
                <nav>
                    <li class="Usuario">USUARIO: <strong><?php echo htmlspecialchars($_SESSION['user'], ENT_QUOTES, 'UTF-8'); ?></strong></li>
                    <li class="rol">ROL: <strong><?php echo htmlspecialchars($_SESSION['rol'], ENT_QUOTES, 'UTF-8'); ?></strong></li>
                </nav>
            </ul>
        </nav>
        <!-- Fin Navbar -->

        <!-- Cuerpo del documento -->
        <div class="row-crear-usu">
            <form method="post" action="admin.php">
                <button type="submit" class="btn_atras"><= ATRAS</button>
            </form> 
            <div class="row-fluid">
                <!-- Formulario de registro -->
                <form method="post" action="registro.php" onsubmit="return validarFormulario()">
                    <fieldset>
                        <legend style="font-size: 18pt"><b>REGISTRO</b></legend>
                        <div class="form-group">
                            <label><b>INGRESA EL NOMBRE</b></label>
                            <input type="text" name="realname" class="form-control" placeholder="Nombre completo" />
                        </div>
                        <div class="form-group">
                            <label><b>INGRESA EL CORREO</b></label>
                            <input type="text" name="nick" class="form-control" required placeholder="Correo electrónico"/>
                        </div>
                        <div class="form-group">
                            <label><b>INGRESA LA CONTRASEÑA</b></label>
                            <input type="password" name="pass" class="form-control" placeholder="Contraseña" />
                        </div>
                        <div class="form-group">
                            <label><b>REPITE LA CONTRASEÑA</b></label>
                            <input type="password" name="rpass" class="form-control" required placeholder="Repite contraseña" />
                        </div>
                        <div class="form-group">
                            <label><b>INGRESE EL ROL</b></label>
                            <select type="text" name="rol" class="form-control" required>
                                <option value="">Seleccionar rol</option>
                                <option value="administrador">Administrador</option>
                                <option value="logistica">Logística</option>
                                <option value="sede">Sedes</option>
                                <!-- Añadir más opciones según los roles disponibles -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label><b>SEDE</b></label>
                            <select id="nombre_sede" name="nombre_sede" class="form-control" required>
                                <option value="">Selecciona una sede</option>
                                <option value="">NO APLICA</option>
                                <?php foreach ($sedes as $sede): ?>
                                    <option value="<?php echo $sede['id']; ?>"><?php echo $sede['nombre_sede']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <input class="btn btn-danger" type="submit" name="submit" value="CREAR USUARIO"/>
                    </fieldset>
                </form>
                <!-- Fin del formulario de registro -->
            </div>
        </div>
        <!-- Fin Cuerpo del documento -->
    </div>
    <!-- JavaScript al final para mejorar la velocidad de carga -->
    <script src="../bootstrap/js/jquery-1.8.3.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script>
        // Función para validar el formulario de registro
        function validarFormulario() {
            // Obtiene los valores de los campos del formulario
            var realname = document.getElementsByName("realname")[0].value.trim();
            var mail = document.getElementsByName("nick")[0].value.trim();
            var pass = document.getElementsByName("pass")[0].value.trim();
            var rpass = document.getElementsByName("rpass")[0].value.trim();
            var rol = document.getElementsByName("rol")[0].value.trim();

            // Validación de campos vacíos
            if (realname === "" || mail === "" || pass === "" || rpass === "" || rol === "") {
                alert("Por favor, complete todos los campos.");
                return false;
            }

            // Validación de contraseñas coincidentes
            if (pass !== rpass) {
                alert("Las contraseñas no coinciden.");
                return false;
            }

            // Validación de correo electrónico simple
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(mail)) {
                alert("Por favor, ingrese un correo electrónico válido.");
                return false;
            }

            // Si pasa todas las validaciones, devuelve verdadero y se envía el formulario
            return true;
        }
    </script>
</body>
</html>
