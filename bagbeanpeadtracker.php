<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Pead Collector</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style>
    :root {
        --jumbotron-padding-y: 3rem;
    }
    .btn-primary {
        display: block;
        margin-top: 10px;
    }
    body {
        background-color: #f8f9fa !important;
    }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor02">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Features</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Pricing</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">About</a>
            </li>
        </ul>
        <form class="form-inline">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
  </nav>

<main role="main">
    <div id="comments" class="container-fluid">
        <template>
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <p class="card-text">{{COMMENT TEXT}}</p>
                </div>
            </div>
        </template>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script>
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

var pages = ["https://www.deviantart.com/bagbeans",
    "https://www.deviantart.com/bagbeans/journal/NEWS-2018-Oct-Dec-768361564",
    "https://www.deviantart.com/bagbeans/journal/Change-Log-November-2018-December-2018-771342032",
    "https://www.deviantart.com/bagbeans/journal/Bagbean-Creatures-Other-Already-Made-Used-617198814",
    "https://www.deviantart.com/bagbeans/journal/How-to-use-love-items-guide-753511351",
    "https://www.deviantart.com/bagbeans/journal/Feedback-Box-new-hot-topics-added-740028878",
    "https://www.deviantart.com/bagbeans/journal/University-of-Griffia-Approval-Hub-708327282",
    "https://www.deviantart.com/bagbeans/journal/Beania-Trial-Approval-Hub-CLOSED-FOR-BREAK-705405256",
    "https://www.deviantart.com/bagbeans/journal/Update-regarding-bonuses-unofficial-mutations-etc-673596280",
    "https://www.deviantart.com/bagbeans/journal/Global-journal-for-Griffian-base-and-theme-changes-773578871",
    "https://www.deviantart.com/bagbeans/journal/Beania-Hub-2-773405537",
    "https://www.deviantart.com/bagbeans/journal/Pead-Scavenger-Hunt-CLOSED-FOR-BREAK-708546696"];
var lastCache = new Array(pages.length).fill("");
var cardHTML = $("template").html();
var i = 0;

$(document).ready(function() {
    setInterval(function() {
        i = (i+1) % pages.length;
        console.log(pages[i]);
        console.log(lastCache);
        $.post("bagbeanscraper.php", {url: pages[i]}, function(result) {
            console.log(result);
            if (!result.includes("failed to open stream: HTTP request failed! HTTP/1.1 403 Forbidden")) {
                if (result != lastCache[i]) {
                    if (lastCache[i] != "") {
                        $.playSound('ding.wav');
                    }
                    lastCache[i] = result;
                    $("#comments").prepend(cardHTML.replace("{{COMMENT TEXT}}",result));
                }
            }
        });
    }, 20000);
});
</script>
</body>
</html>
