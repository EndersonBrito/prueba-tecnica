<?php

include_once BASE_DIR . '/models/db.php';

$salidas = $pdo->query('SELECT productos.nombre, salidas.cantidad,productos.id AS product_id, salidas.fecha , salidas.precio , salidas.id ,  salidas.precio * salidas.cantidad AS total   FROM salidas JOIN productos ON salidas.producto_id = productos.id');
// Asegúrate de incluir tu archivo de conexión a la base de datos

$data = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $producto_id = $data['producto_id'];
    $cantidad = $data['cantidad'];
    $accion = $data['accion'];
    $precio =0;
    $cant =0;
    if (!is_numeric($producto_id) || $producto_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'El producto seleccionado no es válido.']);
        exit;
    }

    if (!is_numeric($cantidad) || $cantidad < 0) {
        echo json_encode(['success' => false, 'message' => 'La cantidad no debe ser un número  negativo.']);
        exit;
    }

    if ($accion === 'I'){
        try {
            $st =$pdo->prepare('SELECT precio,stock from productos where id = ?');
            $st->bindValue(':precio', $precio, PDO::PARAM_INT);
            $st->execute([$producto_id]);
            $result = $st->fetch();
        
            $precio = $result[0];
            $cant = $result[1];

        } catch (PDOException $e) {
            echo "Database query exception: " . $e->getMessage();
            return false;
        }
        if ($cant >= $cantidad ) {
            try {
                $stockRestante = $cant - $cantidad;
                $stmt = $pdo->prepare('INSERT INTO salidas (producto_id, cantidad,precio) VALUES (?, ?, ?)');
                $stmt->execute([$producto_id, $cantidad, $precio]);
                $message = "venta agregada exitosamente!";
                $stmt = $pdo->prepare('UPDATE productos SET  stock = ? WHERE id = ?');
                $stmt->execute([ $stockRestante, $producto_id]);
            } catch (PDOException $e) {
                echo "Error de conexión: " . $e->getMessage();
            }
            echo json_encode(['success' => true, 'message' => 'Ventas agregada exitosamente']);
        }else {
            echo json_encode(['success' => false, 'message' => 'La cantidad de la venta no puede ser mayor a la cantidad en stock del producto']);
           
        }
       

    }elseif ($accion === 'E'){
        if (isset($data['producto_id'])) {
            $id = $data['producto_id'];
            // Eliminar la categoría
            $stmt = $pdo->prepare('DELETE FROM salidas WHERE id = ?');
            $stmt->execute([$id]);
            echo json_encode(['success' => true, 'message' => 'Ventas eliminada exitosamente']);
        }
    }

}// Registrar la salida
