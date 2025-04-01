<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['question'])) {
    $_SESSION['question'] = $_POST['question'];
    $_SESSION['votes'] = ['yes' => 0, 'no' => 0];
    header('Location: vote.php');
    exit();
}
?>
