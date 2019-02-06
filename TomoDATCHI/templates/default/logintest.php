<?php
require('../util/User.php');
session_start();
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenSelkicaCon();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/png" href="hibiscus.png"/>
    <title>Default Template</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
</head>
<body>

<div class="container">
<?php
if (!isset($_SESSION['user'])) {
    echo 'You are logged out<br>';
    echo '<a href="login.php" class="btn btn-lg btn-outline-light"><i class="fab fa-deviantart"></i> Login</a>';
} else {
    echo 'you are logged in as <b>'.$_SESSION['user']->getUsername().'</b>';
}
?>
</div>

</body>
</html>
<?php
CloseCon($conn);
?>
