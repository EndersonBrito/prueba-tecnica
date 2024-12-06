<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once BASE_DIR . '/models/db.php';
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? null;
    $accion = $data['accion'] ?? null;
    $nombre = $data['nombre'];
     $descripcion = $data['descripcion'];
     if (empty($nombre)) {
        echo json_encode(['success' => false, 'message' => 'El nombre del producto es obligatorio.']);
        exit;
    }
    if (empty($descripcion)) {
        echo json_encode(['success' => false, 'message' => 'La descripción del producto es obligatoria.']);
        exit;
    }
    if ($accion === 'M') {
        $stmt = $pdo->prepare('UPDATE categorias SET nombre = ?, descripcion = ? WHERE id = ?');
        $stmt->execute([$nombre,$descripcion , $id]);
        $message = "Categoría actualizada exitosamente!";
       echo json_encode(['success' => true, 'message' => 'Categoría actualizada exitosamente']);
    } elseif ($accion === 'I'){
        $stmt = $pdo->prepare('INSERT INTO categorias (nombre,descripcion) VALUES (?,?)');
        $stmt->execute([$nombre, $descripcion]);
        $message = "Categoría agregada exitosamente!";
        echo json_encode(['success' => true, 'message' => 'Categoría agregada exitosamente']);
    }elseif ($accion ==='E'){  
        if (isset($data['id'])) {
            $id = $data['id'];
            // Eliminar la categoría
            $stmt = $pdo->prepare('DELETE FROM categorias WHERE id = ?');
            $stmt->execute([$id]);
            echo json_encode(['success' => true, 'message' => 'Categoría eliminada exitosamente']);
        }
    }

}else{
    include_once BASE_DIR . '/models/db.php';

    $categorias = $pdo->query('SELECT * FROM categorias');
}


?>
