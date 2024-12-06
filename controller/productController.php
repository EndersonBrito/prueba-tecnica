<?php
include_once BASE_DIR . '/models/db.php';

$poduct = $pdo->query('SELECT productos.id, productos.nombre, categorias.nombre as categoria,productos.categoria_id, productos.stock as cantidad , precio FROM productos JOIN categorias ON productos.categoria_id = categorias.id');
$categorias = $pdo->query('SELECT * FROM categorias');
$categoriasEdit = $pdo->query('SELECT * FROM categorias');
$data = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $data['id'] ?? null;
    $nombre = $data['nombre'];
    $categoria = $data['categoria'];
    $cantidad = $data['cantidad'];
    $precio =   $data['precio'];
    $accion = $data['accion'] ?? null;
    if (empty($nombre)) {
        echo json_encode(['success' => false, 'message' => 'El nombre del producto es obligatorio.']);
        exit;
    }

    if (!is_numeric($categoria) || $categoria <= 0) {
        echo json_encode(['success' => false, 'message' => 'La categoría seleccionada no es válida.']);
        exit;
    }

    if (!is_numeric($cantidad) || $cantidad < 0) {
        echo json_encode(['success' => false, 'message' => 'La cantidad no debe ser un número  negativo.']);
        exit;
    }

    if (!is_numeric($precio) || $precio < 0) {
        echo json_encode(['success' => false, 'message' => 'El precio no debe ser un número negativo.']);
        exit;
    }
    if ($accion === 'M') {
        try {
            $stmt = $pdo->prepare('UPDATE productos SET nombre = ?, precio = ?, categoria_id = ?, stock = ? WHERE id = ?');
            $stmt->execute([$nombre, $precio, $categoria, $cantidad, $id]);
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
        
        $message = "Producto actualizado exitosamente!";
        
        echo json_encode(['success' => true, 'message' => 'Producto actualizado exitosamente']);

    } elseif ($accion === 'I'){
        $stmt = $pdo->prepare('INSERT INTO productos (nombre, categoria_id,precio, stock) VALUES (?, ?, ?, ?)');
        $stmt->execute([$nombre, $categoria, $precio, $cantidad]);
        $message = "Producto agregado exitosamente!";
        echo json_encode(['success' => true, 'message' => 'Producto agregado exitosamente']);

    }elseif ($accion === 'E'){
        if (isset($data['id'])) {
            $id = $data['id'];
            // Eliminar la categoría
            $stmt = $pdo->prepare('DELETE FROM productos WHERE id = ?');
            $stmt->execute([$id]);
            echo json_encode(['success' => true, 'message' => 'Producto eliminada exitosamente']);
        }
    }

}

?>
