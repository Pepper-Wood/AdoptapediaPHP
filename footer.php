</div>

<script>
$(function(){
$(".dropdown").hover(
        function() {
            $('.dropdown-menu', this).stop( true, true ).fadeIn("fast");
            $(this).toggleClass('open');
            $('b', this).toggleClass("caret caret-up");
        },
        function() {
            $('.dropdown-menu', this).stop( true, true ).fadeOut("fast");
            $(this).toggleClass('open');
            $('b', this).toggleClass("caret caret-up");
        });
});
</script>

<?php if (basename($_SERVER['SCRIPT_NAME']) == "speciestrades.php") { ?>
<div class="modal fade" id="addTradeListing" tabindex="-1" role="dialog" aria-labelledby="addTradeListingLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTradeListingLabel">Add Trade Listing</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                timestamp<br>
                journalllink<br>
                characterimg<br>
                speciesid<br>
                tradetypeid<br>
                seekingtext<br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Add Listing</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addNewSpecies" tabindex="-1" role="dialog" aria-labelledby="addNewSpeciesLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewSpeciesLabel">Add Trade Listing</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                speciesname<br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Add Listing</button>
            </div>
        </div>
    </div>
</div>
<?php } ?>

</body>
</html>
