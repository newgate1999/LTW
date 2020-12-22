<?php
require_once('models.php');
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']->getRole() !== 'admin') {
    header('Location: login.php');
}