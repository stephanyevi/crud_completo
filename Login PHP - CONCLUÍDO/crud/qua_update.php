<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
}

require_once 'config.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $quarto_id = $_GET['id'];

   
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $numero = $_POST['numero'];
        $vista = $_POST['vista'];
        $descricao = $_POST['descricao'];
        $andar = $_POST['andar'];
        $categoria_id = $_POST['categoria_id'];

        $sql = "UPDATE Quarto 
                SET numero = :numero, vista = :vista, descricao = :descricao, andar = :andar, Categorias_de_quartos_id = :categoria_id
                WHERE id = :quarto_id";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':numero', $numero);
        $stmt->bindParam(':vista', $vista);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':andar', $andar);
        $stmt->bindParam(':categoria_id', $categoria_id);
        $stmt->bindParam(':quarto_id', $quarto_id);

        if ($stmt->execute()) {
            header("location: ../gerenciadores/quarto.php");
            exit;
        } else {
            echo "Erro ao tentar atualizar o quarto.";
        }
    }

    
    $sql_select = "SELECT q.id, q.numero, q.vista, q.descricao AS quarto_descricao, 
                          q.andar, c.id AS categoria_id
                   FROM Quarto q
                   JOIN Categorias_de_quartos c ON q.Categorias_de_quartos_id = c.id
                   WHERE q.id = :quarto_id";

    $stmt_select = $pdo->prepare($sql_select);
    $stmt_select->bindParam(':quarto_id', $quarto_id);
    $stmt_select->execute();
    $row = $stmt_select->fetch(PDO::FETCH_ASSOC);

} else {
    echo "ID do quarto não fornecido.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Atualizar Quarto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Atualizar Quarto</h2>
        <form method="post">
            <div class="form-group">
                <label for="numero">Número:</label>
                <input type="text" class="form-control" id="numero" name="numero" value="<?php echo $row['numero']; ?>" required>
            </div>
            <div class="form-group">
                <label for="vista">Vista:</label>
                <input type="text" class="form-control" id="vista" name="vista" value="<?php echo $row['vista']; ?>" required>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="3" required><?php echo $row['quarto_descricao']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="andar">Andar:</label>
                <input type="text" class="form-control" id="andar" name="andar" value="<?php echo $row['andar']; ?>" required>
            </div>
            <div class="form-group">
                <label for="categoria_id">Categoria:</label>
                <select class="form-control" id="categoria_id" name="categoria_id" required>
                   
                    <?php
                    $query = "SELECT id, tipo FROM Categorias_de_quartos";
                    $stmt = $pdo->query($query);
                    while ($cat_row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $selected = ($cat_row['id'] == $row['categoria_id']) ? 'selected' : '';
                        echo '<option value="' . $cat_row['id'] . '" ' . $selected . '>' . $cat_row['tipo'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar Quarto</button>
            <a href="../gerenciadores/quarto.php" class="btn btn-danger ml-2">Cancelar</a>
        </form>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
