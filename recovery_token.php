<?php
include("database.php");

$token_verified = false;
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    $entered_token = $_POST['token'];


    $conn = connect();
    $stmt = $conn->prepare("SELECT email FROM users WHERE token = ?");
    $stmt->bind_param("s", $entered_token);
    $stmt->execute();
    $stmt->store_result();


    if ($stmt->num_rows > 0) {
        $token_verified = true;

        $stmt->bind_result($email);
        $stmt->fetch();


        header("Location: change_pass.php?email=" . urlencode($email));
        exit();
    } else {
        $error_message = "El TOKEN ingresado no es válido. Intenta nuevamente";
    }
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
        <center><h1>Validación de TOKEN</h1></center>
        <?php if (!$token_verified) { ?>
            <form action="" method="post">
                <div class="form-group">
                    <input type="text" id="token" name="token" placeholder="Pega tu TOKEN aquí" required>
                    <span class="icon"><i class="fa fa-key"></i></span>
                </div>
                <div>
                    <button type="submit" name="submit">Verificar Token</button>
                </div>
            </form>
            <?php if (!empty($error_message)) {
                echo "<p>$error_message</p>";
            } ?>
        <?php } ?>
    </div>
</body>

</html>