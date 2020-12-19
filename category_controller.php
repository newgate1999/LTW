<?php
require_once("User.php");

class CategoryController {
    public function getItems($type, $start, $end, $name) {
        require('connection.php');
        $op = "WHERE";
        $query = "SELECT * FROM items";
        if ($type !== "all") {
            $type_sql = mysqli_real_escape_string($db, $type);
            $query .= " $op type = '$type_sql'";
            $op = "AND";
        }

        if ($start && $end) {
            $start_sql = mysqli_real_escape_string($db, $start);
            $end_sql = mysqli_real_escape_string($db, $end);
            $query .= " $op price > $start_sql AND price < $end_sql";
            $op = "AND";
        }

        if ($name) {
            $query .= " $op name LIKE '%$name%'";
        }
        $result = mysqli_query($db, $query);
        return $result;
    }

}
?>