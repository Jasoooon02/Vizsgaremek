<?php
session_start();
if (isset($_SESSION['username'])) {
    echo "<a href='logout.php'>Kijelentkezés</a>";
} else {
    header("Location: index.php");
}
?>
