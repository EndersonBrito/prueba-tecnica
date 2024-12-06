<?php
    session_start(); 
    if (!isset($_SESSION['username'])) 
{ 
    header("Location: /"); 
    
    exit(); 
} 
include_once BASE_DIR . '/controller/productController.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
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
                    <a class="nav-link" href="/">Inicio <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
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
        <h1>Gestión de Productos</h1>

        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addProductModal">Agregar Producto</button>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                 while ($row = $poduct->fetch()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['nombre']}</td>
                            <td>{$row['categoria']}</td>
                            <td>{$row['cantidad']}</td>
                            <td>{$row['precio']}</td>
                            <td>
                                <button class='btn btn-success' data-toggle='modal' data-target='#editProductModal' data-id='{$row['id']}' data-nombre='{$row['nombre']}' data-categoria='{$row['categoria_id']}'  data-cantidad='{$row['cantidad']} 'data-precio='{$row['precio']}'>Editar</button>
                                <button class='btn btn-danger' onclick='deletepoduct({$row['id']})'>Eliminar</button>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para agregar producto -->
    <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="productController" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Agregar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addProductForm" method="POST" action="manage_product.php">
                    <input type="hidden" id="accion" name="accion" value="I">
                    <div class="form-group">
                        <label for="nombre">Nombre del Producto</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="categoria">Categoría</label>
                        <select class="form-control" id="categoria" name="categoria" required>
                            <?php
                                while ($cat = $categorias->fetch()) {
                                    echo "<option value='{$cat['id']}'>{$cat['nombre']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                    </div>
                    <div class="form-group"> 
                        <label for="precio">Precio</label>
                         <input type="number" step="0.01" class="form-control" id="precio" name="precio" required> 
                        </div>
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>


    <!-- Modal para editar producto -->
    <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Editar Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm" method="POST" action="productController.php">
                        <input type="hidden" id="edit-id" name="id">
                        <input type="hidden" id="edit-accion" name="accion" value="M">
                        <div class="form-group">
                            <label for="edit-nombre">Nombre del Producto</label>
                            <input type="text" class="form-control" id="edit-nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-categoria">Categoría</label>
                            <select class="form-control" id="edit-categoria" name="categoria" required>
                                <!-- Opciones de categorías -->
                                <?php
                                   
                                    while ($catEdit = $categoriasEdit->fetch()) {
                                        echo "<option value='{$catEdit['id']}'>{$catEdit['nombre']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit-cantidad">Cantidad</label>
                            <input type="number" class="form-control" id="edit-cantidad" name="cantidad" required>
                        </div>
                        <div class="form-group">
                             <label for="edit-precio">Precio</label> 
                            <input type="number" step="0.01" class="form-control" id="edit-precio" name="precio" required> 
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-KsHyyF0zP4CFQ+OM6JId7GmeEpt9EKFgUOOwlx8yRg1zEjrPSH0S+QknLNK8y7H1" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        $('#editProductModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var nombre = button.data('nombre');
            var categoria = button.data('categoria');
            var cantidad = button.data('cantidad');
            var precio = button.data('precio');
            var modal = $(this);
            modal.find('#edit-id').val(id);
            modal.find('#edit-nombre').val(nombre);
            modal.find('#edit-categoria').val(categoria);
            modal.find('#edit-cantidad').val(cantidad);
            modal.find('#edit-precio').val(precio);
        });
        document.getElementById('addProductForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const nombre = document.getElementById('nombre').value;
            const categoria = document.getElementById('categoria').value;
            const cantidad = document.getElementById('cantidad').value;
            const precio = document.getElementById('precio').value;
            const accion = document.getElementById('accion').value;

            fetch('productController', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: 0, nombre: nombre, categoria: categoria, precio: precio, cantidad: cantidad, accion :accion })

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
        document.getElementById('editProductForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const id = document.getElementById('edit-id').value;
            const nombre = document.getElementById('edit-nombre').value;
            const categoria = document.getElementById('edit-categoria').value;
            const cantidad = document.getElementById('edit-cantidad').value;
            const precio = document.getElementById('edit-precio').value;
            const accion = document.getElementById('edit-accion').value;

            fetch('productController', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: id, nombre: nombre, categoria: categoria, precio: precio, cantidad: cantidad, accion :accion })
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

        function deletepoduct(id) {
            
            if (confirm('¿Estás seguro de que deseas eliminar esta producto?')) {
                fetch('productController', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: id, nombre: '', categoria: '', precio: '', cantidad: '', accion :'E' })

                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message);
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
                    alert(data.message);
                }
            });
        });
    </script>
</body>
</html>
