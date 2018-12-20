</div>
</div>

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="logout.php">Logout</a>
            </div>
        </div>
    </div>
</div>

<script>
$("#sidebarToggle").click(function() {
    if ($("#sidebar").hasClass("toggled")) {
        $("#sidebar").css("width","60px");
        $(".sidebarText").css("width","0px");
        $("#sidebar").removeClass("toggled");
    } else {
        if ($(window).width() < 500) {
            $("#sidebar").css("width","0px");
            $(".sidebarText").css("width","0px");
            $("#sidebar").addClass("toggled");
        } else {
            $("#sidebar").css("width","200px");
            $(".sidebarText").css("width","130px");
            $("#sidebar").addClass("toggled");
        }
    }
});
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
    $(".sidebarDropdownToggle").click(function() {
        if ($(this).next().css("display") == "block") {
            $(this).find(".dropdownChev").removeClass("open");
            $(this).next().slideUp();
        } else {
            $(".sidebarDropdown").slideUp();
            $(".dropdownChev").removeClass("open");
            $(this).next().slideDown();
            $(this).find(".dropdownChev").addClass("open");
        }
    });
});
$("#content-wrapper").scroll(function() {
    if ($(this).scrollTop() > 100) {
        $("#toTopBtn").fadeIn();
    } else {
        $("#toTopBtn").hide();
    }
});
$("#toTopBtn").click(function() {
    $("#content-wrapper").scrollTop(0);
});
</script>
</body>
</html>
