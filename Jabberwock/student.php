<?php
include_once('header.php');
?>
<div class="container-fluid">
    <h1 class="text-center">Students</h1>
    <?php
    if (isset($_GET['sid'])) {
        $sql = "SELECT * FROM students WHERE studentid=".$_GET['sid'].";";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo $row['studentname']."<br><img src='".$row['studentsprite']."'><br>";
            }
        }
    } else { ?>
        <div class="card">
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>ID</th>
                        <th>App</th>
                        <th>Monocoins</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM students ORDER BY studentname;";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><img src="<?php echo $row['studentsprite']; ?>"> <?php echo $row['studentname']; ?></td>
                                <td><?php echo $row['studentid']; ?></td>
                                <td><a target="_blank" href="<?php echo $row['studentapp']; ?>"><?php echo $row['studentapp']; ?></a></td>
                                <td><?php echo $row['monocoins']; ?></td>
                            </tr>
                    <?  }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php
    }
    ?>
</div>

<?php
include_once('footer.php');
?>
