<?php
include_once BASE_DIR . '/models/db.php';
$stmt = $pdo->query('SELECT COUNT(*) as total_productos FROM productos');
$total_productos = $stmt->fetch()['total_productos'];
$stmt = $pdo->query('SELECT SUM(cantidad) as total_vendidos FROM salidas');
$total_vendidos = $stmt->fetch()['total_vendidos'];
$stmt = $pdo->query('SELECT SUM(stock) as total_stock FROM productos'); 
$total_stock = $stmt->fetch()['total_stock'];
$stock_bajos = $pdo->query('SELECT  productos.nombre, categorias.nombre as categoria,productos.categoria_id, productos.stock as cantidad FROM productos JOIN categorias ON productos.categoria_id = categorias.id where productos.stock < 5 LIMIT 4 ' );
$product_more_sale = $pdo->query('SELECT productos.nombre, COUNT(productos.nombre) AS total ,SUM(cantidad) AS vendidos FROM salidas JOIN productos ON salidas.producto_id = productos.id GROUP BY (productos.id) LIMIT 4 ');
?>
