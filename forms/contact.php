<?php
// Mostrar errores para depuración (puedes quitar estas líneas en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// var_dump(error_get_last());


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre      = $_POST["nombre"] ?? '';
    $correo      = $_POST["correo"] ?? '';
    $telefono    = $_POST["telefono"] ?? '';
    $servicio    = $_POST["servicio"] ?? '';
    $marca       = $_POST["marca"] ?? '';
    $equipo      = $_POST["equipo"] ?? '';
    $mensaje     = $_POST["message"] ?? '';
    $remitente   = "contacto@siarsa.com.mx";
    $destino     = "sistemas@ce2000.mx";
    $asunto      = "Cotización / Contacto SIARSA";

    $cuerpo = "
    <html>
    <meta charset='UTF-8'>
    <body>
        <h3>Cliente: $nombre</h3>
        <h3>Correo: $correo</h3>
        <h3>Teléfono: $telefono</h3>
        <h3>Tipo de Servicio: $servicio</h3>
        <h3>Marca: $marca</h3>
        <h3>Equipo: $equipo</h3>
        <h3>Mensaje:</h3>
        <p>$mensaje</p>
        <hr>
        <p>Favor de ponerse en contacto lo antes posible.</p>

    </body>
    </html>
    ";

    $headers  = "From: ".$remitente."\r\n";
    $headers .= "Reply-To: $correo\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";

    // HTML mínimo para mostrar SweetAlert2
    echo '<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Enviando...</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>';

    if (mail($destino, $asunto, $cuerpo, $headers, "-f$remitente")) {
        echo '
        <script>
        Swal.fire({
            icon: "success",
            title: "¡Mensaje enviado!",
            text: "Su mensaje ha sido enviado correctamente, espere su confirmación.",
            confirmButtonText: "Aceptar"
        }).then(() => {
            window.location.href = "../index.html";
        });
        </script>
        ';
    } else {
        echo '
        <script>
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "No se pudo enviar el mensaje. Intente de nuevo más tarde.",
            confirmButtonText: "Aceptar"
        }).then(() => {
            window.history.back();
        });
        </script>
        ';
    }
    echo '</body></html>';
} else {
    header("Location: ../index.html");
    exit();
}
?>