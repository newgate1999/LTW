<?php

class ItemController {
    public function getItem($id) {
        require('connection.php');
        $id_sql = mysqli_real_escape_string($db, $id);
        $result = mysqli_query($db, "SELECT * FROM items WHERE id = $id");
        return mysqli_fetch_assoc($result);
    }
}