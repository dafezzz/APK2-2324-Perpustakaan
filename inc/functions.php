<?php
// Mulai session
session_start();

// Cek apakah user sudah login atau belum
function checkLogin()
{
    if (!isset($_SESSION["ses_username"]) || $_SESSION["ses_username"] == "") {
        header("location: login.php");
        exit();
    }
}

// Ambil data session user yang login
function getUserSession()
{
    return [
        'id' => $_SESSION["ses_id"] ?? '',
        'nama' => $_SESSION["ses_nama"] ?? '',
        'username' => $_SESSION["ses_username"] ?? '',
        'level' => $_SESSION["ses_level"] ?? ''
    ];
}
