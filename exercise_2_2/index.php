<?php
// Initialize variables
$investment = '';
$interest_rate = '';
$years = '';
$error_message = '';
$future_value_f = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the data from the form
    $investment = filter_input(INPUT_POST, 'investment', FILTER_VALIDATE_FLOAT);
    $interest_rate = filter_input(INPUT_POST, 'interest_rate', FILTER_VALIDATE_FLOAT);
    $years = filter_input(INPUT_POST, 'years', FILTER_VALIDATE_INT);

    // Set default error message of empty string
    $error_message = '';

    // Validate investment
    if ($investment === FALSE) {
        $error_message .= 'Investment must be a valid number.<br>';
    } else if ($investment <= 0) {
        $error_message .= 'Investment must be greater than zero.<br>';
    }

    // Validate interest rate
    if ($interest_rate === FALSE) {
        $error_message .= 'Interest rate must be a valid number.<br>';
    } else if ($interest_rate <= 0) {
        $error_message .= 'Interest rate must be greater than zero.<br>';
    } else if ($interest_rate > 15) {
        $error_message .= 'Interest rate must be less than or equal to 15.<br>';
    }

    // Validate years
    if ($years === FALSE) {
        $error_message .= 'Years must be a valid whole number.<br>';
    } else if ($years <= 0) {
        $error_message .= 'Years must be greater than zero.<br>';
    } else if ($years > 30) {
        $error_message .= 'Years must be less than 31.<br>';
    }

    // If an error message exists, don't perform the calculation
    if ($error_message == '') {
        // Calculate the future value
        $future_value = $investment;
        for ($i = 1; $i <= $years; $i++) {
            $future_value += $future_value * $interest_rate * .01;
        }

        // Apply currency and percent formatting
        $investment_f = '$' . number_format($investment, 2);
        $yearly_rate_f = $interest_rate . '%';
        $future_value_f = '$' . number_format($future_value, 2);

        // Reset form values to empty strings after calculation
        $investment = '';
        $interest_rate = '';
        $years = '';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Future Value Calculator</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <main>
    <div>
        <h1>Future Value Calculator</h1>
        
        <!-- Display error messages -->
        <?php if (!empty($error_message)) { ?>
            <p class="error" style="color: red;"><?php echo $error_message; ?></p>
        <?php } ?>

        <!-- Form to input values -->
        <form action="" method="post">
            <div id="data">
                <label>Investment Amount:</label>
                <input type="text" name="investment" value="<?php echo htmlspecialchars($investment); ?>"><br>

                <label>Yearly Interest Rate:</label>
                <input type="text" name="interest_rate" value="<?php echo htmlspecialchars($interest_rate); ?>"><br>

                <label>Number of Years:</label>
                <input type="text" name="years" value="<?php echo htmlspecialchars($years); ?>"><br>
            </div>

            <div id="buttons">
                <input type="submit" value="Calculate">
            </div>
        </form>

        <!-- Display results if no error and calculation is done -->
        <?php if (!empty($future_value_f)) { ?>
            <h2>Results</h2>
            <label>Investment Amount:</label>
            <span><?php echo htmlspecialchars($investment_f); ?></span><br>

            <label>Yearly Interest Rate:</label>
            <span><?php echo htmlspecialchars($yearly_rate_f); ?></span><br>

            <label>Number of Years:</label>
            <span><?php echo htmlspecialchars($_POST['years']); ?></span><br>

            <label>Future Value:</label>
            <span><?php echo htmlspecialchars($future_value_f); ?></span><br>

            <p>This calculation was done on <?php echo date('m/d/Y'); ?>.</p>
        <?php } ?>
    </div>
    </main>
</body>
</html>