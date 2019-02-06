<?php
include_once('header.php');
?>
<?php
function getStudents($itemid, $affinity) {
    global $conn;
    $affinityType = "";
    if ($affinity == "Love") {
        $affinityType = "a-love";
    } else if ($affinity == "Like") {
        $affinityType = "b-like";
    } else if ($affinity == "Dislike") {
        $affinityType = "c-dislike";
    }
    $affinitysql = "SELECT students.studentid, students.studentsprite, students.studentname FROM studentwishlist LEFT JOIN students ON students.studentid=studentwishlist.studentid WHERE studentwishlist.itemid=".$itemid." AND studentwishlist.desire='".$affinityType."';";
    $affinityresult = mysqli_query($conn, $affinitysql);
    if (mysqli_num_rows($affinityresult) > 0) {
        echo '<tr><td class="shopCardTableHeader shopCardTableHeader'.$affinity.'">'.$affinity.'</td><td class="shopCardTableRow'.$affinity.'">';
        while ($affinityrow = mysqli_fetch_assoc($affinityresult)) {
            echo "<img src='".$affinityrow['studentsprite']."'> <a target='_blank' href='https://adoptapedia.com/Jabberwock/student.php?sid=".$affinityrow['studentid']."'>".$affinityrow['studentname']."</a> ";
        }
        echo '</td></tr>';
    }
}

$maxCoins = 0;
if (isset($_SESSION['user'])) {
    $studentCoins = array();
    $sql = "SELECT * FROM students WHERE ownerid=".$_SESSION['user']->getID().";";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($studentCoins, array($row['monocoins'],$row['studentid'],$row['studentname']));
            if ($row['monocoins'] > $maxCoins) {
                $maxCoins = $row['monocoins'];
            }
        }
    }
}
?>
<style>
.shopCard {
    margin: 5px;
    background-color: #D6FCE5;
    border: 1px dotted #17a0ef;
    text-align: center;
}
.shopCardBody {
    padding: 10px;
}
.shopCardTable {
    box-sizing: border-box;
    width: 100%;
}
.shopCardTable td {
    border-top: 1px dotted #17a0ef;
}
.shopCardTableHeader {
    width: 60px;
}
.shopCardTableHeaderLove {
    background-color: #FE2181;
    color: #FFF;
    font-weight: bold;
}
.shopCardTableRowLove {
    background-color: #f6d6e9;
}
.shopCardTableHeaderLike {
    background-color: #8bd586;
    color: #FFF;
    font-weight: bold;
}
.shopCardTableRowLike {
    background-color: #c0f2bc;
}
.shopCardTableHeaderDislike {
    background-color: #78909c;
    color: #FFF;
    font-weight: bold;
}
.shopCardTableRowDislike {
    background-color: #cfd8dc;
}
</style>
<div class="container-fluid">
    <h1 class="text-center">Shop</h1>
    <div class="row">
        <?php
            $sql = "SELECT * FROM shop LEFT JOIN items ON shop.itemid=items.itemid ORDER BY shop.shopid;";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="col-md-4 col-sm-6">
                        <div class="shopCard">
                            <div class="shopCardBody">
                                <img id="purchaseGift<?php echo $row['itemid']; ?>img" class="shopImage" src="<?php echo $row['itemimage']; ?>">
                                <p id="purchaseGift<?php echo $row['itemid']; ?>itemname"><b><?php echo str_pad($row['shopid'], 3, '0', STR_PAD_LEFT); ?>. <?php echo $row['itemname']; ?> (<?php echo $row['itemcost']; ?> <img src="https://orig00.deviantart.net/910f/f/2018/105/6/6/mbc2_by_bootsii-dc8xg2k.png">)</b></p>
                                <p><?php echo $row['shopdescription']; ?></p>
                                <?php
                                if ($maxCoins >= $row['itemcost']) {
                                    echo '<a id="purchaseGift'.$row['itemid'].'" class="purchaseGiftTrigger" href="javascript:void(0)" data-toggle="modal" data-target="#purchaseGiftModal"><button class="btn btn-success">Purchase</button></a>';
                                }
                                ?>
                            </div>
                            <table class="shopCardTable">
                                <tbody>
                                    <?php getStudents($row['itemid'], "Love"); ?>
                                    <?php getStudents($row['itemid'], "Like"); ?>
                                    <?php getStudents($row['itemid'], "Dislike"); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
        <?      }
            }
        ?>
    </div>
</div>

<div class="modal fade" id="purchaseGiftModal" tabindex="-1" role="dialog" aria-labelledby="purchaseGiftModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="purchaseGiftModalLabel">Purchase Gift</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                    <div id="purchaseGiftModal_giftImg" class="giftModalImg"></div>
                    <span id="purchaseGiftModal_giftid" style="display: none"></span>
                    <p><b id="purchaseGiftModal_itemname"></b></p>
            </div>
            <p>Dropdown for who's purchasing</p>
            <p>Dropdown for who's receiving</p>
            <p>TextArea for note</p>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button id="purchaseGiftConfirm" class="btn btn-success">Purchase Gift</button>
            </div>
        </div>
    </div>
</div>

<script>
$(".purchaseGiftTrigger").click(function() {
    var currGift = $(this).attr("id");
    console.log(currGift);
    $("#purchaseGiftModal_giftid").text(currGift);
    $("#purchaseGiftModal_itemname").html($("#"+currGift+"itemname").html());
    $("#purchaseGiftModal_giftImg").css("background-image","url("+$("#"+currGift+"img").prop("src")+")");
});
$("#purchaseGiftConfirm").click(function() {
    alert("sup");
    /*
    if ($("#newGiftNote").val().length <= 140) {
        $.post("editGiftNote.php", {
            giftid: $("#editGiftModal_giftid").text(),
            studentid: $("#changeGiftStudent").val(),
            newgiftnote: $("#newGiftNote").val()
        }, function(result) {
            location.reload();
        });
    }
    */
});
</script>

<?php
include_once('footer.php');
?>
