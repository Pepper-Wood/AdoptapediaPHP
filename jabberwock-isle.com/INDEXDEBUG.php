<?php
include_once('header.php');
?>

<?php
if (!isset($_SESSION['user'])) {
    include_once('index_loggedout.php');
} else if ($_SESSION['user']->getType() == "user") {
    echo '<div class="container-fluid">';
    include_once('index_loggedin_unauthorized.php');
    echo '</div>';
    include_once('footer.php');
} else if (($_SESSION['user']->getType() == "member") || ($_SESSION['user']->getType() == "admin")) {
    echo '<div class="container-fluid">';
    include_once('INDEX_LOGGEDIN_DEBUG.php');
    echo '</div>';
    include_once('footer.php');
}
?>
