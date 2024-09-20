<?php

$product_description = '';
$list_price = '';
$discount_percent = '';
$error_message = '';
$discount_price_f = $discount_f = $discount_percent_f = $list_price_f = $sales_tax_f = $total_price_f = '';


$sales_tax_rate = 8;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $product_description = filter_input(INPUT_POST, 'product_description', FILTER_SANITIZE_STRING);
    $list_price = filter_input(INPUT_POST, 'list_price', FILTER_VALIDATE_FLOAT);
    $discount_percent = filter_input(INPUT_POST, 'discount_percent', FILTER_VALIDATE_FLOAT);

  
    if (empty($product_description)) {
        $error_message .= "<p>Product Description is a required field.</p>";
    }
    if ($list_price === FALSE || $list_price <= 0) {
        $error_message .= "<p>List Price must be a number greater than zero.</p>";
    }
    if ($discount_percent === FALSE || $discount_percent <= 0 || $discount_percent > 100) {
        $error_message .= "<p>Discount Percent must be a number between 0 and 100.</p>";
    }

  
    if (empty($error_message)) {
      
        $discount = $list_price * $discount_percent * .01;
        $discount_price = $list_price - $discount;


        $sales_tax = $discount_price * ($sales_tax_rate / 100);

 
        $total_price = $discount_price + $sales_tax;

   
        $list_price_f = "$".number_format($list_price, 2);
        $discount_percent_f = $discount_percent."%";
        $discount_f = "$".number_format($discount, 2);
        $discount_price_f = "$".number_format($discount_price, 2);
        $sales_tax_f = "$".number_format($sales_tax, 2);
        $total_price_f = "$".number_format($total_price, 2);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Discount Calculator</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <main>
        <h1>Product Discount Calculator</h1>

   
        <?php if (!empty($error_message)): ?>
            <div style="color: red;">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

     
        <form action="" method="post">
            <div id="data">
                <label>Product Description:</label>
                <input type="text" name="product_description" value="<?php echo htmlspecialchars($product_description); ?>" required><br>

                <label>List Price:</label>
                <input type="text" name="list_price" value="<?php echo htmlspecialchars($list_price); ?>" required><br>

                <label>Discount Percent:</label>
                <input type="text" name="discount_percent" value="<?php echo htmlspecialchars($discount_percent); ?>" required><span>%</span><br>
            </div>

            <div id="buttons">
                <input type="submit" value="Calculate Discount">
            </div>
        </form>


        <?php if (empty($error_message) && $_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <h2>Discount Information</h2>
            <label>Product Description:</label>
            <span><?php echo htmlspecialchars($product_description); ?></span><br>

            <label>List Price:</label>
            <span><?php echo $list_price_f; ?></span><br>

            <label>Discount Percent:</label>
            <span><?php echo $discount_percent_f; ?></span><br>

            <label>Discount Amount:</label>
            <span><?php echo $discount_f; ?></span><br>

            <label>Discount Price:</label>
            <span><?php echo $discount_price_f; ?></span><br>

            <label>Sales Tax Rate:</label>
            <span><?php echo $sales_tax_rate; ?>%</span><br>

            <label>Sales Tax Amount:</label>
            <span><?php echo $sales_tax_f; ?></span><br>

            <label>Total Price (after discount and tax):</label>
            <span><?php echo $total_price_f; ?></span><br>
        <?php endif; ?>
    </main>
</body>
</html>