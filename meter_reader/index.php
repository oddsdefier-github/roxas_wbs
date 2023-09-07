<?php
session_start();


if (!isset($_SESSION['loggedin'])) {

    echo '<script>alert("Please log in first!");</script>';
    echo '<script>window.location.href = "../authentication/signin.php";</script>';
    exit;
}

if ($_SESSION['user_role'] != "Meter Reader") {
    echo '<script>alert("You\'re not allowed here!");</script>';
    $_SESSION = array();
    session_unset();
    session_destroy();
    echo '<script>window.location.href = "../authentication/signin.php";</script>';
}

echo "Welcome " . $_SESSION['admin_name'] . " <br> " . " This page is under construction! ";

?>
<div class="tenor-gif-embed" data-postid="10477631958553809234" data-share-method="host" data-aspect-ratio="2.66667" data-width="100%"><a href="https://tenor.com/view/under-construction-gif-10477631958553809234">Under Construction GIF</a>from <a href="https://tenor.com/search/under+construction-gifs">Under Construction GIFs</a></div>
<script type="text/javascript" async src="https://tenor.com/embed.js"></script>


<a href="./signout.php">GO BACK</a>