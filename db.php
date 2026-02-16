<?php
$host = '127.0.0.1';  
$db   = '';    
$user = '';  
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}