<?php
  session_start(); 
  if (!isset($_SESSION['username'])) 
    { 
        header("Location: /"); 
        
        exit(); 
    } 
    include_once BASE_DIR . '/controller/ventasController.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Salidas de Productos</title>
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
            
               <li class="nav-item ">
                    <a class="nav-link" href="/">Inicio </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/product">Productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/category">Categorías</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="/ventas"><span class="sr-only">(current)</span>Ventas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="btnLogout" href="/login">Salir</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-5">
        <h1>Gestión de Salidas de Productos</h1>
        <?php  
            if ($_SESSION['rol'] == 'admin') 
            { 
                echo '<button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addSalidaModal">Registrar Salida</button>';
            } 
        ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>total</th>
                    <th>Fecha</th>
                    <?php  
                        if ($_SESSION['rol'] == 'admin') 
                        { 
                            echo '<th>Acciones</th>  ';
                        } 
                    ?>
                    
                </tr>
            </thead>
            <tbody id="productTableBody">
                <?php
                    while ($row = $salidas->fetch()) {
                        $txt = "";
                        $txt = $txt . "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['nombre']}</td>
                                <td>{$row['cantidad']}</td>
                                <td>{$row['precio']}</td>
                                <td>{$row['total'] }</td>
                                <td>{$row['fecha'] }</td> ";
                                if ($_SESSION['rol'] == 'admin') 
                                { 
                                    $txt = $txt . " <td>
                                        <button class='btn btn-danger' onclick='deleteProduct({$row['id']})'>Eliminar</button>
                                    </td>";
                                } 
                            echo $txt .  "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para registrar salida -->
    <div class="modal fade" id="addSalidaModal" tabindex="-1" role="dialog" aria-labelledby="addSalidaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSalidaModalLabel">Registrar Salida</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addSalidaForm">
                        <div class="form-group">
                            <label for="producto_id">Producto</label>
                            <select class="form-control" id="producto_id" name="producto_id" required>
                                <?php
                                $productos = $pdo->query('SELECT * FROM productos');

                                while ($prod = $productos->fetch()) {
                                    echo "<option value='{$prod['id']}'>{$prod['nombre']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <input type="number" class="form-control" id="cantidad" name="cantidad"  required>
                        </div>
                        <button type="submit" class="btn btn-primary">Registrar Salida</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-KsHyyF0zP4CFQ+OM6JId7GmeEpt9EKFgUOOwlx8yRg1zEjrPSH0S+QknLNK8y7H1" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        document.getElementById('addSalidaForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const producto_id = document.getElementById('producto_id').value;
            const cantidad = document.getElementById('cantidad').value;

            fetch('ventasController', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ producto_id: producto_id, cantidad: cantidad, accion : 'I'})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message);
                }
            });
        });

        function deleteProduct(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
                fetch(`ventasController`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ producto_id: id, cantidad: 0 , accion : 'E'})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error al eliminar producto');
                    }
                }).catch(error => {
                    if (typeof error.json === "function") {
                        error.json().then(jsonError => {
                            console.log("Json error from API");
                            console.log(jsonError);
                        }).catch(genericError => {
                            console.log("Generic error from API");
                            console.log(error.statusText);
                        });
                    } else {
                        console.log("Fetch error");
                        console.log(error);
                    }
                });
            }
        }
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
