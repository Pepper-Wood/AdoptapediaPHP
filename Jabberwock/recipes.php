<?php
include_once('header.php');
?>
<div class="container-fluid">
    <h1 class="text-center">Recipes</h1>
    <table class="table table-sm table-striped">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Recipe</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $sql ="SELECT DISTINCT recipes.recipeid, items.itemname FROM recipes LEFT JOIN items ON recipes.recipeid=items.itemid ORDER BY items.itemname;";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['itemname']; ?></td>
                            <td>
                                <ul>
                                <?php
                                    $recipesql = "SELECT * FROM recipes LEFT JOIN items ON recipes.ingredientid=items.itemid WHERE recipeid=".$row['recipeid'].";";
                                    $reciperesult = mysqli_query($conn, $recipesql);
                                    if (mysqli_num_rows($reciperesult) > 0) {
                                        while ($reciperow = mysqli_fetch_assoc($reciperesult)) {
                                            echo "<li>".$reciperow['ingredientquantity']." ".$reciperow['itemname']."</li>";
                                        }
                                    }
                                ?>
                                </ul>
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
