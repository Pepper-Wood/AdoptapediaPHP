<?php
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenOofooCon();

$target_dir = "../images/items/";
$target_file = $target_dir . basename($_FILES["itemimage"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["itemimage"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        header('Location: https://adoptapedia.com/oofoos/admin.php?action=addItemImageError&error=notAnImage');
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    header('Location: https://adoptapedia.com/oofoos/admin.php?action=addItemImageError&error=fileExists');
    $uploadOk = 0;
}
// Check file size
if ($_FILES["itemimage"]["size"] > 500000) {
    header('Location: https://adoptapedia.com/oofoos/admin.php?action=addItemImageError&error=tooLarge');
    $uploadOk = 0;
}
// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    header('Location: https://adoptapedia.com/oofoos/admin.php?action=addItemImageError&error=incorrectType');
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 1) {
    $temp = explode(".", $_FILES["file"]["name"]);
    $newfilename = round(microtime(true)) . '.' . end($temp);
    if (move_uploaded_file($_FILES["itemimage"]["tmp_name"], $target_dir.$newfilename.$imageFileType)) {
        $maxidsql = "SELECT (max(itemid) + 1) AS maxid FROM items;";
        $maxid = mysqli_fetch_array($conn->query($maxidsql))['maxid'];

        $sql = "INSERT INTO `items`(`itemid`, `name`, `img`, `artist`, `description`, `type`) VALUES (".$maxid.", '".$_POST["itemname"]."', '".$newfilename.$imageFileType."', '".$_POST["itemartist"]."', '".addslashes($_POST["itemdescription"])."', '".$_POST["itemtype"]."');";
        $result = mysqli_query($conn, $sql);

        header('Location: https://adoptapedia.com/oofoos/admin.php?action=addItem&name='.$_POST["itemname"]);
    } else {
        header('Location: https://adoptapedia.com/oofoos/admin.php?action=addItemImageError&error=uploadError');
    }
}
CloseCon($conn);
?>
