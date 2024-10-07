<?php
// Conectar a la base de datos MySQL usando XAMPP
$servername = "localhost";  
$username = "root";  
$password = "";  
$dbname = "pacientes_db";  

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Funciones para manejar pacientes, médicos, consultorios y citas
function addPatient($data) {
    global $conn;
    $nombre = $data['nombre'];
    $apellido = $data['apellido'];
    $documento_id = $data['documento_id'];
    $fecha_nacimiento = $data['fecha_nacimiento'];
    $telefono = $data['telefono'];
    $direccion = $data['direccion'];
    $correo = $data['correo'];

    // Manejo de archivo
    if (isset($data['archivo']) && $data['archivo']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Crear el directorio si no existe
        }

        $target_file = $target_dir . basename($data['archivo']['name']);
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Comprobar si el archivo es un PDF
        if ($fileType != "pdf") {
            echo "Lo siento, solo se permiten archivos PDF.";
            return;
        }

        // Mover archivo a la carpeta 'uploads'
        if (move_uploaded_file($data['archivo']['tmp_name'], $target_file)) {
            $sql = "INSERT INTO Pacientes (nombre, apellido, documento_id, fecha_nacimiento, telefono, direccion, correo, archivo) VALUES ('$nombre', '$apellido', '$documento_id', '$fecha_nacimiento', '$telefono', '$direccion', '$correo', '$target_file')";
            return $conn->query($sql);
        } else {
            echo "Lo siento, hubo un error al subir su archivo.";
        }
    } else {
        if (isset($data['archivo'])) {
            echo "Error al subir el archivo. Código de error: " . $data['archivo']['error'];
        } else {
            echo "No se ha enviado ningún archivo.";
        }
    }
}

// Manejar formularios enviados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_patient'])) {
        addPatient($_POST + ['archivo' => $_FILES['archivo']]); // Asegúrate de pasar $_FILES['archivo']
    } elseif (isset($_POST['delete_patient'])) {
        $paciente_id = $_POST['paciente_id'];
        $sql = "DELETE FROM Pacientes WHERE paciente_id = $paciente_id";
        $conn->query($sql);
    } elseif (isset($_POST['add_medico'])) {
        addMedico($_POST);
    } elseif (isset($_POST['add_consultorio'])) {
        addConsultorio($_POST);
    } elseif (isset($_POST['add_cita'])) {
        addCita($_POST);
    }
}

function addMedico($data) {
    global $conn;
    $nombre = $data['nombre_medico'];
    $apellido = $data['apellido_medico'];
    $especialidad = $data['especialidad'];
    $telefono = $data['telefono_medico'];
    $correo = $data['correo_medico'];

    $sql = "INSERT INTO Medicos (nombre, apellido, especialidad, telefono, correo) VALUES ('$nombre', '$apellido', '$especialidad', '$telefono', '$correo')";
    return $conn->query($sql);
}

function addConsultorio($data) {
    global $conn;
    $nombre = $data['nombre_consultorio'];
    $direccion = $data['direccion_consultorio'];
    $telefono = $data['telefono_consultorio'];

    $sql = "INSERT INTO Consultorios (nombre, direccion, telefono) VALUES ('$nombre', '$direccion', '$telefono')";
    return $conn->query($sql);
}

function addCita($data) {
    global $conn;

    $paciente_id = $data['paciente_id'];
    $medico_id = $data['medico_id'];
    $fecha = $data['fecha'];
    $hora = $data['hora'];

    // Verificar si el paciente y médico existen
    $checkPaciente = "SELECT * FROM Pacientes WHERE paciente_id = $paciente_id";
    $checkMedico = "SELECT * FROM Medicos WHERE medico_id = $medico_id";

    $pacienteResult = $conn->query($checkPaciente);
    $medicoResult = $conn->query($checkMedico);

    if ($pacienteResult->num_rows > 0 && $medicoResult->num_rows > 0) {
        // Seleccionar un consultorio al azar
        $randomConsultorioQuery = "SELECT consultorio_id FROM Consultorios ORDER BY RAND() LIMIT 1";
        $consultorioResult = $conn->query($randomConsultorioQuery);
        
        if ($consultorioResult->num_rows > 0) {
            $consultorioRow = $consultorioResult->fetch_assoc();
            $consultorio_id = $consultorioRow['consultorio_id'];
        } else {
            echo "Error: No hay consultorios disponibles.";
            return;
        }

        // Insertar la cita
        $sql = "INSERT INTO Citas (paciente_id, medico_id, fecha, hora, consultorio_id) VALUES ($paciente_id, $medico_id, '$fecha', '$hora', $consultorio_id)";
        if ($conn->query($sql) === TRUE) {
            echo "Cita creada con éxito en el consultorio ID: $consultorio_id";
        } else {
            echo "Error al crear la cita: " . $conn->error;
        }
    } else {
        echo "Error: El paciente o médico no existen.";
    }
}

function listPatients() {
    global $conn;
    $sql = "SELECT * FROM Pacientes";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "<table>
                <tr><th>Nombre</th><th>Apellido</th><th>ID</th><th>Archivo</th><th>Acciones</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['nombre']}</td>
                    <td>{$row['apellido']}</td>
                    <td>{$row['paciente_id']}</td>
                    <td><a href='{$row['archivo']}' target='_blank'>Ver Archivo</a></td>
                    <td>
                        <form method='POST' style='display:inline;'>
                            <input type='hidden' name='paciente_id' value='{$row['paciente_id']}'>
                            <button type='submit' name='delete_patient'>Eliminar</button>
                        </form>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No hay pacientes registrados.</p>";
    }
}

function listMedicos() {
    global $conn;
    $sql = "SELECT * FROM Medicos";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "<table>
                <tr><th>Nombre</th><th>Apellido</th><th>ID</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row['nombre']}</td><td>{$row['apellido']}</td><td>{$row['medico_id']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No hay médicos registrados.</p>";
    }
}

function listConsultorios() {
    global $conn;
    $sql = "SELECT * FROM Consultorios";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "<table>
                <tr><th>Nombre</th><th>ID</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row['nombre']}</td><td>{$row['consultorio_id']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No hay consultorios registrados.</p>";
    }
}

function listCitas() {
    global $conn;
    $sql = "SELECT Citas.cita_id, Pacientes.nombre AS paciente, Medicos.nombre AS medico, Consultorios.nombre AS consultorio, Citas.fecha, Citas.hora 
            FROM Citas 
            JOIN Pacientes ON Citas.paciente_id = Pacientes.paciente_id 
            JOIN Medicos ON Citas.medico_id = Medicos.medico_id 
            JOIN Consultorios ON Citas.consultorio_id = Consultorios.consultorio_id"; 
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "<table>
                <tr><th>Paciente</th><th>Médico</th><th>Consultorio</th><th>Fecha</th><th>Hora</th><th>Acciones</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['paciente']}</td>
                    <td>{$row['medico']}</td>
                    <td>{$row['consultorio']}</td>
                    <td>{$row['fecha']}</td>
                    <td>{$row['hora']}</td>
                    <td>
                        <form method='POST' style='display:inline;'>
                            <input type='hidden' name='cita_id' value='{$row['cita_id']}'>
                            <button type='submit' name='edit_cita'>Editar</button>
                        </form>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No hay citas registradas.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Pacientes</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Gestión de Pacientes</h1>
    
    <div class="tabs">
        <button class="tablinks" onclick="openTab(event, 'Pacientes')">Pacientes</button>
        <button class="tablinks" onclick="openTab(event, 'Medicos')">Médicos</button>
        <button class="tablinks" onclick="openTab(event, 'Consultorios')">Consultorios</button>
        <button class="tablinks" onclick="openTab(event, 'Citas')">Citas</button>
    </div>

    <div id="Pacientes" class="tabcontent">
        <h2>Añadir Paciente</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="text" name="apellido" placeholder="Apellido" required>
            <input type="text" name="documento_id" placeholder="Documento ID" required>
            <input type="date" name="fecha_nacimiento" required>
            <input type="text" name="telefono" placeholder="Teléfono" required>
            <input type="text" name="direccion" placeholder="Dirección" required>
            <input type="email" name="correo" placeholder="Correo" required>
            <input type="file" name="archivo" accept=".pdf" required>
            <button type="submit" name="add_patient">Agregar Paciente</button>
        </form>

        <?php listPatients(); ?>
    </div>

    <div id="Medicos" class="tabcontent">
        <h2>Añadir Médico</h2>
        <form method="POST">
            <input type="text" name="nombre_medico" placeholder="Nombre" required>
            <input type="text" name="apellido_medico" placeholder="Apellido" required>
            <input type="text" name="especialidad" placeholder="Especialidad" required>
            <input type="text" name="telefono_medico" placeholder="Teléfono" required>
            <input type="email" name="correo_medico" placeholder="Correo" required>
            <button type="submit" name="add_medico">Agregar Médico</button>
        </form>

        <?php listMedicos(); ?>
    </div>

    <div id="Consultorios" class="tabcontent">
        <h2>Añadir Consultorio</h2>
        <form method="POST">
            <input type="text" name="nombre_consultorio" placeholder="Nombre" required>
            <input type="text" name="direccion_consultorio" placeholder="Dirección" required>
            <input type="text" name="telefono_consultorio" placeholder="Teléfono" required>
            <button type="submit" name="add_consultorio">Agregar Consultorio</button>
        </form>

        <?php listConsultorios(); ?>
    </div>

    <div id="Citas" class="tabcontent">
        <h2>Crear Cita</h2>
        <form method="POST">
            <input type="text" name="paciente_id" placeholder="ID del Paciente" required>
            <input type="text" name="medico_id" placeholder="ID del Médico" required>
            <input type="date" name="fecha" required>
            <input type="time" name="hora" required>
            <button type="submit" name="add_cita">Agregar Cita</button>
        </form>

        <?php listCitas(); ?>
    </div>

    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>
</body>
</html>
