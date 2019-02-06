<?php
include_once('header.php');
?>
<div class="container-fluid">
    <?php
    if (isset($_SESSION['user'])) {
        $timezonesql = mysqli_query($conn, "SELECT timezone FROM siteusersettings WHERE userid=".$_SESSION['user']->getID().";");
        $timezonerow = mysqli_fetch_assoc($timezonesql);
        $usertimezone = $timezonerow['timezone'];
        date_default_timezone_set($usertimezone);

        $messagesql = "SELECT * FROM messages WHERE userid=".$_SESSION['user']->getID()." ORDER BY messagedate desc;";
        $messageresult = mysqli_query($conn, $messagesql);
        if (mysqli_num_rows($messageresult) > 0) {
            while ($messagerow = mysqli_fetch_assoc($messageresult)) {
                echo "<div id='messageid".$messagerow['messageid']."' class='alert alert-".$messagerow['type']." horizontalFlex'>";
                echo "<div class='message-textbody'>";
                echo "    <div>".$messagerow['messagetext']."</div>";
                echo "    <div class='text-small'>".date('M d h:i a',$messagerow['messagedate'])."</div>";
                echo "</div>";
                echo "<button id='removemessageid".$messagerow['messageid']."' class='removeMessage btn btn-outline-".$messagerow['type']."' style='border-radius:50%'><i class='fas fa-times'></i></button>";
                echo "</div>";
            }
        }
    }
    ?>
</div>

<script>
$(".removeMessage").click(function() {
    var messageID = $(this).attr("id").replace("removemessageid","");
    $("div#messageid" + messageID).hide();
    $.post("removemessage.php", {messageid: messageID}, function(result) {
        console.log(result);
        $("div#messageid" + messageID).hide();
    });
});
</script>

<?php
include_once('footer.php');
?>
