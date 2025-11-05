<?php
session_start();

//  If NOT logged in  go to landing page
if (!isset($_SESSION['user_id'])) {
    header("Location: homepage.php");
    exit();
}

//  If logged in  redirect based on role
if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === "admin") {
    header("Location: admin.php");  // admin dashboard
    exit();
} else {
    header("Location: index.php");  // normal user homepage
    exit();
}