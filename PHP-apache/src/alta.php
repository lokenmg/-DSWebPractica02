<?php
try {
    $dsn = "pgsql:host=172.17.0.2;port=5432;dbname=mydb;";
    $username = "postgres";
    $password = "postgres";

    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "INSERT INTO empleado(clave, nombre, direccion, telefeno)
              VALUES(:clave, :nombre, :direccion, :telefeno)";

    $statement = $pdo->prepare($query);

    $parameters = [
        ':clave' => $_REQUEST['clave'],
        ':nombre' => $_REQUEST['nombre'],
        ':direccion' => $_REQUEST['direccion'],
        ':telefeno' => $_REQUEST['telefono']
    ];

    $result = $statement->execute($parameters);

    if ($result) {
        echo "Se registró el empleado.";
    } else {
        echo "Error en la consulta.";
    }

    // Cerrar la conexión PDO
    $pdo = null;
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>

