<?php
// Conectar a la base de datos MySQL usando XAMPP
$servername = "localhost";  
$username = "root";  
$password = "";  
$dbname = "pacientes_db";  // Cambia por el nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para manejar la carga de archivos
function uploadFile($file, $directory) {
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx'];
    $fileType = pathinfo($file['name'], PATHINFO_EXTENSION);

    // Verificar si el tipo de archivo es permitido
    if (in_array(strtolower($fileType), $allowedTypes)) {
        $fileName = uniqid() . '.' . $fileType; // Generar un nombre único
        $targetFilePath = $directory . $fileName;

        // Mover el archivo subido al directorio
        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            return $fileName; // Retornar el nombre del archivo subido
        } else {
            return false; // Retornar falso si la carga falla
        }
    } else {
        return false; // Retornar falso si el tipo de archivo no es permitido
    }
}

// Añadir paciente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_patient'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $documento_id = $_POST['documento_id'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];

    // Verificar si el documento_id ya existe
    $checkSql = "SELECT * FROM Pacientes WHERE documento_id = '$documento_id'";
    $result = $conn->query($checkSql);

    if ($result->num_rows > 0) {
        echo "Error: El documento ID '$documento_id' ya está en uso. Por favor, utiliza uno diferente.";
    } else {
        // Cargar archivo (si existe)
        $uploadedFile = null;
        if (isset($_FILES['patient_file']) && $_FILES['patient_file']['error'] == 0) {
            $uploadedFile = uploadFile($_FILES['patient_file'], 'uploads/pacientes/');
        }

        // Insertar el paciente, incluyendo el archivo
        $sql = "INSERT INTO Pacientes (nombre, apellido, documento_id, fecha_nacimiento, telefono, direccion, correo, archivo)
                VALUES ('$nombre', '$apellido', '$documento_id', '$fecha_nacimiento', '$telefono', '$direccion', '$correo', '$uploadedFile')";

        if ($conn->query($sql) === TRUE) {
            echo "Paciente añadido con éxito";
            if ($uploadedFile) {
                echo " | Archivo subido: <a href='uploads/pacientes/$uploadedFile' target='_blank'>$uploadedFile</a>";
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Eliminar paciente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_patient'])) {
    $paciente_id = $_POST['paciente_id'];

    $sql = "DELETE FROM Pacientes WHERE paciente_id = $paciente_id";

    if ($conn->query($sql) === TRUE) {
        echo "Paciente eliminado con éxito";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Función para listar archivos subidos
function listUploadedFiles($tableName) {
    global $conn;
    $sql = "SELECT * FROM $tableName";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h3>Archivos Subidos en $tableName:</h3><ul>";
        while ($row = $result->fetch_assoc()) {
            $fileName = isset($row['archivo']) ? $row['archivo'] : null; // Manejar el caso si no existe la columna
            if (!empty($fileName)) {
                echo "<li><a href='uploads/" . strtolower($tableName) . "/" . $fileName . "' target='_blank'>" . $fileName . "</a></li>";
            }
        }
        echo "</ul>";
    } else {
        echo "<h3>No hay archivos subidos en $tableName.</h3>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Pacientes y Centros Médicos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }
        h2 {
            color: red;
        }
        form {
            background-color: white;
            padding: 20px;
            margin: 20px auto;
            border-radius: 8px;
            max-width: 400px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type="text"], input[type="number"], input[type="date"], input[type="email"], input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 2px solid red;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: red;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>

    <h2>Añadir Paciente</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        Nombre: <input type="text" name="nombre" required><br>
        Apellido: <input type="text" name="apellido" required><br>
        Documento ID: <input type="text" name="documento_id" required><br>
        Fecha de Nacimiento: <input type="date" name="fecha_nacimiento" required><br>
        Teléfono: <input type="text" name="telefono"><br>
        Dirección: <input type="text" name="direccion"><br>
        Correo: <input type="email" name="correo"><br>
        Cargar archivo: <input type="file" name="patient_file"><br>
        <button type="submit" name="add_patient">Añadir Paciente</button>
    </form>

    <h2>Eliminar Paciente</h2>
    <form method="POST" action="">
        ID del Paciente: <input type="number" name="paciente_id" required><br>
        <button type="submit" name="delete_patient">Eliminar Paciente</button>
    </form>

    <!-- Mostrar archivos subidos -->
    <?php
    listUploadedFiles('Pacientes');
    ?>

</body>
</html>
