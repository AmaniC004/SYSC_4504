<?php
session_start();

if (!isset($_SESSION['question']) || $_SESSION['question'] == "") {
    header('Location: register.html');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['vote'])) {
    $vote = $_POST['vote'];
    if ($vote === 'yes' || $vote === 'no') {
        $_SESSION['votes'][$vote]++;
    }
    header('Location: tally.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quick Poll Vote</title>
</head>
<body>
    <h1>Quick Poll Vote</h1>
    <?php echo htmlspecialchars($_SESSION['question']); ?>
<form method="post" action="">
    <input type="radio" id="yes" name="vote" value="yes" required>
    <label for="yes">Yes</label><br>
    <input type="radio" id="no" name="vote" value="no">
    <label for="no">No</label><br>
    <input type="submit" value="Register My Vote">
</form>
</body>
</html>
