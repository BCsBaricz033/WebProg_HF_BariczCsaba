<?php
session_start();

if (!isset($_SESSION["cart"])){
    $_SESSION["cart"] = [];
}

$products = [
    ['id' => 1, 'name' => 'Product A', 'price' => 10.99],
    ['id' => 2, 'name' => 'Product B', 'price' => 14.99],
    ['id' => 3, 'name' => 'Product C', 'price' => 19.99]
];

function getProductById($products, $productId) {
    foreach ($products as $product) {
        if ($product['id'] == $productId) {
            return $product;
        }
    }
    return null;
}


if (isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];

    if (isset($_SESSION["cart"][$productId])) {
        $_SESSION["cart"][$productId]["quantity"]++;
    } else {
        $product = getProductById($products, $productId);
        $_SESSION["cart"][$productId] = [
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => 1
        ];
    }
}

if (isset($_POST['view_cart'])) {
    header('Location: view_cart.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>
</head>
<body>
<h1>Product List</h1>

<ul>
    <?php foreach ($products as $product) { ?>
        <li>
            <form method="post">
                <?php echo $product['name']; ?> - $<?php echo $product['price']; ?>
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <input type="submit" name="add_to_cart" value="Add to Cart">
            </form>
        </li>
    <?php } ?>
</ul>

<form method="post">
    <input type="submit" name="view_cart" value="View Cart">
</form>
</body>
</html>