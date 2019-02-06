<?php
include '../HIDDEN/DB_CONNECTIONS.php';
?>
<html>

<table>
    <tbody>
    <?php
    $userid = 1;
    $addedUsers = array();
    $conn = OpenMainCon();

    $sql = "SELECT * FROM siteusers ORDER BY userid;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (!in_array($row['username'], $addedUsers)) {
                array_push($addedUsers,$row['username']);
                echo "INSERT INTO `globalsiteusers`(`userid`, `username`, `deviantartid`) VALUES (".$userid.",'".$row['username']."','".$row['deviantartid']."');<br>";
                echo "INSERT INTO `globallogins`(`userid`, `siteid`, `type`) VALUES (".$userid.",1,'".$row['type']."');";
                $userid++;
            }
        }
    }

    $conn = OpenOofooCon();

    $sql = "SELECT * FROM siteusers ORDER BY userid;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (!in_array($row['username'], $addedUsers)) {
                array_push($addedUsers,$row['username']);
                echo "INSERT INTO `globalsiteusers`(`userid`, `username`, `deviantartid`) VALUES (".$userid.",'".$row['username']."','".$row['deviantartid']."');<br>";
                echo "INSERT INTO `globallogins`(`userid`, `siteid`, `type`) VALUES (".$userid.",2,'".$row['type']."');";
                $userid++;
            }
        }
    }

    $conn = OpenJabberwockCon();

    $sql = "SELECT * FROM siteusers ORDER BY userid;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (!in_array($row['username'], $addedUsers)) {
                array_push($addedUsers,$row['username']);
                echo "INSERT INTO `globalsiteusers`(`userid`, `username`, `deviantartid`) VALUES (".$userid.",'".$row['username']."','".$row['deviantartid']."');<br>";
                echo "INSERT INTO `globallogins`(`userid`, `siteid`, `type`) VALUES (".$userid.",3,'".$row['type']."');<br>";
                $userid++;
            }
        }
    }

    $conn = OpenSelkicaCon();

    $sql = "SELECT * FROM siteusers ORDER BY userid;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (!in_array($row['username'], $addedUsers)) {
                array_push($addedUsers,$row['username']);
                echo "INSERT INTO `globalsiteusers`(`userid`, `username`, `deviantartid`) VALUES (".$userid.",'".$row['username']."','".$row['deviantartid']."');<br>";
                echo "INSERT INTO `globallogins`(`userid`, `siteid`, `type`) VALUES (".$userid.",4,'".$row['type']."');<br>";
                $userid++;
            }
        }
    }

    CloseCon();
    ?>
    </tbody>
</table>

</html>
