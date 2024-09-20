<!DOCTYPE html>
<html>

<!-- the head section -->
<head>
    <title>My Guitar Shop</title>
    <link rel="stylesheet" href="main.css" />
</head>

<!-- the body section -->
<body>
    <header><h1>My Guitar Shop</h1></header>

    <main>
        <h2 class="top">Error</h2>
        <p><?php echo $error; ?></p>
        <p><a href="index.php"> Return to product list </a></p>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> My Guitar Shop, Inc.</p>
    </footer>
</body>
</html>