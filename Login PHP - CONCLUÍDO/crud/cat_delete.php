<?php
session_start();
require '../config.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $sql = "DELETE FROM categorias_de_quartos WHERE id = :id";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();

        $_SESSION['alert'] = [
            'type' => 'danger',
            'message' => 'Categoria excluída com sucesso.'
        ];

        header("location: ../gerenciadores/categoriaq.php");
        exit;
    } catch(PDOException $e) {
        echo "Erro ao excluir categoria: " . $e->getMessage();
    }
} else {
    header("location: ../gerenciadores/categoriaq.php");
    exit;
}
?>
