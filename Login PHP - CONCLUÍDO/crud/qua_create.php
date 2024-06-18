<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
}

require_once 'config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $numero = $_POST['numero'];
    $vista = $_POST['vista'];
    $descricao = $_POST['descricao'];
    $andar = $_POST['andar'];
    $categoria_id = $_POST['categoria_id'];

    $sql = "INSERT INTO Quarto (numero, vista, descricao, andar, Categorias_de_quartos_id) 
            VALUES (:numero, :vista, :descricao, :andar, :categoria_id)";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':numero', $numero);
    $stmt->bindParam(':vista', $vista);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':andar', $andar);
    $stmt->bindParam(':categoria_id', $categoria_id);

    if ($stmt->execute()) {
        header("location: ../gerenciadores/quarto.php"); 
        exit;
    } else {
        echo "Erro ao tentar adicionar o quarto.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Quarto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Adicionar Novo Quarto</h2>
        <form method="post">
            <div class="form-group">
                <label for="numero">Número:</label>
                <input type="text" class="form-control" id="numero" name="numero" required>
            </div>
            <div class="form-group">
                <label for="vista">Vista:</label>
                <input type="text" class="form-control" id="vista" name="vista" required>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="andar">Andar:</label>
                <input type="text" class="form-control" id="andar" name="andar" required>
            </div>
            <div class="form-group">
                <label for="categoria_id">Categoria:</label>
                <select class="form-control" id="categoria_id" name="categoria_id" required>
                   
                    <?php
                    $query = "SELECT id, tipo FROM Categorias_de_quartos";
                    $stmt = $pdo->query($query);
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="' . $row['id'] . '">' . $row['tipo'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Adicionar Quarto</button>
            <a href="../gerenciadores/quarto.php" class="btn btn-danger ml-2">Cancelar</a>
        </form>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
