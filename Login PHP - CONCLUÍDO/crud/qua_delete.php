<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
}

require_once 'config.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $quarto_id = $_GET['id'];


    $sql = "DELETE FROM Quarto WHERE id = :quarto_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':quarto_id', $quarto_id);

    if ($stmt->execute()) {
        header("location: ../gerenciadores/quarto.php"); 
        exit;
    } else {
        echo "Erro ao tentar excluir o quarto.";
    }
} else {
    echo "ID do quarto não fornecido.";
}
?>
