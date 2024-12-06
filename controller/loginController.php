<?php
include_once BASE_DIR . '/models/db.php';
$data = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $data['username'];
    $accion = $data['accion'];
    $opciones = [
        'cost' => 12,
    ];
    $password = hash('sha256',$data['password']);
   
    if ($accion === 'L'){
        try {
            $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = ?');
            $stmt->execute([$username]);
            $user = $stmt->fetch(); 
            if ($user && $password === $user['password']) { 
                session_start(); 
                $_SESSION['username'] = $username;
                $_SESSION['rol'] = $user['rol'];
                echo json_encode(['success' => true, 'message' => 'Usuario o contraseña correctos.']);
                // Redirige al dashboard 
            } else { 
                echo json_encode(['success' => false, 'message' => 'Usuario o contraseña incorrectos.']);

            }
        } catch (PDOException $e) {
            echo "Database query exception: " . $e->getMessage();
            return false;
        }
       

    }elseif ($accion === 'R'){
       
        try {
            $stmt = $pdo->prepare('INSERT INTO usuarios (email,nombre, password,rol) VALUES (?,?, ?,?)');
            $stmt->execute([$username,$username, $password, 'usuario']);
            echo json_encode(['success' => true, 'message' => 'Usuarios agregada exitosamente']);
        } catch (PDOException $e) {      
            echo "Error de conexión: " . $e->getMessage();    
            echo json_encode(['success' => false, 'message' => 'Error de conexión']);
        }
    }elseif ($accion === 'S'){ //SALIR DEL SISTEMA
       
        session_start(); 
        session_destroy(); 
        echo json_encode(['success' => true, 'message' => 'Usuarios agregada exitosamente']);

    }else {
        echo json_encode(['success' => false, 'message' => 'Error al registar el usuario']);
       
    }

}