<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
        <style>
            .grandParentContainer{
                display:table; height:100%; margin: 0 auto; border:3px;
            }

            .parentContainer{
                display:table-cell; vertical-align:middle;
            }	
        </style>
        <title>Gestione Alternanza Scuola Lavoro</title>
    </head>
    <body>
        <div class="grandParentContainer">
            <div class="parentContainer">
                <div class="m-4">
                    <form action="authenticate.php" class="needs-validation border p-3" method="post" validate>
                        <div class="mb-3">
                            <label class="form-label" for="username">Username</label>
                            <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                            <div class="invalid-feedback">Inserire username</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="inputPassword">Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                            <div class="invalid-feedback">Inserire la password per continuare</div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                
                            </div>
                            <button type="submit" class="btn btn-primary">Sign in</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
        // put your code here
        ?>
    </body>
</html>
