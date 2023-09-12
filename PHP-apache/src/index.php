<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Equipo 9</title>
</head>
<body>
    <h1>Formulario</h1>

    <?php
    $selectedClave = null;
    $selectedNombre = "";
    $selectedDireccion = "";
    $selectedTelefono = "";

    //direccion ip del contenedor de postgres
    $ip = "pgsql:host=172.17.0.2;port=5432;dbname=mydb;";

    // Obtener datos
    if (isset($_GET['empleado_clave'])) {
        try {
			$dsn = $ip;
    		$username = "postgres";
    		$password = "postgres";
			$pdo = new PDO($dsn, $username, $password);
            $selectedId = $_GET['empleado_clave'];
            // Obtener datos del empleado
            $sql = "SELECT nombre, direccion, telefono FROM empleado WHERE clave = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$selectedId]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //guardar datos del empleado dentro de variables
            $selectedNombre = $row['nombre'];
            $selectedDireccion = $row['direccion'];
            $selectedTelefono = $row['telefono'];

            $pdo = null;
        } catch (PDOException $e) {
            die('Error en la conexión a la base de datos: ' . $e->getMessage());
        }

    }

    // Guardar datos
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
			$dsn = $ip;
    		$username = "postgres";
    		$password = "postgres";
			$pdo = new PDO($dsn, $username, $password);

            $clave = $_POST['clave'];
            if (!datoExistente($pdo, $clave)) {
                $nombre = $_POST['nombre'];
                $direccion = $_POST['direccion'];
                $telefono = $_POST['telefono'];

                // Actualizar datos del empleado
                $sql = "INSERT INTO empleado (clave, nombre, direccion, telefono) VALUES (?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$clave, $nombre, $direccion, $telefono]);
                echo "Datos guardados correctamente";
            } else {
                $selectedId = $clave;

                $sql = "SELECT nombre, direccion, telefono FROM empleado WHERE clave = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$selectedId]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $nombre = $_POST['nombre'];
                $direccion = $_POST['direccion'];
                $telefono = $_POST['telefono'];

                $sql = "UPDATE empleado SET nombre = ?, direccion = ?, telefono = ? WHERE clave = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$nombre, $direccion, $telefono, $selectedId]);
                echo "Datos actualizados correctamente";
            }

            $pdo = null;
        } catch (PDOException $e) {
            die('Error en la conexión a la base de datos: ' . $e->getMessage());
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteId'])) {
        try {
            $dsn = $ip;
            $username = "postgres";
            $password = "postgres";
            $pdo = new PDO($dsn, $username, $password);

            $deleteId = $_POST['deleteId'];

            $sql = "DELETE FROM empleado WHERE clave = ?";
            $stmt = $pdo->prepare($sql);

            if ($stmt->execute([$deleteId])) {
                echo "Registro eliminado correctamente.";
            } else {
                echo "Error al eliminar el registro.";
            }

        $pdo = null;
    } catch (PDOException $e) {
        die('Error en la conexión a la base de datos: ' . $e->getMessage());
    }
}

// Limpiar selección
    function limpiarSeleccion() {
        global $selectedId, $selectedNombre, $selectedDireccion, $selectedTelefono;
        $selectedId = "";
        $selectedNombre = "";
        $selectedDireccion = "";
        $selectedTelefono = "";
    }

    function datoExistente($pdo, $clave) {
        $sql = "SELECT clave FROM empleado WHERE clave = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$clave]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // Si existe el dato, regresa true
        return $row['clave'] == $clave;
    }

    function deshabilitarInput() {
        echo '<script>';
            echo 'document.getElementById("clave").disabled = false;';
            echo 'document.getElementById("nombre").disabled = false;';
            echo 'document.getElementById("direccion").disabled = false;';
            echo 'document.getElementById("telefono").disabled = false;';
        echo '</script>';
    }

    ?>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label for="clave">Clave:</label>
        <input type="text" name="clave" id="clave" value="<?php echo $selectedId; ?>" required><br><br>

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo $selectedNombre; ?>" required><br><br>

        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" id="direccion" value="<?php echo $selectedDireccion; ?>" required><br><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" id="telefono" value="<?php echo $selectedTelefono; ?>" <?php echo "disable"?> required><br><br>

        <input type="submit" value="Guardar">
        <input type="button" value="Limpiar Selección" onclick="limpiarSeleccion()">
    </form>
    
    <h2>Datos Guardados</h2>
    <table border="1">
        <tr>
            <th>Clave</th>
            <th>Nombre</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>
        <?php
            


        try {
			$dsn = $ip;
    		$username = "postgres";
    		$password = "postgres";
			$pdo = new PDO($dsn, $username, $password);

            $sql = "SELECT clave, nombre, direccion, telefono FROM empleado";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td><a href=\"{$_SERVER['PHP_SELF']}?empleado_clave={$row['clave']}\">{$row['clave']}</a></td>";                
                echo "<td>" . $row['nombre'] . "</td>";
                echo "<td>" . $row['direccion'] . "</td>";
                echo "<td>" . $row['telefono'] . "</td>";
                echo "<td>";
                echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\">";
                echo "<input type=\"hidden\" name=\"deleteId\" value=\"" . $row['clave'] . "\">";
                echo "<input type=\"button\" value=\"Eliminar\" onclick=\"confirmarEliminacion(" . $row['clave'] . ")\">";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }

            $pdo = null;
        } catch (PDOException $e) {
            die('Error en la conexión a la base de datos: ' . $e->getMessage());
        }
        ?>
    </table>
</body>
<script>
        function limpiarSeleccion() {
            window.location.href = "<?php echo $_SERVER['PHP_SELF']; ?>";
        }
        function confirmarEliminacion(id) {
            var confirmacion = confirm("¿Seguro que deseas eliminar el registro con ID " + id + "?");
            
            if (confirmacion) {
                var form = document.querySelector("form input[name=deleteId][value='" + id + "']").form;
                form.submit();
            }
        }

        function mostrarDatos(clave) {
        // Obtener los datos del empleado y mostrarlos en los campos del formulario
        var idInput = document.getElementById("clave");
        var nombreInput = document.getElementById("Nombre");
        var direccionInput = document.getElementById("direccion");
        var telefonoInput = document.getElementById("telefono");

        idInput.value = clave; // Establecer el ID en el campo ID (oculto)

        }
</script>
<script>
    <?php
        if (isset($_GET['empleado_clave'])) {
            deshabilitarInput();
        }
    ?>
</script>
</html>