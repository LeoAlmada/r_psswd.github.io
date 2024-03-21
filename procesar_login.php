<?php
include('database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = connect();
    if ($conn) {
        $sql = "SELECT password FROM users WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stored_password = $row['password'];

            $password_md5 = md5($password);

            if ($stored_password === $password_md5) {
                header("Location: home.html");
                exit();
            } else {
                header("refresh:0; url=index.html");
                $mensaje = "Usuario y/o contraseña incorrectos";
?>
                <script>
                    alert("<?php echo $mensaje; ?>");
                </script>

            <?php
            }
        } else {
            header("refresh:0; url=index.html");
            $mensaje = "Usuario y/o contraseña incorrectos";
            ?>
            <script>
                alert("<?php echo $mensaje; ?>");
            </script>

<?php
        }
    } else {
        die("Error al conectar con la base de datos");
    }
} else {
    header("Location: index.html");
    exit();
}
