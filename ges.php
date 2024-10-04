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

    $sql = "INSERT INTO Pacientes (nombre, apellido, documento_id, fecha_nacimiento, telefono, direccion, correo) VALUES ('$nombre', '$apellido', '$documento_id', '$fecha_nacimiento', '$telefono', '$direccion', '$correo')";
    return $conn->query($sql);
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
                <tr><th>Nombre</th><th>Apellido</th><th>ID</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row['nombre']}</td><td>{$row['apellido']}</td><td>{$row['paciente_id']}</td></tr>";
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
                <tr><th>ID</th><th>Paciente</th><th>Médico</th><th>Consultorio</th><th>Fecha</th><th>Hora</th><th>Acciones</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['cita_id']}</td>
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

function getCita($cita_id) {
    global $conn;
    $sql = "SELECT * FROM Citas WHERE cita_id = $cita_id";
    return $conn->query($sql)->fetch_assoc();
}

function updateCita($data) {
    global $conn;
    $cita_id = $data['cita_id'];
    $paciente_id = $data['paciente_id'];
    $medico_id = $data['medico_id'];
    $fecha = $data['fecha'];
    $hora = $data['hora'];

    $sql = "UPDATE Citas SET paciente_id='$paciente_id', medico_id='$medico_id', fecha='$fecha', hora='$hora' WHERE cita_id=$cita_id";
    return $conn->query($sql);
}

// Manejar formularios enviados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_patient'])) {
        addPatient($_POST);
    } elseif (isset($_POST['add_medico'])) {
        addMedico($_POST);
    } elseif (isset($_POST['add_consultorio'])) {
        addConsultorio($_POST);
    } elseif (isset($_POST['add_cita']) && isset($_POST['acepto'])) {
        addCita($_POST);
    } elseif (isset($_POST['edit_cita'])) {
        $cita = getCita($_POST['cita_id']);
    } elseif (isset($_POST['update_cita'])) {
        updateCita($_POST);
        $cita = null; // Reset after update
    }
}

// Obtener el valor de la tabla seleccionada
$tabla = isset($_GET['tabla']) ? $_GET['tabla'] : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Citas Médicas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            text-align: center;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .menu {
            text-align: center;
            margin-bottom: 20px;
        }
        select {
            padding: 10px;
            width: 200px;
        }
        button {
            margin: 5px 0;
            padding: 10px;
            width: 100%;
            max-width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        .section {
            display: none;
            max-height: 400px;
            overflow-y: auto;
        }
        .active {
            display: block;
        }
        .flex-container {
            display: flex;
            justify-content: space-between;
        }
        .flex-item {
            width: 48%;
        }
    </style>
</head>
<body>

<h1>Gestión de Citas Médicas</h1>

<div class="container">
    <div class="menu">
        <form method="GET">
            <select name="tabla" onchange="this.form.submit()">
                <option value="">Selecciona una tabla</option>
                <option value="pacientes" <?php if ($tabla == 'pacientes') echo 'selected'; ?>>Pacientes</option>
                <option value="medicos" <?php if ($tabla == 'medicos') echo 'selected'; ?>>Médicos</option>
                <option value="consultorios" <?php if ($tabla == 'consultorios') echo 'selected'; ?>>Consultorios</option>
                <option value="citas" <?php if ($tabla == 'citas') echo 'selected'; ?>>Citas</option>
            </select>
        </form>
    </div>

    <?php
    // Mostrar secciones según la selección del menú
    if ($tabla == 'pacientes') {
        echo '<div class="section active">';
        echo '<h2>Añadir Paciente</h2>';
        echo '<form method="POST">';
        echo '<input type="text" name="nombre" placeholder="Nombre" required>';
        echo '<input type="text" name="apellido" placeholder="Apellido" required>';
        echo '<input type="text" name="documento_id" placeholder="Documento ID" required>';
        echo '<input type="date" name="fecha_nacimiento" required>';
        echo '<input type="text" name="telefono" placeholder="Teléfono" required>';
        echo '<input type="text" name="direccion" placeholder="Dirección" required>';
        echo '<input type="email" name="correo" placeholder="Correo" required>';
        echo '<button type="submit" name="add_patient">Agregar Paciente</button>';
        echo '</form>';
        listPatients();
        echo '</div>';
    }

    if ($tabla == 'medicos') {
        echo '<div class="section active">';
        echo '<h2>Añadir Médico</h2>';
        echo '<form method="POST">';
        echo '<input type="text" name="nombre_medico" placeholder="Nombre" required>';
        echo '<input type="text" name="apellido_medico" placeholder="Apellido" required>';
        echo '<input type="text" name="especialidad" placeholder="Especialidad" required>';
        echo '<input type="text" name="telefono_medico" placeholder="Teléfono" required>';
        echo '<input type="email" name="correo_medico" placeholder="Correo" required>';
        echo '<button type="submit" name="add_medico">Agregar Médico</button>';
        echo '</form>';
        listMedicos();
        echo '</div>';
    }

    if ($tabla == 'consultorios') {
        echo '<div class="section active">';
        echo '<h2>Añadir Consultorio</h2>';
        echo '<form method="POST">';
        echo '<input type="text" name="nombre_consultorio" placeholder="Nombre" required>';
        echo '<input type="text" name="direccion_consultorio" placeholder="Dirección" required>';
        echo '<input type="text" name="telefono_consultorio" placeholder="Teléfono" required>';
        echo '<button type="submit" name="add_consultorio">Agregar Consultorio</button>';
        echo '</form>';
        listConsultorios();
        echo '</div>';
    }

    if ($tabla == 'citas') {
        echo '<div class="section active flex-container">';
        
        // Añadir Cita
        echo '<div class="flex-item">';
        echo '<h2>Añadir Cita</h2>';
        echo '<form method="POST">';
        echo '<input type="number" name="paciente_id" placeholder="ID Paciente" required>';
        echo '<input type="number" name="medico_id" placeholder="ID Médico" required>';
        echo '<input type="date" name="fecha" required>';
        echo '<input type="time" name="hora" required>';
        echo '<label><input type="checkbox" name="acepto" required> Acepto agendar la cita</label>';
        echo '<button type="submit" name="add_cita">Agregar Cita</button>';
        echo '</form>';
        echo '</div>';
        
        // Lista de citas
        echo '<div class="flex-item">';
        listCitas();
        echo '</div>';
        
        echo '</div>'; // Cierre de flex-container

        // Formulario de edición
        if (isset($cita)) {
            echo '<h2>Editar Cita</h2>';
            echo '<form method="POST">';
            echo '<input type="hidden" name="cita_id" value="' . $cita['cita_id'] . '">';
            echo '<input type="number" name="paciente_id" placeholder="ID Paciente" value="' . $cita['paciente_id'] . '" required>';
            echo '<input type="number" name="medico_id" placeholder="ID Médico" value="' . $cita['medico_id'] . '" required>';
            echo '<input type="date" name="fecha" value="' . $cita['fecha'] . '" required>';
            echo '<input type="time" name="hora" value="' . $cita['hora'] . '" required>';
            echo '<button type="submit" name="update_cita">Actualizar Cita</button>';
            echo '</form>';
        }
    }
    ?>
</div>

</body>
</html>
