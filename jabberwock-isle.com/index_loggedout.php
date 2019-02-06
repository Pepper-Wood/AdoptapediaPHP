<style>
@font-face {
    font-family: "GoodbyeDespair";
    src: url("goodbyeDespair.ttf") format("truetype");
}
a, a:focus, a:hover {
    color: #fff;
}
.btn {
    text-shadow: none;
}
html, body {
    height: 100%;
    background-color: #333;
    background-size: cover;
    background-position: center;
}
body {
    display: -ms-flexbox;
    display: flex;
    color: #fff;
    text-shadow: 0 .05rem .1rem rgba(0, 0, 0, .5);
    box-shadow: inset 0 0 5rem rgba(0, 0, 0, .5);
}
h1, h2, h3, h4, h5 {
    font-family: "GoodbyeDespair";
}
.cover-container {
    padding: 0 !important;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    width: 100%;
}
.cover-heading {
    color: #FFF;
    -webkit-text-fill-color: #ff2181;
    -webkit-text-stroke-width: 1px;
    -webkit-text-stroke-color: #FFF;
}
.masthead {
    margin-bottom: 2rem;
}
.masthead-brand {
    margin-bottom: 0;
}
.nav-masthead .nav-link {
    padding: .25rem 0;
    font-weight: 700;
    color: rgba(255, 255, 255, .25);
    background-color: transparent;
    border-bottom: .25rem solid transparent;
}
.nav-masthead .nav-link:hover, .nav-masthead .nav-link:focus {
    border-bottom-color: rgba(255, 255, 255, 0.5);
}
.nav-masthead .nav-link + .nav-link {
    margin-left: 1rem;
}
.nav-masthead .active {
    color: #fff;
    border-bottom-color: #fff;
}
@media (min-width: 48em) {
    .masthead-brand {
        float: left;
    }
    .nav-masthead {
        float: right;
    }
}
.cover {
    padding: 0 1.5rem;
    background-color: rgba(0,0,0,0.4);
}
.cover .btn-lg {
    padding: .75rem 1.25rem;
    font-weight: 700;
}
.mastfoot {
    margin-top: 3rem;
    color: rgba(255, 255, 255, .5);
}
</style>

<body class="text-center">

<div class="cover-container">
    <main role="main" class="inner cover">
        <h1 class="cover-heading">Jabberwock-Isle Trading Post</h1>
        <p class="lead">Inventory management system for <a href="https://www.deviantart.com/jabberwock-isle">Jabberwock-Isle</a> on DeviantArt, based on the murder mystery video game Super DanganRonpa 2: Goodbye Despair.</p>
        <p class="lead"><a href="login.php" class="btn btn-lg btn-outline-light"><i class="fab fa-deviantart"></i> Login</a></p>
    </main>

    <footer class="mastfoot">
        <div class="inner">
            <p>Artwork featured made by <span id="artistName"></span>.</p>
        </div>
    </footer>
</div>

<script>
var artists = ["sheepSODA","SmoleyFace","rhyfu","rhyfu","rhyfu","mmYapi","mmYapi","mmYapi","Bootsii","Bootsii","Bootsii"];
var rand = Math.floor(Math.random() * artists.length);
$("html, body").css("background-image", "url(home"+(rand+1)+".png)");
$("#artistName").html("<a href='https://www.deviantart.com/"+artists[rand]+"'>"+artists[rand]+"</a>");
</script>

</body>
</html>
