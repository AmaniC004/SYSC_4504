<?php
session_start();

// Check if we want to clear all favorites
if (isset($_GET['clear']) && $_GET['clear'] == 'true') {
    unset($_SESSION['favorites']); // Clear all favorites
} elseif (isset($_GET['PaintingID'])) {
    // Otherwise, remove a specific painting from favorites
    $paintingID = (int)$_GET['PaintingID'];
    foreach ($_SESSION['favorites'] as $key => $favorite) {
        if ($favorite['PaintingID'] == $paintingID) {
            unset($_SESSION['favorites'][$key]); // Remove the painting from the array
            break;
        }
    }
}

// Redirect back to the view favorites page
header('Location: view-favorites.php');
exit;
?>
