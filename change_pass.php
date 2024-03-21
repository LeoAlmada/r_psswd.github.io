<?php
include("database.php");

$email = "";
$new_password = "";
$confirm_password = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $email = $_POST['email'];

    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $error_message = "Las contraseñas no coinciden. Intenta nuevamente.";
    } else {

        $hashed_password = md5($new_password);


        $new_token = generateToken();

        $conn = connect();
        $stmt = $conn->prepare("UPDATE users SET password = ?, token = ? WHERE email = ?");
        $stmt->bind_param("sss", $hashed_password, $new_token, $email);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {

            header("refresh:0; url=index.html");
            $mensaje = "Contraseña actualizada correctamente";
?>
            <script>
                alert("<?php echo $mensaje; ?>");
            </script>

<?php
        } else {
            $error_message = "Error al cambiar contraseña.";
        }

        $stmt->close();
        $conn->close();
    }
}

function generateToken()
{
    return md5(uniqid(mt_rand(), true));
}
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 4</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
    <div class="container mt-5">
        <h1>Cambiar Contraseña</h1>
        <form action="" method="post">
            <input type="hidden" name="email" value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">
            <div class="form-group">
                <input type="password" id="new_password" name="new_password" placeholder="Nueva contraseña" required>
                <span class="icon"><i class="fa fa-lock"></i></span>
            </div>
            <div class="form-group">
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirmar contraseña" required>
                <span class="icon"><i class="fa fa-lock"></i></span>
            </div>
            <div>
                <button type="submit" name="submit">Listo</button>
            </div>
            <?php if (!empty($error_message)) {
                echo "<p>$error_message</p>";
            } ?>
        </form>

    </div>
</body>

</html>