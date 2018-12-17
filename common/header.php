<?php
session_start();
function isUserAuthenticated()
{
    return isset($_SESSION["email"])
        && isset($_SESSION["first_name"])
        && isset($_SESSION["last_name"]);
}
function showAuthenticatedButtons()
{
    echo '<div class="nav-login">';
    echo '  <span class="user-name">' . $_SESSION['first_name'] . '&nbsp;' . $_SESSION['last_name'] . '&nbsp|&nbsp;</span>';
    echo ' <a href="settings.php"> <img src="img/Settings-icon.png" id = "set-icon" ></img></a> &nbsp|&nbsp;';
    echo '  <a href="logout.php"><img src="img/logout-icon.png" id = "set-icon" ></img></a>';
    echo '</div>';
}
function showNotAuthenticatedButtons()
{
    echo '<div class="nav-login">';
    echo '  <a href="login.php">Přihlásit</a>';
    echo '&nbsp;|&nbsp;';
    echo '  <a href="register.php">Zaregistrovat</a>';
    echo '</div>';
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Caltask</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
</head>
<body>

<header>
    <nav>
        <div class="main-wrapper">
            <ul>
                <li><a href="index.php">Caltask</a></li>
            </ul>
            <?php
            if (isUserAuthenticated()) {
                showAuthenticatedButtons();
            } else {
                showNotAuthenticatedButtons();
            }
            ?>
        </div>
    </nav>
</header>