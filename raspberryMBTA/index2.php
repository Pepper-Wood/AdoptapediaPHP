<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Grid SVG Raspberry MBTA</title>
    <link rel="icon" href="https://cdn.shopify.com/s/files/1/1816/1199/products/MBTA_T_Logo_Orange_MAGNET_grande.jpg?v=1494006642" type="image/png">

    <style>
    #svgContainer {
        width: 350px;
        height: 725px;
        background: #d6d6d6;
        position: relative;
    }
    .bubbleStop {
        fill: #ed8b00;
        stroke: #ed8b00;
        stroke-width: .125rem;
        r: 5;
    }
    #mbtaMap {
        position: absolute;
        background-color: #f1f1f1;
    }
    .trainBubble {
        fill: #fff;
        stroke: #1C1E23;
        stroke-width: 0.125rem;
        r: 11;
        cx: 12;
        cy: 12;
    }
    #train {
        position: absolute;
        -webkit-transform:translate(-100px,-100px);
    }
    </style>
</head>
<body>

<div id="svgContainer">
    <svg id="mbtaMap" width="1300" height="3000"></svg>
    <svg id="train" width="25" height="25">
        <circle class="trainBubble"></circle>
        <path id="trainOutline" d="M8.5,19 L8,20 L7,20 L7.5,19 L7.00247329,19 C6.44882258,19 6,18.5530501 6,17.9975592 L6,17.5024408 C6,16.948808 6,16.0488281 6,15.4932159 L6,7.00678414 C6,6.45075261 6.38567036,5.76271987 6.86301041,5.49531555 C6.86301041,5.49531555 9,4 12,4 C15,4 17.1369896,5.49531555 17.1369896,5.49531555 C17.6136171,5.77404508 18,6.45117188 18,7.00678414 L18,15.4932159 C18,16.0492474 18,16.9469499 18,17.5024408 L18,17.9975592 C18,18.551192 17.544239,19 16.9975267,19 L16.5,19 L17,20 L16,20 L15.5,19 L8.5,19 Z M9,7 C9,7.55613518 9.44358641,8 9.99077797,8 L14.009222,8 C14.5490248,8 15,7.55228475 15,7 C15,6.44386482 14.5564136,6 14.009222,6 L9.99077797,6 C9.45097518,6 9,6.44771525 9,7 Z M7.5,8 C7.77614237,8 8,7.77614237 8,7.5 C8,7.22385763 7.77614237,7 7.5,7 C7.22385763,7 7,7.22385763 7,7.5 C7,7.77614237 7.22385763,8 7.5,8 Z M16.5,8 C16.7761424,8 17,7.77614237 17,7.5 C17,7.22385763 16.7761424,7 16.5,7 C16.2238576,7 16,7.22385763 16,7.5 C16,7.77614237 16.2238576,8 16.5,8 Z M16,18 C16.5522847,18 17,17.5522847 17,17 C17,16.4477153 16.5522847,16 16,16 C15.4477153,16 15,16.4477153 15,17 C15,17.5522847 15.4477153,18 16,18 Z M8,18 C8.55228475,18 9,17.5522847 9,17 C9,16.4477153 8.55228475,16 8,16 C7.44771525,16 7,16.4477153 7,17 C7,17.5522847 7.44771525,18 8,18 Z M7,9.99077797 L7,14.009222 C7,14.5490248 7.44565467,15 7.99539757,15 L16.0046024,15 C16.5443356,15 17,14.5564136 17,14.009222 L17,9.99077797 C17,9.45097518 16.5543453,9 16.0046024,9 L7.99539757,9 C7.4556644,9 7,9.44358641 7,9.99077797 Z" id="Combined-Shape" fill="#1C1E23"></path>
    </svg>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script>
function makeSVG(tag, attrs) {
    var el= document.createElementNS('http://www.w3.org/2000/svg', tag);
    for (var k in attrs) {
        el.setAttribute(k, attrs[k]);
    }
    return el;
}

class Stop {
    constructor(stopID, stopName, stopX, stopY) {
        this.stopID = stopID;
        this.stopName = stopName;
        this.stopX = stopX;
        this.stopY = stopY;
    }
    get id() {
        return this.stopID;
    }
    get name() {
        return this.stopName;
    }
    get x() {
        return this.stopX;
    }
    get y() {
        return this.stopY;
    }
}

var stopJSON = JSON.parse('[{"stopID":70036,"stopName":"Oak Grove","longitude":-71.071097,"latitude":42.43668},{"stopID":70034,"stopName":"Malden - Inbound","longitude":-71.07411,"latitude":42.426632},{"stopID":70032,"stopName":"Wellington - Inbound","longitude":-71.077082,"latitude":42.40237},{"stopID":70278,"stopName":"Assembly - Inbound","longitude":-71.077257,"latitude":42.392811},{"stopID":70030,"stopName":"Sullivan Square - Inbound","longitude":-71.076994,"latitude":42.383975},{"stopID":70028,"stopName":"Community College - Inbound","longitude":-71.069533,"latitude":42.373622},{"stopID":70026,"stopName":"North Station - Orange Line Inbound","longitude":-71.06129,"latitude":42.365577},{"stopID":70024,"stopName":"Haymarket - Orange Line Inbound","longitude":-71.05829,"latitude":42.363021},{"stopID":70022,"stopName":"State Street - to Forest Hills","longitude":-71.057598,"latitude":42.358978},{"stopID":70020,"stopName":"Downtown Crossing - to Forest Hills","longitude":-71.060225,"latitude":42.355518},{"stopID":70018,"stopName":"Chinatown - Outbound","longitude":-71.062752,"latitude":42.352547},{"stopID":70016,"stopName":"Tufts Medical Center - Outbound","longitude":-71.063917,"latitude":42.349662},{"stopID":70014,"stopName":"Back Bay - Outbound","longitude":-71.075727,"latitude":42.34735},{"stopID":70012,"stopName":"Massachusetts Avenue - Outbound","longitude":-71.083423,"latitude":42.341512},{"stopID":70010,"stopName":"Ruggles - Outbound","longitude":-71.088961,"latitude":42.336377},{"stopID":70008,"stopName":"Roxbury Crossing - Outbound","longitude":-71.095451,"latitude":42.331397},{"stopID":70006,"stopName":"Jackson Square - Outbound","longitude":-71.099592,"latitude":42.323132},{"stopID":70004,"stopName":"Stony Brook - Outbound","longitude":-71.104248,"latitude":42.317062},{"stopID":70002,"stopName":"Green Street - Outbound","longitude":-71.107414,"latitude":42.310525},{"stopID":70001,"stopName":"Forest Hills Orange Line","longitude":-71.113686,"latitude":42.300523},{"stopID":70003,"stopName":"Green Street - Inbound","longitude":-71.107414,"latitude":42.310525},{"stopID":70005,"stopName":"Stony Brook - Inbound","longitude":-71.104248,"latitude":42.317062},{"stopID":70007,"stopName":"Jackson Square - Inbound","longitude":-71.099592,"latitude":42.323132},{"stopID":70009,"stopName":"Roxbury Crossing - Inbound","longitude":-71.095451,"latitude":42.331397},{"stopID":70011,"stopName":"Ruggles - Inbound","longitude":-71.088961,"latitude":42.336377},{"stopID":70013,"stopName":"Massachusetts Avenue - Inbound","longitude":-71.083423,"latitude":42.341512},{"stopID":70015,"stopName":"Back Bay - Inbound","longitude":-71.075727,"latitude":42.34735},{"stopID":70017,"stopName":"Tufts Medical Center - Inbound","longitude":-71.063917,"latitude":42.349662},{"stopID":70019,"stopName":"Chinatown - Inbound","longitude":-71.062752,"latitude":42.352547},{"stopID":70021,"stopName":"Downtown Crossing - to Oak Grove","longitude":-71.060225,"latitude":42.355518},{"stopID":70023,"stopName":"State Street - to Oak Grove","longitude":-71.057598,"latitude":42.358978},{"stopID":70025,"stopName":"Haymarket - Orange Line Outbound","longitude":-71.05829,"latitude":42.363021},{"stopID":70027,"stopName":"North Station - Orange Line Outbound","longitude":-71.06129,"latitude":42.365577},{"stopID":70029,"stopName":"Community College - Outbound","longitude":-71.069533,"latitude":42.373622},{"stopID":70031,"stopName":"Sullivan Square - Outbound","longitude":-71.076994,"latitude":42.383975},{"stopID":70279,"stopName":"Assembly - Outbound","longitude":-71.077257,"latitude":42.392811},{"stopID":70033,"stopName":"Wellington - Outbound","longitude":-71.077082,"latitude":42.40237},{"stopID":70035,"stopName":"Malden - Outbound","longitude":-71.07411,"latitude":42.426632}]');
var stops = [];
var modifiedX, modifiedY, currentStatus;

$(document).ready(function() {
    for (i=0; i<stopJSON.length; i++) {
        modifiedX = ((stopJSON[i].longitude+72)*100-88)*200+20;
        modifiedY = ((stopJSON[i].latitude-42)*100-30)*200+20;
        stops[i] = new Stop(parseInt(stopJSON[i].stopID), stopJSON[i].stopName, modifiedX, modifiedY);
    }
    for (i=0; i<stops.length; i++) {
        var circle = makeSVG('circle', {cx: stops[i].x, cy: stops[i].y, r:5, stroke:'#ed8b00', 'stroke-width':0.125, fill:'#ed8b00'});
        document.getElementById('mbtaMap').appendChild(circle);
    }
});

window.setInterval(function() {
    updateVehicle();
}, 3000);

function updateVehicle() {
    $.ajax({
        url: 'mbtaGridAPI.php',
        success: function(output) {
            console.log(output);
            var splitOutput = output.split("?");
            currentStatus = splitOutput[0];
            modifiedX = ((parseFloat(splitOutput[1])+72)*100-88)*200+20;
            modifiedY = ((parseFloat(splitOutput[2])-42)*100-30)*200+20;
            $("#train").css("-webkit-transform","translate(" + modifiedX + "px, " + modifiedY + "px)")
            if (currentStatus == "STOPPED_AT") {
                $("#trainOutline").css("fill","#da291c");
            } else {
                $("#trainOutline").css("fill","#1C1E23");
            }
        }
    });
}
</script>
</body>
</html>
