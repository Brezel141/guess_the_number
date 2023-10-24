<?php
// Initialize variables
$firstName = "";
$lastName = "";
$cb = false; // Variable to check if the checkbox is selected
$errors = array(); // Array to store errors
$showForm = true; // Variable to control whether to display the form or the thank you message
$agbError = false; // State variable for the AGB error
$formNotSubmittedError = false; // State variable for the form not submitted error

// Check if the form has been submitted
if (isset($_POST["sub"])) {
    // Retrieve data from form fields
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];

    // Check if the checkbox is selected
    if (isset($_POST["cb"])) {
        $cb = true;
    } else {
        $agbError = true; // Set the state variable for the AGB error
    }

    // Check if the firstName field is empty
    if (empty($firstName)) {
        $errors[] = "First name must be filled out.";
    }

    // Check if the lastName field is empty
    if (empty($lastName)) {
        $errors[] = "Last name must be filled out.";
    }

    // Check if firstName and lastName contain only letters
    if (!ctype_alpha($firstName) || !ctype_alpha($lastName)) {
        $errors[] = "Invalid characters in first name or last name.";
    }

    // If there are errors, add a general message
    if (!empty($errors)) {
        $formNotSubmittedError = true; // Set the state variable for the form not submitted error
    } else {
        // If there are no errors, set $showForm to false
        $showForm = false;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php if ($showForm) { // Check whether to display the form or the thank you message ?>
    <h1>Order Completion</h1>
    <?php 
    if ($formNotSubmittedError) {
        echo "<h3>The form was not submitted!</h3>";
    }
    
    ?>
    <p>Please enter your information. All fields must be filled out.</p>

    <form action="test.php" method="POST">
        <p>First Name: <input type="text" name="firstName" value="<?php echo $firstName; ?>"></p>
        <p>Last Name: <input type="text" name="lastName" value="<?php echo $lastName; ?>"></p>
        <p>
            <input type="checkbox" name="cb" <?php if ($cb) { echo 'checked="checked"'; } ?>> I agree to the terms and conditions

            <?php
                if ($agbError) {
                    echo "<br>Terms and conditions must be accepted!";
                }
            ?>
        </p>
        <input type="submit" name="sub" value="Submit">

        <?php 
        } else { // If $showForm is false, display the thank you message
            echo "<h2>Form submitted successfully. Thank you, $firstName!</h2>";
            echo '<a href="php.Project-02.php">New Form</a>';
        } 
        ?>

    </form>

    <?php
    if (!empty($errors)) {
        echo "<h2>Errors:</h2>";
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }
    ?>

</body>
</html>
