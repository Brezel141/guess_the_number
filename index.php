<?php
session_start(); // Start the session (must be the first statement)

if (!isset($_SESSION['rand'])) {
    // Check if the random number hasn't been generated in this session
    // If it hasn't been generated, generate a new random number and store it in the session
    $_SESSION['rand'] = rand(1, 100);
}

$rand = $_SESSION['rand']; // Retrieve the random number from the session
$zahl = "";
$counter = 0; // Initialize the counter for attempts to 0
$showform = true; // Variable to determine whether to show or hide the form

if (isset($_POST["send"])) {
    if (isset($_POST["zahl"]) && is_numeric($_POST["zahl"])) {
        $zahl = $_POST["zahl"];
        $counter = $_POST["counter"]; // Retrieve the current value of the counter

        if ($zahl < $rand) {
            $low = "Number too low! <br>"; // Message if the entered number is too low
        } elseif ($zahl > $rand) {
            $high = "Number too high! <br>"; // Message if the entered number is too high
        } elseif ($zahl == $rand) {
            $win = "You Win!! <br>"; // Message if the user guessed the number
            // Now you can reset the random number by unsetting the session variable
            unset($_SESSION['rand']);
            $showform = false;
        }

        $counter++; // Increment the counter after each attempt
    } else {
        echo "Please insert a valid number."; // Message if the input is not a valid number
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guess the Number</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Guess the Number</h1>

        <?php 
        if (isset($low)){
            echo $low;
        }
        if (isset($high)){
            echo $high;
        }
        if (isset($win)){
            echo $win;
            echo "Number of attempts: $counter"; // Display the number of attempts
        }
        if ($showform == true) { ?>

        <form action="randnum.php" method="POST">
            <input type="text" name="zahl" placeholder="Enter a number" value="<?php echo $zahl; ?>">
            <input type="submit" name="send" value="Submit">
            <input type="hidden" name="counter" value="<?php echo $counter; ?>">
        </form>

        <?php } else { ?>
            <a href="randnum.php">Try Again!</a>
        <?php } ?>
    
    </div>
</body>
</html>
