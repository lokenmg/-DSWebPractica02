<html>
<div class="row">
	<div class="col-12">
		<h1>Agregar</h1>
		<form action="alta.php" method="POST">

            <div class="form-group">
				<label for="clave">Clave: </label>
				<input required name="clave" type="numer" id="clave" placeholder="Clave" class="form-control">
			</div>

			<div class="form-group">
				<label for="nombre">Nombre: </label>
				<input required name="nombre" type="text" id="nombre" placeholder="Nombre" class="form-control">
			</div>
			<div class="form-group">
				<label for="direccion">Dirección: </label>
				<input required name="direccion" type="text" id="direccion" placeholder="Direccion" class="form-control">
			</div>

            <div class="form-group">
				<label for="telefono">Telefono: </label>
				<input required name="telefono" type="number" id="telefono" placeholder="Telefono" class="form-control">
			</div>
			<button type="submit" class="btn btn-success">Agregar</button>
		</form>
	</div>
</div>

<div>
<?php
try {
    $dsn = "pgsql:host=172.17.0.2;port=5432;dbname=mydb;";
    $username = "postgres";
    $password = "postgres";

    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Cerrar la conexión PDO
    
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}

try {
    $sql = "SELECT * FROM empleado";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Direccion</th><th>telefono</th></tr>";
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row["clave"] . "</td>";
            echo "<td>" . $row["nombre"] . "</td>";
            echo "<td>" . $row["direccion"] . "</td>";
			echo "<td>" . $row["telefono"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron resultados";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Cerrar la conexión a la base de datos
$conn = null;
?>
</div>

</body>
</html>