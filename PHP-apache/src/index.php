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
    $selectedTelefeno = "";

    if (isset($_GET['empleado_clave'])) {
        try {
			$dsn = "pgsql:host=172.17.0.3;port=5432;dbname=mydb;";
    		$username = "postgres";
    		$password = "postgres";
			$pdo = new PDO($dsn, $username, $password);
            $selectedId = $_GET['empleado_clave'];

            $sql = "SELECT nombre, direccion, telefeno FROM empleado WHERE clave = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$selectedId]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $selectedNombre = $row['nombre'];
            $selectedDireccion = $row['direccion'];
            $selectedTelefeno = $row['telefeno'];

            $pdo = null;
        } catch (PDOException $e) {
            die('Error en la conexión a la base de datos: ' . $e->getMessage());
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
			$dsn = "pgsql:host=172.17.0.3;port=5432;dbname=mydb;";
    		$username = "postgres";
    		$password = "postgres";
			$pdo = new PDO($dsn, $username, $password);

            $clave = $_POST['clave'];
            $nombre = $_POST['nombre'];
            $direccion = $_POST['direccion'];
            $telefeno = $_POST['telefeno'];

            $sql = "INSERT INTO empleado (clave, nombre, direccion, telefeno) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$clave, $nombre, $direccion, $telefeno]);

            $pdo = null;
        } catch (PDOException $e) {
            die('Error en la conexión a la base de datos: ' . $e->getMessage());
        }
    }

    function limpiarSeleccion() {
        global $selectedId, $selectedNombre, $selectedDireccion, $selectedTelefono;
        $selectedId = "";
        $selectedNombre = "";
        $selectedDireccion = "";
        $selectedTelefeno = "";
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
        <input type="text" name="telefeno" id="telefeno" value="<?php echo $selectedTelefeno; ?>" required><br><br>

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
        </tr>
        <?php
        try {
			$dsn = "pgsql:host=172.17.0.3;port=5432;dbname=mydb;";
    		$username = "postgres";
    		$password = "postgres";
			$pdo = new PDO($dsn, $username, $password);

            $sql = "SELECT clave, nombre, direccion, telefeno FROM empleado";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td><a href=\"{$_SERVER['PHP_SELF']}?empleado_clave={$row['clave']}\">{$row['clave']}</a></td>";
                echo "<td>" . $row['nombre'] . "</td>";
                echo "<td>" . $row['direccion'] . "</td>";
                echo "<td>" . $row['telefeno'] . "</td>";
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
    </script>
</html>