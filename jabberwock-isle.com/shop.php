<?php
include_once('header.php');
?>
<div class="container-fluid">
    <h1 class="text-center">Shop</h1>
    <table class="table table-sm table-striped">
        <thead>
            <tr>
                <th scope="col">Image</th>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                <th scope="col">Recipe</th>
                <th scope="col">Love</th>
                <th scope="col">Like</th>
                <th scope="col">Dislike</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $sql = "SELECT * FROM shop LEFT JOIN items ON shop.itemid=items.itemid ORDER BY items.itemname;";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo '<img class="shopImage" src="'.$row['itemimage'].'">'; ?></td>
                            <td><?php echo $row['itemname']; ?></td>
                            <td><?php echo $row['itemcost'].' <img src="https://orig00.deviantart.net/910f/f/2018/105/6/6/mbc2_by_bootsii-dc8xg2k.png">'; ?></td>
                            <td>
                                <ul>
                                <?php
                                    $recipesql = "SELECT * FROM recipes LEFT JOIN items ON recipes.ingredientid=items.itemid WHERE recipeid=".$row['itemid'].";";
                                    $reciperesult = mysqli_query($conn, $recipesql);
                                    if (mysqli_num_rows($reciperesult) > 0) {
                                        while ($reciperow = mysqli_fetch_assoc($reciperesult)) {
                                            echo "<li>".$reciperow['ingredientquantity']." ".$reciperow['itemname']."</li>";
                                        }
                                    }
                                ?>
                                </ul>
                            </td>
                            <td>
                                <?php
                                    $lovesql = "SELECT * FROM studentwishlist LEFT JOIN students ON students.studentid=studentwishlist.studentid WHERE studentwishlist.itemid=".$row['itemid']." AND studentwishlist.desire='a-love';";
                                    $loveresult = mysqli_query($conn, $lovesql);
                                    if (mysqli_num_rows($loveresult) > 0) {
                                        while ($loverow = mysqli_fetch_assoc($loveresult)) {
                                            echo "<img src='studentsprites/originalsprites/".$loverow['studentsprite']."'>";
                                        }
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    $likesql = "SELECT * FROM studentwishlist LEFT JOIN students ON students.studentid=studentwishlist.studentid WHERE studentwishlist.itemid=".$row['itemid']." AND studentwishlist.desire='b-like';";
                                    $likeresult = mysqli_query($conn, $likesql);
                                    if (mysqli_num_rows($likeresult) > 0) {
                                        while ($likerow = mysqli_fetch_assoc($likeresult)) {
                                            echo "<img src='studentsprites/originalsprites/".$likerow['studentsprite']."'>";
                                        }
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    $dislikesql = "SELECT * FROM studentwishlist LEFT JOIN students ON students.studentid=studentwishlist.studentid WHERE studentwishlist.itemid=".$row['itemid']." AND studentwishlist.desire='c-dislike';";
                                    $dislikeresult = mysqli_query($conn, $dislikesql);
                                    if (mysqli_num_rows($dislikeresult) > 0) {
                                        while ($dislikerow = mysqli_fetch_assoc($dislikeresult)) {
                                            echo "<img src='studentsprites/originalsprites/".$dislikerow['studentsprite']."'>";
                                        }
                                    }
                                ?>
                            </td>
                        </tr>
            <?      }
                }
            ?>
        </tbody>
    </table>
</div>
<?php
include_once('footer.php');
?>
