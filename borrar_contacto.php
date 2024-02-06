<?php include("includes/header.php") ?>
<?php
    //validar si recibimos el id de la categoria
    if (isset($_GET['id'])) {
        $idContacto = $_GET['id'];
    }

    //obtener la categoria actual
    $query = "SELECT * FROM contactos WHERE id = :id";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(":id",$idContacto,PDO::PARAM_INT);
    $stmt->execute();

    $contacto = $stmt->fetch(PDO::FETCH_OBJ);

    //validar si recibimos el id de la categoria
    if (isset($_GET['idCategoria'])) {
        $idCategoria = $_GET['idCategoria'];
    }

    //obtener la categoria actual
    $query = "SELECT * FROM categorias";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $categorias = $stmt->fetchAll(PDO::FETCH_OBJ);

    //editar los datos
if (isset($_POST['borrarContacto'])) {

    //Validamos si esta vacio
        //Si entra por aqui es porque se puede ingresar el nuevo registro
        $query = "DELETE FROM contactos WHERE id =:id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":id",$idContacto,PDO::PARAM_INT);
        

        $resultado = $stmt->execute();

        if ($resultado) {
            $mensaje = "El Contacto fue borrado correctamente";
            header('Location: contactos.php?mensaje=' . urlencode($mensaje));
            exit();
        }else{
            $error = "Error, no se pudo borrar el registro";
            header('Location: borrar_contacto.php?error=' . urlencode($error));
            exit();
        }

    
    
    
    
}




?>



<div class="row">
        <div class="col-sm-6">
            <h3>Borrar Contacto</h3>
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
                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingresa el nombre"
                value="<?php if(isset($contacto)&&!empty($contacto->nombre)) echo $contacto->nombre; ?>" readonly>               
            </div>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos:</label>
                <input type="text" class="form-control" name="apellido" id="apellidos" placeholder="Ingresa los apellidos"
                value="<?php if(isset($contacto)&&!empty($contacto->apellido)) echo $contacto->apellido; ?>"readonly>               
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono:</label>
                <input type="number" class="form-control" name="telefono" id="telefono" placeholder="Ingresa el teléfono"
                value="<?php if(isset($contacto)&&!empty($contacto->telefono)) echo $contacto->telefono; ?>"readonly>               
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Ingresa el email"
                value="<?php if(isset($contacto)&&!empty($contacto->email)) echo $contacto->email;?>" readonly>               
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Categoría:</label>
                <select class="form-select" aria-label="Default select example" name="categoria" disabled>
                    <option value="">--Selecciona una Categoría--</option>
                    <?php foreach($categorias as $fila) : ?>
                        <option value="<?php  echo  $fila->id;  ?>" <?php  if(isset($idCategoria)&&$idCategoria == $fila->id) echo "selected" ?>  ><?php  echo  $fila->nombre;  ?></option>
                    <?php endforeach ?>               
                </select>
            </div>
            <br />
            <button type="submit" name="borrarContacto" class="btn btn-primary w-100"><i class="bi bi-person-bounding-box"></i> Borrar Contacto</button>
            </form>
        </div>
    </div>
<?php include("includes/footer.php") ?>
       