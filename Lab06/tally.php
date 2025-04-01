<?php
session_start();

if (!isset($_SESSION['question']) || $_SESSION['question'] == "") {
    header('Location: register.html');
    exit();
}

$yesVotes = $_SESSION['votes']['yes'];
$noVotes = $_SESSION['votes']['no'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>QuickPoll Tally</title>
</head>
<body>
<h1>QuickPoll Tally</h1>
<p>Your answer has been registered. The current totals are:</p>
<p>Yes: <?php echo $yesVotes; ?></p>
<p>No: <?php echo $noVotes; ?></p>

<a href="vote.php">Vote again</a><br>
<a href="register.html">Register a new question</a>

</body>
</html>
