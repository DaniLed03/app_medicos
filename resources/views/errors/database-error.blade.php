<!-- resources/views/errors/database-error.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error de Conexión</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8 text-center">
                <h1 class="display-4 text-danger">Error de Conexión a la Base de Datos</h1>
                <p class="lead">No se puede conectar con la base de datos en este momento. Por favor, intenta nuevamente más tarde.</p>
                <p>Si el problema persiste, contacta al administrador del sistema.</p>
                <a href="{{ url('/') }}" class="btn btn-primary mt-3">Volver al Inicio</a>
            </div>
        </div>
    </div>
</body>
</html>
