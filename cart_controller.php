<?php
require_once 'models.php';
if(!isset($_SESSION))
{
    session_start();
}


class CartController
{

    public function addToCart($id) {

        require('connection.php');
        $id_sql = mysqli_real_escape_string($db, $id);
        $result = mysqli_query($db, "SELECT * FROM items WHERE id='$id_sql' LIMIT 1");
        $product = $result->fetch_assoc();

        $oldCart = isset($_SESSION['cart']) ? $_SESSION['cart'] : null;
        $cart = new Cart($oldCart);
        $cart->addItem($product);

        $_SESSION['cart'] = $cart;
        session_commit();
    }

    public function removeFromArray ($id) {
        require('connection.php');
        $id_sql = mysqli_real_escape_string($db, $id);
        $result = mysqli_query($db, "SELECT * FROM items WHERE id='$id_sql' LIMIT 1");
        $product = $result->fetch_assoc();

        $oldCart = isset($_SESSION['cart']) ? $_SESSION['cart'] : null;
        $cart = new Cart($oldCart);
        $cart->removeItemFromArray($product);

        if ($cart->totalQuantity !== 0) {
            $_SESSION['cart'] = $cart;
        }
        else {
            unset($_SESSION['cart']);
        }
        session_commit();

    }
    public function removeFromCart ($id) {
        require('connection.php');
        $id_sql = mysqli_real_escape_string($db, $id);
        $result = mysqli_query($db, "SELECT * FROM items WHERE id='$id_sql' LIMIT 1");
        $product = $result->fetch_assoc();

        $oldCart = isset($_SESSION['cart']) ? $_SESSION['cart'] : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($product);

        if ($cart->totalQuantity !== 0) {
            $_SESSION['cart'] = $cart;
            session_commit();
        }
        else {
            unset($_SESSION['cart']);
        }
    }
}
