<?php
$host = "localhost";
$user = "root";
$password = "password";
$db = mysqli_connect($host, $user, $password, 'test') or die("Không kết nối được database");
session_start();