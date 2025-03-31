<?php
session_start();
$favoritesCount = isset($_SESSION['favorites']) ? count($_SESSION['favorites']) : 0;
include 'dbconnect.php'; // Include database connection

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <link href="http://fonts.googleapis.com/css?family=Merriweather" rel="stylesheet" type="text/css" />
        <link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="css/semantic.js"></script>
        <script src="js/misc.js"></script>
        <link href="css/semantic.css" rel="stylesheet" />
        <link href="css/icon.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <header>
            <div class="ui attached stackable grey inverted menu">
                <div class="ui container">
                    <nav class="right menu">
                        <a href="view-favorites.php" class="item">
                            <i class="heartbeat icon"></i> Favorites
                        </a>
                        <a class="item"> <i class="shop icon"></i> Cart </a>
                    </nav>
                </div>
            </div>
        </header>

        <main class="ui segment doubling stackable grid container">
            <section class="eleven wide column">
                <h1 class="ui header">Favorite Paintings</h1>
                <ul class="ui divided items" id="paintingsList">
                    <?php
                    if (isset($_SESSION['favorites']) && !empty($_SESSION['favorites'])) {
                        foreach ($_SESSION['favorites'] as $favorite) {
                            echo "<li class='item'>";
                            echo "<a class='ui small image' href='single-painting.php?id=" . $favorite['PaintingID'] . "'>";
                            echo "<img src='images/art/works/square-small/" . $favorite['ImageFileName'] . ".jpg' alt='" . htmlspecialchars($favorite['Title']) . "' />";
                            echo "</a>";
                            echo "<div class='content'>";
                            echo "<a class='header' href='single-painting.php?id=" . $favorite['PaintingID'] . "'>" . htmlspecialchars($favorite['Title']) . "</a>";
                            echo "<div class='extra'>";
                            echo "<a class='ui red button' href='remove-favorites.php?PaintingID=" . $favorite['PaintingID'] . "'>Remove</a>";
                            echo "</div>";
                            echo "</div>";
                            echo "</li>";
                        }
                        echo "<a href='remove-favorites.php?clear=true' class='ui red button'>Clear All Favorites</a>";
                    } else {
                        echo "<p>Your favorites list is empty.</p>";
                    }
                    ?>
                </ul>
            </section>
        </main>

        <?php include 'common-footer.php'; // Include footer ?>

    </body>
</html>
