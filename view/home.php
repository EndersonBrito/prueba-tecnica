<?php
    session_start(); 
    if (!isset($_SESSION['username'])) 
{ 
    header("Location: /"); 
    exit(); 
    
} 
include_once BASE_DIR . '/controller/homeController.php';
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de inventario</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Inventario</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Inicio <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/product">Productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/category">Categorías</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/ventas">Ventas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="btnLogout" href="/login">Salir</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Panel de Control</h1>
        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Cantidad de Productos</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $total_productos; ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Total Vendidos</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo is_null($total_vendidos) ? 0 : $total_vendidos; ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Total en Stock</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo is_null($total_stock) ? 0 : $total_stock; ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h1>Producto con bajo stock</h1>
                
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $stock_bajos->fetch()) {
                            echo "<tr>
                                    <td>{$row['nombre']}</td>
                                    <td>{$row['categoria']}</td>
                                    <td>{$row['cantidad']}</td>
                                   
                                </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <h1>Productos mas vendidos</h1>
                
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Ventas</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $product_more_sale->fetch()) {
                            echo "<tr>
                                    <td>{$row['nombre']}</td>
                                    <td>{$row['total']}</td>
                                    <td>{$row['vendidos']}</td>
                                   
                                </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>          
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-KsHyyF0zP4CFQ+OM6JId7GmeEpt9EKFgUOOwlx8yRg1zEjrPSH0S+QknLNK8y7H1" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        document.getElementById('btnLogout').addEventListener('click', function (e) {
            e.preventDefault();

            const username = "";
            const password = "";
            fetch('loginController', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: 0, username: username, password: password, accion :'S' })

            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error al loguear el usuario');
                }
            });
        });
    </script>
</body>
</html>
