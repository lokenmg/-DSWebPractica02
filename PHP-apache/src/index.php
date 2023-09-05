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
				<input required name="telefono" type="numer" id="telefono" placeholder="Telefono" class="form-control">
			</div>
			<button type="submit" class="btn btn-success">Agregar</button>
		</form>
	</div>
</div>

</body>
</html>