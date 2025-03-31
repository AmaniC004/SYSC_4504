<?php
session_start();

// Check if the necessary fields are in the query string
if (isset($_GET['PaintingID'], $_GET['ImageFileName'], $_GET['Title'])) {
    // Get the painting data from the query string
    $paintingID = (int)$_GET['PaintingID'];
    $imageFileName = $_GET['ImageFileName'];
    $title = $_GET['Title'];

    // Initialize the favorites array in session if it doesn't exist
    if (!isset($_SESSION['favorites'])) {
        $_SESSION['favorites'] = [];
    }

    // Check if the painting is already in the favorites array
    $alreadyInFavorites = false;
    foreach ($_SESSION['favorites'] as $favorite) {
        if ($favorite['PaintingID'] == $paintingID) {
            $alreadyInFavorites = true;
            break;
        }
    }

    // If it's not already in the favorites, add it
    if (!$alreadyInFavorites) {
        $_SESSION['favorites'][] = [
            'PaintingID' => $paintingID,
            'ImageFileName' => $imageFileName,
            'Title' => $title
        ];
    }

    // Redirect to the favorites page
    header('Location: view-favorites.php');
    exit;
} else {
    // If the query string is missing, redirect to browse page or show an error
    header('Location: browse-paintings.php');
    exit;
}
?>
