<?php
include_once('header.php');
?>
<style>
.eventCardInfo {
    padding: 5px;
}
.eventCardTitle {
    font-weight: bold;
    margin: 0;
}
.eventCardCountdown {
    margin: 0;
    font-size: 14px;
    color: rgba(0,0,0,0.5);
}
.eventCardText {
    margin: 0;
    font-size: 14px;
    color: rgba(0,0,0,0.8);
}
.clearLink {
    color: #000 !important;
    text-decoration: none !important;
}
.eventCard {
    transition: 0.5s all;
}
.eventCard:hover {
    cursor: pointer;
    -webkit-box-shadow: 0 4px 5px 0 rgba(0,0,0,0.14), 0 1px 10px 0 rgba(0,0,0,0.12), 0 2px 4px -1px rgba(0,0,0,0.3);
    box-shadow: 0 4px 5px 0 rgba(0,0,0,0.14), 0 1px 10px 0 rgba(0,0,0,0.12), 0 2px 4px -1px rgba(0,0,0,0.3);
}
</style>

<div class="container-fluid">
<div class="row">
    <div class="col-md-3">
        <a target="_blank" class="clearLink" href="https://www.deviantart.com/pacapillars/journal/Paca-Prompt-Hub-764236572">
            <div class="card eventCard">
                <img class="fullWidth eventCardImg" src="https://img00.deviantart.net/da97/i/2018/255/2/3/pwopts__by_nymbliss-dcmp18b.png">
                <div class="eventCardInfo">
                    <p class="eventCardTitle">Paca Prompts</p>
                    <p class="eventCardCountdown">13d 02:12:45</p>
                    <p class="eventCardText">It’s been so chilly lately! Sometimes we’d rather stay in all day.... What does your pacapillar do when they stay inside their cozy home?</p>
                </div>
            </div>
        </a>
        <a target="_blank" class="clearLink" href="https://www.deviantart.com/pacapillars/journal/Paca-Prompt-Hub-764236572">
            <div class="card eventCard">
                <img class="fullWidth eventCardImg" src="https://img00.deviantart.net/da97/i/2018/255/2/3/pwopts__by_nymbliss-dcmp18b.png">
                <div class="eventCardInfo">
                    <p class="eventCardTitle">Paca Prompts</p>
                    <p class="eventCardCountdown">13d 02:12:45</p>
                    <p class="eventCardText">It’s been so chilly lately! Sometimes we’d rather stay in all day.... What does your pacapillar do when they stay inside their cozy home?</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-9">
        <p>Specific User Information Goes here</p>
    </div>
</div>

<?php
include_once('footer.php');
?>
