<?php
require 'db.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("DELETE FROM patients WHERE id = ?");
    if ($stmt->execute([$id])) {
        echo "success";
    } else {
        echo "error";
    }
}
?>