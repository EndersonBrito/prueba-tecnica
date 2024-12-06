<?php
    session_start(); 
    if (!isset($_SESSION['username'])) 
    { 
        header("Location: /"); 
        
        exit(); 
    } 
    include_once BASE_DIR . '/controller/categoryController.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Categorías</title>
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
                    <a class="nav-link"  id="btnLogout" href="/login">Salir</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-5">
        <h1>Gestión de Categorías</h1>
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addCategoryModal">Agregar Categoría</button>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $categorias->fetch()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['nombre']}</td>
                            <td>{$row['descripcion']}</td>
                            <td>
                                <button class='btn btn-success' data-toggle='modal' data-target='#editCategoryModal' data-id='{$row['id']}' data-nombre='{$row['nombre']}' data-descripcion='{$row['descripcion']}'>Editar</button>
                                <button class='btn btn-danger' onclick='deleteCategory({$row['id']})'>Eliminar</button>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para agregar categoría -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Agregar Categoría</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addCategoryForm" method="POST" action="categoryController">
                    <input type="hidden" id="accion" name="accion" value="I">
                    <div class="form-group">
                            <label for="nombre">Nombre de la Categoría</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripcion de la Categoría</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar categoría -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Editar Categoría</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editCategoryForm" method="POST" action="categoryController.php">
                    <input type="hidden" id="edit-accion" name="accion" value="M">
                    <input type="hidden" id="edit-id" name="id">
                        <div class="form-group">
                            <label for="edit-nombre">Nombre de la Categoría</label>
                            <input type="text" class="form-control" id="edit-nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-descripcion">Descripcion de la Categoría</label>
                            <input type="text" class="form-control" id="edit-descripcion" name="descripcion" required>
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
        $('#editCategoryModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var nombre = button.data('nombre');
            var descripcion = button.data('descripcion');
            
            var modal = $(this);
            modal.find('#edit-id').val(id);
            modal.find('#edit-nombre').val(nombre);
            modal.find('#edit-descripcion').val(descripcion);
        });
        document.getElementById('addCategoryForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const nombre = document.getElementById('nombre').value;
            const descripcion = document.getElementById('descripcion').value;
            const accion = document.getElementById('accion').value;

            fetch('categoryController', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ nombre: nombre , descripcion: descripcion, accion :accion})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error al agregar categoría');
                }
            });
        });
        document.getElementById('editCategoryForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const id = document.getElementById('edit-id').value;
            const nombre = document.getElementById('edit-nombre').value;
            const descripcion = document.getElementById('edit-descripcion').value;
            const accion = document.getElementById('edit-accion').value;

            fetch('categoryController', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: id, nombre: nombre, descripcion: descripcion, accion :accion })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error al actualizar categoría');
                }
            });
        });

        function deleteCategory(id) {
            
            if (confirm('¿Estás seguro de que deseas eliminar esta categoría?')) {
                fetch('categoryController', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: id, nombre: '', descripcion: '', accion :'E' })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error al eliminar categoría');
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
