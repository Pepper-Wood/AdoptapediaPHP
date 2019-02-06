<?php
include_once('header.php');
include_once('HIDDEN/DB_CONNECTIONS.php');
$conn = OpenMainCon();
?>
<style>
.card .card-image {
    overflow: hidden;
    -webkit-transform-style: preserve-3d;
    -moz-transform-style: preserve-3d;
    -ms-transform-style: preserve-3d;
    -o-transform-style: preserve-3d;
    transform-style: preserve-3d;
}
.fixedHeightImg200 {
    height: 200px;
    width: 100%;
    object-fit: contain;
}
.card {
    margin-top: 10px;
    position: relative;
    -webkit-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    -moz-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    box-shadow: 4 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
}
.card .card-reveal {
    padding: 20px;
    position: absolute;
    background-color: rgba(255,255,255,0.7);
    width: 100%;
    overflow-y: auto;
    left: 0;
    bottom: 0;
    height: 100%;
    z-index: 1;
    display: none;
}
</style>

<section class="jumbotron text-center">
    <div class="container">
        <h1 class="jumbotron-heading">Album example</h1>
        <p class="lead text-muted">Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don't simply skip over it entirely.</p>
        <?php if (isset($_SESSION['user']) && $_SESSION['user']->getType() == 'admin') { ?>
        <p>
            <button type="button" class="btn btn-primary  my-2" data-toggle="modal" data-target="#addTradeListing">Add Trade Listing</button>
            <button type="button" class="btn btn-secondary  my-2" data-toggle="modal" data-target="#addNewSpecies">Add Species</button>
        </p>
        <?php } ?>
    </div>
</section>

<div class="album py-5 bg-light">
    <div class="container">
        <div class="row">
            <?php
            $sql = "SELECT * FROM speciestrades LEFT JOIN species ON speciestrades.speciesid=species.speciesid;";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $i = 0;
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="col-md-3 col-sm-6">
                        <div class="card shadow-sm">
                            <div class="card-image">
                                <img class="fixedHeightImg200" src="<?php echo $row['characterimg']; ?>">
                            </div>
                            <div class="card-content">
                                <div class="horizontalFlex">
                                    <div>
                                        <span class='badge badge-light'><?php echo $row['speciesname']; ?></span>
                                        <?php
                                        if ($row['tradetypeid'] == 1) {
                                            echo "<span class='badge badge-primary'>Trade</span> ";
                                        } else if ($row['tradetypeid'] == 2) {
                                            echo "<span class='badge badge-success'>$</span> ";
                                        } else if ($row['tradetypeid'] == 3) {
                                            echo "<span class='badge badge-primary'>Trade</span> <span class='badge badge-success'>$</span> ";
                                        }
                                        ?>
                                    </div>
                                    <button type="button" id="showTradeCard<?php echo $i; ?>" class="btn btn-default showTradeCard">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                </div>
                            </div>
                            <div id="cardReveal<?php echo $i; ?>" class="card-reveal">
                                <div class="horizontalFlex">
                                    <span class="card-title">Card Title</span>
                                    <button type="button" id="closeTradeCard<?php echo $i; ?>" class="btn btn-default closeTradeCard">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <p><a target="_blank" href="<?php echo $row['journallink']; ?>">Go to Listing</a></p>
                                <p><b>Seeking</b></p>
                                <p><?php echo $row['seekingtext']; ?></p>
                            </div>
                        </div>
                    </div>
            <?php
                    $i++;
                }
            }
            ?>
        </div>
    </div>
</div>

<script>
$(".showTradeCard").click(function() {
    var cardRevealID = "#cardReveal" + $(this).attr("id").replace("showTradeCard","");
    $(cardRevealID).slideToggle(300);
});
$(".closeTradeCard").click(function() {
    var cardRevealID = "#cardReveal" + $(this).attr("id").replace("closeTradeCard","");
    $(cardRevealID).slideToggle(300);
});
</script>

<?php
include_once('footer.php');
CloseCon($conn);
?>
