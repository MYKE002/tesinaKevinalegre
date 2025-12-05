<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>No Tienes Permisos</title>
    <link href="<?php echo base_url; ?>Assets/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url; ?>Assets/css/sb-admin-2.css" rel="stylesheet" type="text/css">

</head>

<body>
    <div class="content mt-5">
        <div class="container-fluid">
            <!-- Error Text -->
            <div class="text-center">
                <div class="error mx-auto" style="width: max-content;" data-text="403">403</div>
                <p class="lead text-gray-800 mb-5">ACCESO DENEGADO :( </p>
                <p class="text-gray-500 mb-4">No tienes permisos para acceder a este módulo, por favor ponte en contacto con tu proveedor...</p>
                <a href="<?php echo base_url; ?>Administracion/home">← Volver al Panel de Administración</a>
            </div>
        </div>
    </div>
</body>

</html>
