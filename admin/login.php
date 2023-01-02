<?php
session_start();
if (isset($_POST['password'])) {
    $data = trim(strip_tags($_POST['password']));
    $_SESSION['password'] = $data;
    header('Location: index.php');
}

if (
    isset($_SERVER['HTTPS']) &&
    ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
    isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
    $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'
) {
    $protocol = 'https://';
} else {
    $protocol = 'http://';
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>

<body style="background-color: #1c1c1c;">


    <div class="d-flex justify-content-center">
        <p class="text-warning">Masukan kata sandi</p>
    </div>

    <form action="" method="post">
        <div class="d-flex justify-content-center">
            <input type="password" name="password" placeholder="Password" class="form-control col-lg-3" required>
            <input type="submit" class="btn btn-warning-outline ml-2">
        </div>
    </form>

</body>

</html>