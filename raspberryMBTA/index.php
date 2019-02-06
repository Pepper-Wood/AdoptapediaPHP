<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SVG Raspberry MBTA</title>
    <link rel="icon" href="https://cdn.shopify.com/s/files/1/1816/1199/products/MBTA_T_Logo_Orange_MAGNET_grande.jpg?v=1494006642" type="image/png">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="mbta.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
</head>
<body>

<nav class="navbar">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-content" aria-expanded="false" aria-control="navbar-content">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/portal">
                <img src="https://d3044s2alrsxog.cloudfront.net/images/mbta-logo-t.png" alt="MBTA Logo"> Raspberry MBTA
            </a>
        </div>

<!--
        <div class="collapse navbar-collapse" id="navbar-content">
            <ul class="nav navbar-nav">
                <li><a href="/docs/swagger">Documentation</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/portal/account">dipippo.k@gmail.com</a></li>
                <li><form action="/portal/logout" class="button" method="post"><input name="_method" type="hidden" value="delete"><input name="_csrf_token" type="hidden" value="DyEnBilSMHVbIjsnLQM7ITkcPWQaAAAAGKqKPcv8jZqOKbJpUki//g=="><button class="nav-link-register" type="submit">Logout</button></form></li>
            </ul>
        </div>
    </div>
-->
</nav>

<div id="svgContainer">
    <svg id="theSVG" width="1536" height="1080">
        <polyline class="travelPath" points="25,200 75,175 925,175 975,200, 925,225 75,225, 25,200"/>
        <circle class="bubbleStop stop0"></circle>
        <circle class="bubbleStop stop1"></circle>
        <circle class="bubbleStop stop2"></circle>
        <circle class="bubbleStop stop3"></circle>
        <circle class="bubbleStop stop4"></circle>
        <circle class="bubbleStop stop5"></circle>
        <circle class="bubbleStop stop6"></circle>
        <circle class="bubbleStop stop7"></circle>
        <circle class="bubbleStop stop8"></circle>
        <circle class="bubbleStop stop9"></circle>
        <circle class="bubbleStop stop10"></circle>
        <circle class="bubbleStop stop11"></circle>
        <circle class="bubbleStop stop12"></circle>
        <circle class="bubbleStop stop13"></circle>
        <circle class="bubbleStop stop14"></circle>
        <circle class="bubbleStop stop15"></circle>
        <circle class="bubbleStop stop16"></circle>
        <circle class="bubbleStop stop17"></circle>
        <circle class="bubbleStop stop18"></circle>
        <circle class="bubbleStop stop19"></circle>
        <circle class="bubbleStop stop21"></circle>
        <circle class="bubbleStop stop22"></circle>
        <circle class="bubbleStop stop23"></circle>
        <circle class="bubbleStop stop24"></circle>
        <circle class="bubbleStop stop25"></circle>
        <circle class="bubbleStop stop26"></circle>
        <circle class="bubbleStop stop27"></circle>
        <circle class="bubbleStop stop28"></circle>
        <circle class="bubbleStop stop29"></circle>
        <circle class="bubbleStop stop30"></circle>
        <circle class="bubbleStop stop31"></circle>
        <circle class="bubbleStop stop32"></circle>
        <circle class="bubbleStop stop33"></circle>
        <circle class="bubbleStop stop34"></circle>
        <circle class="bubbleStop stop35"></circle>
        <circle class="bubbleStop stop36"></circle>
        <circle class="bubbleStop stop37"></circle>
        <circle class="bubbleStop stop38"></circle>
        <text class="rotateText stopName0">STOPNAME</text>
        <text class="rotateText stopName1">STOPNAME</text>
        <text class="rotateText stopName2">STOPNAME</text>
        <text class="rotateText stopName3">STOPNAME</text>
        <text class="rotateText stopName4">STOPNAME</text>
        <text class="rotateText stopName5">STOPNAME</text>
        <text class="rotateText stopName6">STOPNAME</text>
        <text class="rotateText stopName7">STOPNAME</text>
        <text class="rotateText stopName8">STOPNAME</text>
        <text class="rotateText stopName9">STOPNAME</text>
        <text class="rotateText stopName10">STOPNAME</text>
        <text class="rotateText stopName11">STOPNAME</text>
        <text class="rotateText stopName12">STOPNAME</text>
        <text class="rotateText stopName13">STOPNAME</text>
        <text class="rotateText stopName14">STOPNAME</text>
        <text class="rotateText stopName15">STOPNAME</text>
        <text class="rotateText stopName16">STOPNAME</text>
        <text class="rotateText stopName17">STOPNAME</text>
        <text class="rotateText stopName18">STOPNAME</text>
        <text class="rotateText stopName19">STOPNAME</text>
    </svg>
    <svg id="train" width="15" height="15">
        <circle class="trainBubble"></circle>
        <path id="trainOutline" d="M8.5,19 L8,20 L7,20 L7.5,19 L7.00247329,19 C6.44882258,19 6,18.5530501 6,17.9975592 L6,17.5024408 C6,16.948808 6,16.0488281 6,15.4932159 L6,7.00678414 C6,6.45075261 6.38567036,5.76271987 6.86301041,5.49531555 C6.86301041,5.49531555 9,4 12,4 C15,4 17.1369896,5.49531555 17.1369896,5.49531555 C17.6136171,5.77404508 18,6.45117188 18,7.00678414 L18,15.4932159 C18,16.0492474 18,16.9469499 18,17.5024408 L18,17.9975592 C18,18.551192 17.544239,19 16.9975267,19 L16.5,19 L17,20 L16,20 L15.5,19 L8.5,19 Z M9,7 C9,7.55613518 9.44358641,8 9.99077797,8 L14.009222,8 C14.5490248,8 15,7.55228475 15,7 C15,6.44386482 14.5564136,6 14.009222,6 L9.99077797,6 C9.45097518,6 9,6.44771525 9,7 Z M7.5,8 C7.77614237,8 8,7.77614237 8,7.5 C8,7.22385763 7.77614237,7 7.5,7 C7.22385763,7 7,7.22385763 7,7.5 C7,7.77614237 7.22385763,8 7.5,8 Z M16.5,8 C16.7761424,8 17,7.77614237 17,7.5 C17,7.22385763 16.7761424,7 16.5,7 C16.2238576,7 16,7.22385763 16,7.5 C16,7.77614237 16.2238576,8 16.5,8 Z M16,18 C16.5522847,18 17,17.5522847 17,17 C17,16.4477153 16.5522847,16 16,16 C15.4477153,16 15,16.4477153 15,17 C15,17.5522847 15.4477153,18 16,18 Z M8,18 C8.55228475,18 9,17.5522847 9,17 C9,16.4477153 8.55228475,16 8,16 C7.44771525,16 7,16.4477153 7,17 C7,17.5522847 7.44771525,18 8,18 Z M7,9.99077797 L7,14.009222 C7,14.5490248 7.44565467,15 7.99539757,15 L16.0046024,15 C16.5443356,15 17,14.5564136 17,14.009222 L17,9.99077797 C17,9.45097518 16.5543453,9 16.0046024,9 L7.99539757,9 C7.4556644,9 7,9.44358641 7,9.99077797 Z" id="Combined-Shape" fill="#1C1E23"></path>
    </svg>
</div>

<div class="container">
    <main role="main">
        <div style="margin: 32px 0; display: flex; align-items: center; justify-content: space-between">
            <h2 style="margin: 0">Orange Buddy - O-5455A0F8</h2>
            <!--<form action="/portal/keys" class="link" method="post" style="display: inline-block"><input name="_csrf_token" type="hidden" value="DyEnBilSMHVbIjsnLQM7ITkcPWQaAAAAGKqKPcv8jZqOKbJpUki//g=="><a class="btn btn-success" data-submit="parent" href="#" rel="nofollow">Request New Key</a></form>-->
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Current Status</th>
                    <th>StopID</th>
                    <th>Stop Name</th>
                </tr>
            </thead>
            <tbody id="output"></tbody>
        </table>
    </main>
</div>

<!--
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <p>© 2018 MBTA</p>
            </div>
            <div class="col-sm-3">
                <div class="footer-links">
                    <label>MBTA</label>
                    <ul>
                        <li><a href="https://www.mbta.com/">Home</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="footer-links">
                    <label>Developer</label>
                    <ul>
                        <li><a href="https://www.mbta.com/developers">MBTA Developers Page</a></li>
                        <li><a href="https://www.mass.gov/massdot-developers-data-sources">MassDOT Developers Page</a></li>
                        <li><a href="http://groups.google.com/group/massdotdevelopers">MassDOT/MBTA Google Group</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="footer-links">
                    <label>Portal</label>
                    <ul>
                        <li><a href="/login">Login</a></li>
                        <li><a href="/register">Register</a></li>
                        <li><a href="/docs/swagger">Docs</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
-->

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script>
var stopID;

/**
 * $.playSound() @author Alexander Manzyuk <admsev@gmail.com>
 * Copyright (c) 2012 Alexander Manzyuk - released under MIT License
 * https://github.com/admsev/jquery-play-sound
**/
(function ($) {
    $.extend({
        playSound: function () {
        return $(
            '<audio class="sound-player" autoplay="autoplay" style="display:none;">'
                + '<source src="' + arguments[0] + '" />'
                + '<embed src="' + arguments[0] + '" hidden="true" autostart="true" loop="false"/>'
                + '</audio>'
            ).appendTo('body');
        },
        stopSound: function () {
            $(".sound-player").remove();
        }
    });
})(jQuery);

var stops = [];
var stopNames = ["Oak Grove", "Malden Center", "Wellington", "Assembly", "Sullivan Square", "Community College", "North Station", "Haymarket", "State Street", "Downtown Crossing", "Chinatown", "Tufts Medical Center", "Back Bay", "Massachusetts Ave.", "Ruggles", "Roxbury Crossing", "Jackson Square", "Stony Brook", "Green Street", "Forest Hills"];
var R2LstopJSON = JSON.parse('[{"stopID":70001,"stopName":"Forest Hills Orange Line"},{"stopID":70003,"stopName":"Green Street - Inbound"},{"stopID":70005,"stopName":"Stony Brook - Inbound"},{"stopID":70007,"stopName":"Jackson Square - Inbound"},{"stopID":70009,"stopName":"Roxbury Crossing - Inbound"},{"stopID":70011,"stopName":"Ruggles - Inbound"},{"stopID":70013,"stopName":"Massachusetts Avenue - Inbound"},{"stopID":70015,"stopName":"Back Bay - Inbound"},{"stopID":70017,"stopName":"Tufts Medical Center - Inbound"},{"stopID":70019,"stopName":"Chinatown - Inbound"},{"stopID":70021,"stopName":"Downtown Crossing - to Oak Grove"},{"stopID":70023,"stopName":"State Street - to Oak Grove"},{"stopID":70025,"stopName":"Haymarket - Orange Line Outbound"},{"stopID":70027,"stopName":"North Station - Orange Line Outbound"},{"stopID":70029,"stopName":"Community College - Outbound"},{"stopID":70031,"stopName":"Sullivan Square - Outbound"},{"stopID":70279,"stopName":"Assembly - Outbound"},{"stopID":70033,"stopName":"Wellington - Outbound"},{"stopID":70035,"stopName":"Malden - Outbound"},{"stopID":70036,"stopName":"Oak Grove"}]');
R2LstopJSON = R2LstopJSON.reverse();
var L2RstopJSON = JSON.parse('[{"stopID":70036,"stopName":"Oak Grove"},{"stopID":70034,"stopName":"Malden - Inbound"},{"stopID":70032,"stopName":"Wellington - Inbound"},{"stopID":70278,"stopName":"Assembly - Inbound"},{"stopID":70030,"stopName":"Sullivan Square - Inbound"},{"stopID":70028,"stopName":"Community College - Inbound"},{"stopID":70026,"stopName":"North Station - Orange Line Inbound"},{"stopID":70024,"stopName":"Haymarket - Orange Line Inbound"},{"stopID":70022,"stopName":"State Street - to Forest Hills"},{"stopID":70020,"stopName":"Downtown Crossing - to Forest Hills"},{"stopID":70018,"stopName":"Chinatown - Outbound"},{"stopID":70016,"stopName":"Tufts Medical Center - Outbound"},{"stopID":70014,"stopName":"Back Bay - Outbound"},{"stopID":70012,"stopName":"Massachusetts Avenue - Outbound"},{"stopID":70010,"stopName":"Ruggles - Outbound"},{"stopID":70008,"stopName":"Roxbury Crossing - Outbound"},{"stopID":70006,"stopName":"Jackson Square - Outbound"},{"stopID":70004,"stopName":"Stony Brook - Outbound"},{"stopID":70002,"stopName":"Green Street - Outbound"},{"stopID":70001,"stopName":"Forest Hills Orange Line"}]');

var currentStatus = "";
var currentStopIndex = 0;

class Stop {
    constructor(stopName, stopID, stopX, stopY) {
        this.stopName = stopName;
        this.stopID = stopID;
        this.stopX = stopX;
        this.stopY = stopY;
        this.trainX = stopX-12;
        this.trainY = stopY-12;
    }
    get name() {
        return this.stopName;
    }
    get ID() {
        return this.stopID;
    }
    get x() {
        return this.trainX;
    }
    get y() {
        return this.trainY;
    }
}

$(document).ready(function() {
    start = 25;
    increment = 50;
    for (i=0; i<stopNames.length; i++) {
        if ((stopNames[i] == "Oak Grove") || (stopNames[i] == "Forest Hills")) {
            $(".stop"+i).css("transform","translate("+start+"px, 200px)");
            $(".stopName"+i).css("transform","translate("+(start+5)+"px, 185px) rotate(270deg)")
            $(".stopName"+i).text(stopNames[i]);
            stops[i] = new Stop(R2LstopJSON[i].stopName,R2LstopJSON[i].stopID,start,200);
        } else {
            $(".stop"+i).css("transform","translate("+start+"px, 175px)");
            $(".stop"+(i+stopNames.length)).css("transform","translate("+start+"px, 225px)");
            $(".stopName"+i).css("transform","translate("+(start+5)+"px, 160px) rotate(270deg)")
            $(".stopName"+i).text(stopNames[i]);
            stops[i] = new Stop(R2LstopJSON[i].stopName,R2LstopJSON[i].stopID,start,175);
            stops[i+stopNames.length-1] = new Stop(L2RstopJSON[i].stopName,L2RstopJSON[i].stopID,start,225);
        }
        start += increment;
    }
});

window.setInterval(function() {
    updateVehicle();
}, 5000);

function updateVehicle() {
    $.ajax({
        url: 'mbtaAPI.php',
        success: function(output) {
            var splitOutput = output.split("?");

            if (currentStatus != splitOutput[1]) {
                currentStopIndex = getStopIndex(stops, parseInt(splitOutput[2]));
                if (currentStatus == "") {
                    $("#train").css("-webkit-transform","translate(" + stops[currentStopIndex].x + "px, " + stops[currentStopIndex].y + "px)")
                    $("#train").css("-webkit-transition","-webkit-transform 10s ease-in-out");
                }
                currentStatus = splitOutput[1];
                $('#output').prepend("<tr><td>" + splitOutput[0] + "</td><td>" + splitOutput[1] + "</td><td>" + splitOutput[2] + "</td><td>" + stops[currentStopIndex].name + "</td></tr>");
                $("#train").css("-webkit-transform","translate(" + stops[currentStopIndex].x + "px, " + stops[currentStopIndex].y + "px)")
                if (currentStatus == "STOPPED_AT") {
                    $("#trainOutline").css("fill","#da291c");
                } else {
                    $("#trainOutline").css("fill","#1C1E23");
                }
                /**
                 * Desk-bell-sound-effect.mp3 @author Orange Free Sounds
                 * License: The sound effect is permitted for non-commercial use under license ìAttribution-NonCommercial 4.0 International (CC BY-NC 4.0)
                 * http://www.orangefreesounds.com/
                **/
                //$.playSound('Desk-bell-sound-effect.mp3');
            }
        }
    });
}

function getStopIndex(stops, targetStopID) {
    for (i=0; i<stops.length; i++) {
        if (stops[i].ID == targetStopID) {
            return i;
        }
    }
}

$('.circ2').click(function(e) {
    var path = document.querySelector('.travelPath');
    var length = path.getTotalLength();

    $(path).css({
        'stroke-dasharray': length+1,
        'stroke-dashoffset': length+1
    });

    $(path).animate({'stroke-dashoffset': 0}, 3000, mina.bounce);
});
</script>

</body>
</html>
