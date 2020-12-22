<?php


class OrderController
{
    public function placeOrder($recipient_name, $recipient_phone, $recipient_address)
    {
        require('connection.php');
        require_once('models.php');
        $recipient_name_sql = mysqli_real_escape_string($db, $recipient_name);
        $recipient_phone_sql = mysqli_real_escape_string($db, $recipient_phone);
        $user_id = mysqli_real_escape_string($db, $_SESSION['user']->getId());
        $total_price = mysqli_real_escape_string($db, $_SESSION['cart']->totalPrice);
        $recipient_address_sql = mysqli_real_escape_string($db, $recipient_address);
        $result = mysqli_query($db, "INSERT INTO orders (user_id, address, recipient_name, recipient_phone, total_price) 
    VALUES($user_id, '$recipient_address_sql', '$recipient_name_sql', '$recipient_phone_sql', $total_price)");

        $orders_id = mysqli_real_escape_string($db, mysqli_insert_id($db));
        foreach ($_SESSION['cart']->items as $item) {
            $item_id = mysqli_real_escape_string($db, $item['item']['id']);
            $item_quantity = mysqli_real_escape_string($db, $item['quantity']);
            $result = mysqli_query($db, "INSERT INTO ordered_items (item_id, orders_id, created_at, updated_at, quantity)
        VALUES($item_id, $orders_id, now(), now(), $item_quantity)");
        }
        $sql = "INSERT INTO order_logs(status_id, created_at, updated_at, orders_id)
                                       VALUES(3, now(), now(), $orders_id)";
        $result = mysqli_query($db, $sql);
        if ($result) {
            unset($_SESSION['cart']);
            $_SESSION['message'] = "Đặt hàng thành công";
        } else {
            $_SESSION['message'] = "Đặt hàng thất bại";
        }
    }

    public function mark_completed($orders_id) {
        require('connection.php');
        require_once('models.php');
        $orders_id_sql = mysqli_real_escape_string($db, $orders_id);
        $result = mysqli_query($db, "INSERT INTO order_logs(status_id, created_at, updated_at, orders_id)
                                                VALUES (2, now(), now(), $orders_id_sql)");
        $_SESSION['result'] = $result;
    }

    public function remove_order($orders_id) {
        require('connection.php');
        require_once('models.php');
        $orders_id_sql = mysqli_real_escape_string($db, $orders_id);
        $result = mysqli_query($db, "DELETE FROM orders WHERE id = $orders_id_sql");
        $_SESSION['result'] = $result;

    }

    public function get_orders($params) {
        require('connection.php');
        require_once('models.php');
        $sql = "SELECT order_logs.id, X.orders_id, updated_at, recipient_name, recipient_phone, address, total_price, status_name
                                                    FROM (
                                                    SELECT orders_id, MAX(created_at) AS 'max_created_at'
                                                    FROM order_logs
                                                    GROUP BY orders_id) AS X
                                                    INNER JOIN order_logs ON (order_logs.orders_id = X.orders_id AND order_logs.created_at = X.max_created_at)
                                                    INNER JOIN orders ON orders.id = X.orders_id
                                                    INNER JOIN statuses ON status_id = statuses.id";

        if ($params) {
            $op = "WHERE";
            foreach ($params as $col => $val) {
                if ($val != null) {
                    $val_sql = mysqli_real_escape_string($db, $val);

                    if (gettype($val) !== "string")
                        $sql .= "\n$op $col = $val_sql";
                    else
                        $sql .= "\n$op $col = '$val_sql'";
                    $op = "AND";
                }
            }
        }
        $sql .= "\nORDER BY updated_at DESC";
        $result = mysqli_query($db, $sql);
        return $result;
    }

    public function mark_shipping($orders_id) {
        require('connection.php');
        require_once('models.php');
        $orders_id_sql = mysqli_real_escape_string($db, $orders_id);
        $result = mysqli_query($db, "INSERT INTO order_logs(status_id, created_at, updated_at, orders_id)
                                                VALUES (1, now(), now(), $orders_id_sql)");
        $_SESSION['result'] = $result;

    }
}
?>