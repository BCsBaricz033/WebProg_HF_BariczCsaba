<?php

function getUserCartsTotal($userId) {
    $userCartUrl = "https://fakestoreapi.com/carts/user/{$userId}";
    $userCartData = fetchData($userCartUrl);

    if (!$userCartData) {
        return "Hiba a felhasználó kosarainak lekérése során.";
    }

    $totalAmount = 0;

    foreach ($userCartData as $cart) {
        $productId = $cart['productId'];
        $productUrl = "https://fakestoreapi.com/products/{$productId}";
        $productData = fetchData($productUrl);

        if ($productData) {
            $productPrice = $productData['price'];
            $quantity = $cart['quantity'];
            $totalAmount += $productPrice * $quantity;
        }
    }

    return $totalAmount;
}

function fetchData($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    return json_decode($result, true);
}

$userId = 1;
$totalAmount = getUserCartsTotal($userId);

if (is_numeric($totalAmount)) {
    echo "Az {$userId}-es user kosarainak összértéke: {$totalAmount} USD";
} else {
    echo $totalAmount;
}

