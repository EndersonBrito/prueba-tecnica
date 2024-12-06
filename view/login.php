<?php 
    session_start(); 
    if (isset($_SESSION['username'])) 
    { 
        header("Location: /home"); 
        
        exit(); 
    } 
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de Usuario</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5 ">
        
        <div class="col-md-6 offset-md-3">
            <div id="divFormLogin">
            <h1 class=" text-center">Login de Usuario</h1>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
                <form id="formloginUser" method="POST" action="login.php">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
                <button type="btn" class="btn btn-primary mt-4" onclick="mostrarDivRegistar()">Registrar</button>
            </div>
                <div id="divFormRegister" style="display: none;">
                <h1 class=" text-center">Registrar de Usuario</h1>
                <form id="formRegisterUser" method="POST" action="login.php">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="usernameReg" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="passwordReg" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Repetir Password</label>
                        <input type="password" class="form-control" id="passwordRegRepeat" name="passwordRegRepeat" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </form>
                <button type="btn" class="btn btn-primary mt-4" onclick="mostrarDivLogin()">Login</button>
            </div>
           
            </div>
        
    </div>
    <script>
        document.getElementById('formloginUser').addEventListener('submit', function (e) {
            e.preventDefault();

            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            fetch('loginController', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: 0, username: username, password: password, accion :'L' })

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
        function mostrarDivRegistar() {
            var divFormLogin = document.getElementById("divFormLogin");
            var divFormRegister = document.getElementById("divFormRegister");
            divFormRegister.style.display = "block";
            divFormLogin.style.display = "none";
        }
        function mostrarDivLogin() {
            var divFormLogin = document.getElementById("divFormLogin");
            var divFormRegister = document.getElementById("divFormRegister");
            divFormRegister.style.display = "none";
            divFormLogin.style.display = "block";
        }
        document.getElementById('formRegisterUser').addEventListener('submit', function (e) {
            e.preventDefault();

            const username = document.getElementById('usernameReg').value;
            const password = document.getElementById('passwordReg').value;
            const passwordRepeat = document.getElementById('passwordRegRepeat').value;
            console.log(username);
            console.log(password);
            console.log(passwordRepeat);

            if (password != passwordRepeat){
                console.log('El password no coninciden ');
                alert('El password no coninciden ');
                console.log('El password no coninciden ');
              
            } 
            else{
                fetch('loginController', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: 0, username: username, password: password, accion :'R' })

                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error al loguear el usuario');
                    }
                });
            }
           
        });
    </script>
</body>
</html>
