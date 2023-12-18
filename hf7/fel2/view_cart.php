<?php
session_start();

if (!isset($_SESSION["cart"])){
    $_SESSION["cart"] = [];
}

if (isset($_POST['remove_from_cart'])) {
    $productId = $_POST['product_id'];

    if (isset($_SESSION["cart"][$productId]) && $_SESSION["cart"][$productId]['quantity'] > 1) {
        $_SESSION["cart"][$productId]['quantity']--;
    } else {
        unset($_SESSION["cart"][$productId]);
    }
}

$totalPrice = 0;
foreach ($_SESSION["cart"] as $productId => $item) {
    $totalPrice += $item['price'] * $item['quantity'];
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
</head>
<body>
<h1>Shopping Cart</h1>

<ul>
    <?php foreach ($_SESSION["cart"] as $productId => $item) { ?>
        <li>
            <form method="post">
                <?php echo $item['name']; ?> - $<?php echo $item['price']; ?>
                (Quantity: <?php echo $item['quantity']; ?>)
                <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                <input type="submit" name="remove_from_cart" value="Remove from Cart">
            </form>
        </li>
    <?php } ?>
</ul>

<p>Total Price: $<?php echo number_format($totalPrice, 2); ?></p>
<a href="index.php">Back to Shopping</a>
</body>
</html>