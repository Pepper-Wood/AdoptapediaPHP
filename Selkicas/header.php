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
    <title>Selkicas</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
    <style>
    * {
        box-sizing: border-box;
    }
    html {
        position: relative;
        min-height: 100%;
        padding: 0;
        margin: 0;
    }
    body {
        height: 100%;
        padding: 0;
        margin: 0;
        font-size: 16px;
        overflow-x: hidden;
        background-color: #f2f7fa;
    }
    h1, h2, h3, h4, h5 {
        font-family: 'Lobster', cursive;
    }
    #wrapper {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
    }
    #wrapper #content-wrapper {
        overflow-x: hidden;
        width: 100%;
        padding-bottom: 80px;
    }
    .fullWidth {
        width: 100%;
    }
    .scroll-to-top {
        position: fixed;
        right: 15px;
        bottom: 15px;
        display: none;
        width: 50px;
        height: 50px;
        text-align: center;
        color: #fff;
        background: rgba(52, 58, 64, 0.5);
        line-height: 46px;
    }
    .scroll-to-top:focus, .scroll-to-top:hover {
        color: white;
    }
    .scroll-to-top:hover {
        background: #343a40;
    }
    .scroll-to-top i {
        font-weight: 800;
    }
    .smaller {
        font-size: 0.7rem;
    }
    .o-hidden {
        overflow: hidden !important;
    }
    .z-0 {
        z-index: 0;
    }
    .z-1 {
        z-index: 1;
    }
    .navbar-nav .form-inline .input-group {
        width: 100%;
    }
    .navbar-nav .nav-item.active .nav-link {
        color: #fff;
    }
    .navbar-nav .nav-item.dropdown .dropdown-toggle::after {
        width: 1rem;
        text-align: center;
        float: right;
        vertical-align: 0;
        border: 0;
        font-weight: 900;
        content: '\f105';
        font-family: 'Font Awesome 5 Free';
    }
    .navbar-nav .nav-item.dropdown.show .dropdown-toggle::after {
        content: '\f107';
    }
    .navbar-nav .nav-item.dropdown.no-arrow .dropdown-toggle::after {
        display: none;
    }
    .navbar-nav .nav-item .nav-link:focus {
        outline: none;
    }
    .navbar-nav .nav-item .nav-link .badge {
        position: absolute;
        top: 0;
        right: 0;
        font-weight: 400;
        font-size: 0.65rem;
    }
    @media (min-width: 768px) {
        .navbar-nav .form-inline .input-group {
            width: auto;
        }
    }
    .sidebar {
        width: 60px;
        background-color: #212529;
        min-height: calc(100vh - 56px);
    }
    .sidebar .nav-item:last-child {
        margin-bottom: 1rem;
    }
    .sidebar .nav-item .nav-link {
        text-align: center;
        padding: 0.75rem 1rem;
        width: 90px;
    }
    .sidebar .nav-item .nav-link span {
        font-size: 0.65rem;
        display: block;
    }
    .sidebar .nav-item .nav-link {
        color: rgba(255, 255, 255, 0.5);
    }
    .sidebar .nav-item .nav-link:active, .sidebar .nav-item .nav-link:focus, .sidebar .nav-item .nav-link:hover {
        color: rgba(255, 255, 255, 0.75);
    }
    .card-body-icon {
        position: absolute;
        z-index: 0;
        top: -1.25rem;
        right: -1rem;
        opacity: 0.4;
        font-size: 5rem;
        -webkit-transform: rotate(15deg);
        transform: rotate(15deg);
    }
    @media (min-width: 576px) {
        .card-columns {
            -webkit-column-count: 1;
            column-count: 1;
        }
    }
    @media (min-width: 768px) {
        .card-columns {
            -webkit-column-count: 2;
            column-count: 2;
        }
    }
    @media (min-width: 1200px) {
        .card-columns {
            -webkit-column-count: 2;
            column-count: 2;
        }
    }
    :root {
        --input-padding-x: 0.75rem;
        --input-padding-y: 0.75rem;
    }
    .card-login {
        max-width: 25rem;
    }
    .card-register {
        max-width: 40rem;
    }
    .form-label-group {
        position: relative;
    }
    .form-label-group > input, .form-label-group > label {
        padding: var(--input-padding-y) var(--input-padding-x);
        height: auto;
    }
    .form-label-group > label {
        position: absolute;
        top: 0;
        left: 0;
        display: block;
        width: 100%;
        margin-bottom: 0;
        line-height: 1.5;
        color: #495057;
        border: 1px solid transparent;
        border-radius: 0.25rem;
        -webkit-transition: all 0.1s ease-in-out;
        transition: all 0.1s ease-in-out;
    }
    .form-label-group input::-webkit-input-placeholder {
        color: transparent;
    }
    .form-label-group input:-ms-input-placeholder {
        color: transparent;
    }
    .form-label-group input::-ms-input-placeholder {
        color: transparent;
    }
    .form-label-group input::placeholder {
        color: transparent;
    }
    .form-label-group input:not(:placeholder-shown) {
        padding-top: calc(var(--input-padding-y) + var(--input-padding-y) * (2 / 3));
        padding-bottom: calc(var(--input-padding-y) / 3);
    }
    .form-label-group input:not(:placeholder-shown) ~ label {
        padding-top: calc(var(--input-padding-y) / 3);
        padding-bottom: calc(var(--input-padding-y) / 3);
        font-size: 12px;
        color: #777;
    }
    footer.sticky-footer {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        position: absolute;
        right: 0;
        bottom: 0;
        width: calc(100% - 90px);
        height: 80px;
        background-color: #e9ecef;
    }
    footer.sticky-footer .copyright {
        line-height: 1;
        font-size: 0.8rem;
    }
    @media (min-width: 768px) {
        footer.sticky-footer {
            width: calc(100% - 300px);
        }
    }
    body.sidebar-toggled footer.sticky-footer {
        width: 100%;
    }
    @media (min-width: 768px) {
        body.sidebar-toggled footer.sticky-footer {
            width: calc(100% - 90px);
        }
    }
    .table td, .table th {
        border-top: 0px;
    }
    .table-sm td {
        padding: 0;
    }
    .breadcrumb {
        align-items: center;
    }
    .table {
        margin-bottom: 0;
    }
    .card {
        margin-bottom: 1em;
        border: 0;
        box-shadow: 0 1px 1px 0 rgba(60,64,67,.08), 0 1px 3px 1px rgba(60,64,67,.16);
        transition: box-shadow 135ms cubic-bezier(.4,0,.2,1);
    }
    #wrapper {
        display: flex;
        overflow: hidden;
        height: 100vh;
        position: relative;
        width: 100%;
        backface-visibility: hidden;
        will-change: overflow;
    }
    .sidebar, #content-wrapper {
        height: auto;
        -webkit-overflow-scrolling: touch;
        -ms-overflow-style: none;
    }
    .sidebar::-webkit-scrollbar, #content-wrapper::-webkit-scrollbar  {
        display: none;
    }
    .chip {
        display: inline-block;
        padding: 10px;
        border-radius: 25px;
        background-color: #f1f1f1;
        margin: 1px;
    }
    .closebtn {
        padding-left: 10px;
        color: #888;
        cursor: pointer;
    }
    .closebtn:hover {
        color: #000;
    }
    .removeAssignment {
        float: right;
    }
    .studentAnchorTag {
        padding: 0.25em;
    }
    #fixedbutton {
        position: fixed;
        right: 24px;
        bottom: 45px;
        z-index: 997;
        width: 56px;
        height: 56px;
        line-height: 54px;
        font-size: 15px;
        color: #FFF;
        background-color: #f44336;
        text-align: center;
        border-radius: 50%;
        -webkit-box-shadow: 0 2px 2px 0 rgba(0,0,0,0.14), 0 3px 1px -2px rgba(0,0,0,0.12), 0 1px 5px 0 rgba(0,0,0,0.2);
        box-shadow: 0 2px 2px 0 rgba(0,0,0,0.14), 0 3px 1px -2px rgba(0,0,0,0.12), 0 1px 5px 0 rgba(0,0,0,0.2);
    }
    .inventorySectionTitle {
        padding: 0.3rem;
        border-bottom: 3px dotted #fe2180;
        margin-bottom: 0.5rem;
    }
    .horizontalFlex {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }
    .flexFill {
        flex-grow: 1;
    }
    .horizontalMargin>div {
        margin-left: 2px;
        margin-right: 2px;
    }
    .studentHeader {
        padding: .75rem 1rem;
        margin-bottom: 1rem;
        list-style: none;
        background-color: #e9ecef;
        border-radius: .25rem;
    }
    .studentButton {
        margin: 0 3px;
    }
    .shopImage {
        height: 60px;
    }
    .dropdown-menu {
        border-radius: 0;
    }
    #jabberwockSidebarHeaderImage {
        background-position-x: right;
        background-position-y: bottom;
        background-color: #FE2181;
        height: 60px;
    }
    #rightNavigationWrapper {
        height: 60px;
        background-color: #0270eb;
        border-bottom: 6px solid #FE2181;
        position: sticky;
        top: 0px;
        z-index: 2;
        background-position-x: left;
        background-position-y: bottom;
    }
    #rightNavigation {
        height: 54px;
        border-bottom: 1px solid #FFF;
        align-items: center;
    }
    .buffer {
        height: 10px;
    }
    #pageTitle {
        height: 50px;
        background-size: 1071px 50px;
        background-attachment: fixed;
        animation-name: bg;
        animation-duration: 15s;
        animation-timing-function: linear;
        animation-iteration-count: infinite;
    }
    @keyframes bg {
        from {background-position: 0 0;}
        to {background-position: -1071px 0;}
    }
    .message-textbody {
        display: flex;
        flex-direction: column;
    }
    .text-small {
        font-size: 0.6rem;
    }
    .successMessageDropdown, .successMessageDropdown:hover, .successMessageDropdown:active, .successMessageDropdown:focus {
        color: #155724;
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
    }
    .removeMessage {
        margin-left: 10px;
    }
    .badge-danger {
        color: #fff;
        background-color: #fe2180;
    }
    .giftIcon {
        display: inline-block;
        position: relative;
        width: 60px;
        height: 60px;
    }
    .dropdownChev {
        transform: rotate(0deg);
        transition: transform 100ms linear;
    }
    .dropdownChev.open {
        transform: rotate(90deg);
        transition: transform 100ms linear;
    }
    .sidebarItem {
        padding:  10px;
        color: rgba(255, 255, 255, 0.5);
        cursor: pointer;
    }
    .sidebarDropdown a {
        display: block;
        padding:  0.3rem 0.75rem;
        color: rgba(255, 255, 255, 0.5);
        transition: all 0.25s;
    }
    .sidebarLink {
        display: flex;
        align-items: center;
        color: rgba(255, 255, 255, 0.5);
        text-decoration: none;
        transition: all 0.25s;
    }
    .sidebarLink:active, .sidebarLink:focus, .sidebarLink:hover, .sidebarDropdown a:active, .sidebarDropdown a:focus, .sidebarDropdown a:hover {
        color: rgba(255, 255, 255, 0.75);
        text-decoration: none;
    }
    .sidebarItem.active {
        color: #212529;
        background-color: #f2f7fa;
    }
    .sidebarItem.active .sidebarLink {
        color: #212529;
        text-decoration: none;
    }
    .sidebarDivider {
        height: 0;
        margin: .5rem 0;
        overflow: hidden;
        border-top: 1px solid rgba(255, 255, 255, 0.4);
    }
    .sidebarDropdown {
        display: none;
        background-color: rgba(255, 255, 255, 0.2);
    }
    .sidebarScroll {
        overflow-y: scroll;
        width: 100%;
        height: calc(100vh - 60px);
    }
    .sidebarScroll::-webkit-scrollbar {
        width: 0px;
        background: transparent; /* make scrollbar transparent */
    }
    .toggledHideTitle {
        display: none;
    }
    #toTopBtn {
        display: none;
        position: fixed;
        right: 24px;
        bottom: 45px;
        z-index: 997;
        width: 56px;
        height: 56px;
        line-height: 54px;
        font-size: 15px;
        color: #FFF;
        background-color: #f44336;
        text-align: center;
        border-radius: 50%;
        -webkit-box-shadow: 0 2px 2px 0 rgba(0,0,0,0.14), 0 3px 1px -2px rgba(0,0,0,0.12), 0 1px 5px 0 rgba(0,0,0,0.2);
        box-shadow: 0 2px 2px 0 rgba(0,0,0,0.14), 0 3px 1px -2px rgba(0,0,0,0.12), 0 1px 5px 0 rgba(0,0,0,0.2);
    }
    #toTopBtn:hover {
        background-color: #555;
    }
    .signedOutFrontPageImageContainer {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
    }
    .signedOutFrontPage {
        width: 49%;
        height: 49%;
    }
    .bg-danger {
        background-color: #ff8d97 !important;
    }
    .scavengerLink {
        color: #0056b3;
        text-decoration: underline;
    }
    .sidebarIcon {
        width: 40px;
        height: 40px;
        object-fit: contain;
        line-height: 40px;
        text-align: center;
    }
    .sidebarText {
        width: 0px;
        overflow: hidden;
        margin: 0;
        white-space: normal;
    }
    .headerIcon {
        background-color: #0076eb !important;
        padding: .5rem !important;
        color: #FFF !important;
        width: 40px;
        height: 40px;
        text-align: center;
        margin-left: 5px;
        margin-right: 5px;
    }
    .giftRow {
        padding: 5px;
        transition: all 0.5s;
        display: inline-block;
        margin-bottom: 5px;
        width: 100%;
    }
    .giftEdit {
        opacity: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        align-items: center;
        transition: all 135ms;
    }
    .giftRow:hover .giftEdit {
        opacity: 1;
    }
    .giftCardTitleItem {
        padding: 0.5rem;
        border-bottom: 1px solid rgba(0,0,0,.1);
    }
    .giftCardTitle {
        margin: 0;
    }
    .giftImg>img {
        width: 60px;
        height: 60px;
        margin-right: 5px;
    }
    .giftModalImg {
        width: 60px;
        height: 60px;
        object-fit: contain;
        margin-right: 5px;
        background-size: 100%;
    }
    .giftInfo {
        display: flex;
        flex-direction: column;
    }
    .giftInfo>p {
        margin: 0;
        font-size: 12px;
    }
    </style>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body id="page-top">
<button id="toTopBtn" title="Go to top"><i class="fas fa-chevron-up"></i></button>

<div id="wrapper">
    <div id="sidebar" class="sidebar">
        <div id="jabberwockSidebarHeaderImage"></div>
        <div id="sidebarScroll" class="sidebarScroll">
            <div title="Home" class="sidebarItem<?php if (basename($_SERVER['SCRIPT_NAME']) == "index.php") { echo " active"; } ?>">
                <a class="sidebarLink" href="index.php"><i class="fas fa-home sidebarIcon"></i> <p class="sidebarText">Home</p></a>
            </div>
            <div title="Masterlist" class="sidebarItem<?php if (basename($_SERVER['SCRIPT_NAME']) == "masterlist.php") { echo " active"; } ?>">
                <a class="sidebarLink" href="masterlist.php"><i class="fas fa-briefcase sidebarIcon"></i> <p class="sidebarText">Masterlist</p></a>
            </div>
            <div title="Inventories" class="sidebarItem<?php if (basename($_SERVER['SCRIPT_NAME']) == "inventories.php") { echo " active"; } ?>">
                <a class="sidebarLink" href="inventories.php"><i class="fas fa-briefcase sidebarIcon"></i> <p class="sidebarText">Inventories</p></a>
            </div>
            <div title="Transaction Logs" class="sidebarItem<?php if (basename($_SERVER['SCRIPT_NAME']) == "transactionlogs.php") { echo " active"; } ?>">
                <a class="sidebarLink" href="transactionlogs.php"><i class="fas fa-newspaper sidebarIcon"></i> <p class="sidebarText">Transaction Logs</p></a>
            </div>
            <div title="Shop" class="sidebarItem<?php if (basename($_SERVER['SCRIPT_NAME']) == "shop.php") { echo " active"; } ?>">
                <a class="sidebarLink" href="shop.php"><i class="fas fa-coins sidebarIcon"></i> <p class="sidebarText">Shop</p></a>
            </div>
            <div title="Recipes" class="sidebarItem<?php if (basename($_SERVER['SCRIPT_NAME']) == "recipes.php") { echo " active"; } ?>">
                <a class="sidebarLink" href="recipes.php"><i class="fas fa-utensils sidebarIcon"></i> <p class="sidebarText">Recipes</p></a>
            </div>
            <div title="Points" class="sidebarItem<?php if (basename($_SERVER['SCRIPT_NAME']) == "points.php") { echo " active"; } ?>">
                <a class="sidebarLink" href="points.php"><i class="fas fa-chart-bar sidebarIcon"></i> <p class="sidebarText">Points</p></a>
            </div>
            <div title="Item Search" class="sidebarItem<?php if (basename($_SERVER['SCRIPT_NAME']) == "itemsearch.php") { echo " active"; } ?>">
                <a class="sidebarLink" href="itemsearch.php"><i class="fas fa-search sidebarIcon"></i> <p class="sidebarText">Item Search</p></a>
            </div>
        </div>
    </div>
    <div id="content-wrapper">
        <div id="rightNavigationWrapper">
            <div id="rightNavigation" class="horizontalFlex">
                <div>
                    <button class="btn btn-link btn-sm order-1 order-sm-0 headerIcon" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
                <div id="pageTitle" class="flexFill"></div>
                <ul class="navbar-nav ml-auto ml-md-0" style="flex-direction: row">
                    <?php if (!isset($_SESSION['user'])) { ?>
                        <li class="nav-item dropdown no-arrow mr-2"><a href="login.php" class="btn btn-success"><i class="fab fa-deviantart"></i> Login</a></li>
                    <?php } else {
                        $messagesql = "SELECT * FROM messages WHERE userid=".$_SESSION['user']->getID()." ORDER BY messageid desc;";
                        $messageresult = mysqli_query($conn, $messagesql);
                        $totalMessages = mysqli_num_rows($messageresult);
                        if ($totalMessages > 0) { ?>
                            <li id="messages" class="nav-item dropdown no-arrow mx-1">
                                <a class="nav-link dropdown-toggle headerIcon" href="javascript:void(0)" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class='fas fa-envelope fa-fw'></i><span id='totalMessages' class='badge badge-danger'><?php echo $totalMessages; ?></span>
                                </a>
                        <?php
                            $timezonesql = mysqli_query($conn, "SELECT timezone FROM siteusersettings WHERE userid=".$_SESSION['user']->getID().";");
                            $timezonerow = mysqli_fetch_assoc($timezonesql);
                            $usertimezone = $timezonerow['timezone'];
                            date_default_timezone_set($usertimezone);

                            $messagesql = "SELECT * FROM messages WHERE userid=".$_SESSION['user']->getID()." ORDER BY messagedate DESC LIMIT 5;";
                            $messageresult = mysqli_query($conn, $messagesql);
                            if (mysqli_num_rows($messageresult) > 0) {
                                echo "<ul id='messagesDropdown' class='dropdown-menu dropdown-menu-right' aria-labelledby='messagesDropdown'>";
                                while ($messagerow = mysqli_fetch_assoc($messageresult)) { ?>
                                    <li class="dropdown-item <?php echo $messagerow['type']; ?>MessageDropdown">
                                        <div id="messageid<?php echo $messagerow['messageid']; ?>" class="horizontalFlex">
                                            <div class="message-textbody">
                                                <div><?php echo $messagerow['messagetext']; ?></div>
                                                <div class="text-small"><?php echo date('M d h:i a',$messagerow['messagedate']); ?></div>
                                            </div>
                                        </div>
                                    </li>
                        <?php   }
                                echo "<li class='dropdown-item'><div class='horizontalFlex'><div><a href='messages.php'>View All (".$totalMessages.")</a></div><div id='clearAllMessages'><a href='javascript:void(0)'>Clear All</a></div></li>";
                                echo "</ul>";
                            }
                        } else { ?>
                            <li id="messages" class="nav-item no-arrow mx-1">
                                <a class="nav-link headerIcon" href="javascript:void(0)">
                                    <i class='fas fa-envelope fa-fw'></i>
                                </a>
                            </li>
                        <?php } ?>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle headerIcon" href="javascript:void(0)" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user-circle fa-fw"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="settings.php">Settings</a>
                                <?php if ($_SESSION['user']->getType() == "admin") { ?>
                                    <a class="dropdown-item" href="admin.php">Admin</a>
                                <?php } ?>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#logoutModal">Logout</a>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="buffer"></div>
<?php
CloseCon($conn);
?>
