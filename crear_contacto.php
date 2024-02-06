<?php include("includes/header.php") ?>
<?php
    //obtener las categorias para el dropdown
    $query = "SELECT * FROM categorias";
    $stmt = $conn->prepare($query);

    $stmt->execute();

    $categorias = $stmt->fetchAll(PDO::FETCH_OBJ);

//insertar los datos
if (isset($_POST['crearContacto'])) {
    //Obtener los valores
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];
    $categoria = $_POST["categoria"];

    //Validamos si esta vacio
    if (empty($nombre) || empty($apellido) ||
        empty($telefono) || empty($email) ||
        empty($categoria)) {
        $error = "Algunos campos obligatorios estan vacios";
        header('Location: crear_contacto.php?error=' . urlencode($error));
    }else{

        //Si entra por aqui es porque se puede ingresar el nuevo registro
        $query = "INSERT INTO contactos(nombre, apellido, telefono, email, categoria)VALUES(:nombre, :apellido, :telefono, :email, :categoria)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":nombre",$nombre,PDO::PARAM_STR);
        $stmt->bindParam(":apellido",$apellido,PDO::PARAM_STR);
        $stmt->bindParam(":telefono",$telefono,PDO::PARAM_STR);
        $stmt->bindParam(":email",$email,PDO::PARAM_STR);
        $stmt->bindParam(":categoria",$categoria,PDO::PARAM_STR);
        

        $resultado = $stmt->execute();

        if ($resultado) {
            $mensaje = "El Contacto fue creado correctamente";
            header('Location: contactos.php?mensaje=' . urlencode($mensaje));
            exit();
        }else{
            $error = "Error, no se pudo crear el registro";
            header('Location: crear_contactos.php?error=' . urlencode($error));
            exit();
        }

    
    
    
    }
}

?>

    <div class="row">
        <div class="col-sm-6">
            <h3>Crear un Nuevo Contacto</h3>
        </div>            
    </div>
    <div class="row">
    <div class="col-sm-12">
        <?php if(isset($_GET["error"])):  ?>
        <div class="alert alert-danger  alert-dismissible fade show" role="alert">
            <strong><?php echo $_GET["error"]  ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
    </div>   
</div>
    <div class="row">
        <div class="col-sm-6 offset-3">
        <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingresa el nombre" required>               
            </div>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos:</label>
                <input type="text" class="form-control" name="apellido" id="apellidos" placeholder="Ingresa los apellidos" required>               
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono:</label>
                <input type="number" class="form-control" name="telefono" id="telefono" placeholder="Ingresa el teléfono" required>               
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Ingresa el email" required>               
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Categoría:</label>
                <select class="form-select" aria-label="Default select example" name="categoria" required>
                    <option value="">--Selecciona una Categoría--</option>
                    <?php foreach($categorias as $fila) : ?>  
                        <option value="<?php  echo  $fila->id;  ?>"><?php  echo  $fila->nombre;  ?></option>
                        
                    <?php endforeach ?>          
                </select>
            </div>
            <br />
            <button type="submit" name="crearContacto" class="btn btn-primary w-100"><i class="bi bi-person-bounding-box"></i> Crear Nuevo Contacto</button>
            </form>
        </div>
    </div>
<?php include("includes/footer.php") ?>
       