<?php
include("database.php");


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['email'])) {

    $email = $_GET['email'];


    $conn = connect();
    $stmt = $conn->prepare("SELECT token FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();


    if ($stmt->num_rows > 0) {

        $stmt->bind_result($token);
        $stmt->fetch();
    } else {

        header("Location: rec_cont.php");
        exit();
    }
} else {

    header("Location: rec_cont.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 4</title>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>
    <div class="container mt-5">
        <center>
            <h1>Recuperación de contraseña</h1>
            <br>
            <h3>Tu TOKEN: <?php echo $token; ?></h3>
            <br>
            <p>Copiar y pegar TOKEN en el formulario para cambiar la contraseña.</p>
            <a type="button" href="recovery_token.php"><b>Continuar</b></a>
        </center>
    </div>
</body>

</html>