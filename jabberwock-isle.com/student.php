<?php
include_once('header.php');
?>
<style>
.giftItem {
    padding: .25rem .5rem;
    font-size: .875rem;
    line-height: 1.5;
    border-radius: .2rem;
    margin: 0.5rem;
}
.gifttypea-love {
    border: 1px solid #FE2181;
    background-color: #f6d6e9;
}
.gifttypeb-like {
    border: 1px solid #8bd586;
    background-color: #c0f2bc;
}
.gifttypec-dislike {
    border: 1px solid #78909c;
    background-color: #cfd8dc;
}
.giftItem img {
    height: 50px;
}
</style>
<div class="container-fluid">
    <h1 class="text-center">Students</h1>
    <?php
    if (isset($_GET['sid'])) {
        $studentownersql = mysqli_query($conn, "SELECT ownerid FROM students WHERE studentid=".$_GET['sid'].";");
        $studentownerrow = mysqli_fetch_assoc($studentownersql);
        $editFlag = False;
        if ((isset($_SESSION['user'])) && ($studentownerrow['ownerid'] == $_SESSION['user']->getID())) {
            $editFlag = True;
        }

        $studentsql = mysqli_query($conn, "SELECT * FROM students WHERE studentid=".$_GET['sid'].";");
        $studentsqlrow = mysqli_fetch_assoc($studentsql);
        echo $studentsqlrow['studentname']."<br><img src='studentsprites/originalsprites/".$studentsqlrow['studentsprite']."'><br>";
    ?>
    <?php if ($editFlag) { ?>
        <a class="btn btn-primary btn-sm" href="javascript:void(0)" data-toggle="modal" data-target="#addWishlistItemModal"><i class="fas fa-plus"></i> Add Item to Wishlist</a>
    <?php } ?>
    <?php
        $wishlistsql = "SELECT * FROM studentwishlist LEFT JOIN items ON items.itemid=studentwishlist.itemid WHERE studentid=".$_GET['sid']." ORDER BY studentwishlist.desire;";
        $result = mysqli_query($conn, $wishlistsql);
        $count = 0;
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) { ?>
                <div id="giftItem<?php echo $count; ?>" class="giftItem gifttype<?php echo $row['desire']; ?> horizontalFlex">
                    <div>
                        <img src="<?php echo $row['itemimage']; ?>">
                        <?php echo $row['itemname']; ?> (<?php echo ucwords(substr($row['desire'],2)); ?>)
                    </div>
                    <?php if ($editFlag) { ?>
                        <div>
                            <button id="giftRemove<?php echo $count; ?>" class="btn btn-danger btn-sm" onclick="deleteWishlistItem(this.id,<?php echo $row['itemid']; ?>,<?php echo $row['studentid']; ?>)"><i class="far fa-trash-alt"></i></button>
                        </div>
                    <?php } ?>
                </div>
      <?    $count += 1;
            }
        }
    } else { ?>
        <div class="card">
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Monocoins</th>
                        <th>App</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM students ORDER BY studentname;";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><img src="studentsprites/originalsprites/<?php echo $row['studentsprite']; ?>"> <?php echo $row['studentname']; ?></td>
                                <td><?php echo $row['monocoins']; ?></td>
                                <td><a target="_blank" href="<?php echo $row['studentapp']; ?>"><?php echo $row['studentapp']; ?></a></td>
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

<?php if ($editFlag) { ?>
    <div class="modal fade" id="addWishlistItemModal" tabindex="-1" role="dialog" aria-labelledby="addWishlistItemModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addWishlistItemModalLabel">Modify/Add Item to Wishlist</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Modifying an item will be the same as adding it: simply select the item in this modal and it'll update the student's desire level.</p>
                    <select id="selectGiftItem">
                        <?php
                            $selectgiftsql = "SELECT itemid,itemname FROM items WHERE type='a-gift' ORDER BY itemname;";
                            $selectgiftresult = mysqli_query($conn, $selectgiftsql);
                            if (mysqli_num_rows($selectgiftresult) > 0) {
                                while ($selectgiftrow = mysqli_fetch_assoc($selectgiftresult)) {
                                    echo "<option value='".$selectgiftrow['itemid']."'>".$selectgiftrow['itemname']."</option>";
                                }
                            }
                        ?>
                    </select>
                    <span id="selectGiftStudent" style="display: none"><?php echo $_GET['sid']; ?></span>
                    <select id="selectGiftDesire">
                        <option value="a-love">Love</option>
                        <option value="b-like">Like</option>
                        <option value="c-dislike">Dislike</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button id="addWishlistItemConfirm" class="btn btn-danger">Add Item</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    function deleteWishlistItem(giftremoveid, i_itemid, i_studentid) {
        $.post("deleteWishlistItem.php", {
            itemid: i_itemid,
            studentid: i_studentid
        }, function(result) {
            $("#"+giftremoveid.replace("giftRemove","giftItem")).slideUp();
        });
    }
    $("#addWishlistItemConfirm").click(function() {
        $.post("modifyWishlistItem.php", {
            itemid: $("#selectGiftItem").val(),
            studentid: $("#selectGiftStudent").text(),
            desire: $("#selectGiftDesire").val(),
        }, function(result) {
            location.reload();
        });
    });
    </script>
<?php } ?>

<?php
include_once('footer.php');
?>
