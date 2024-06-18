<?php
session_start();
require '../config.php'; 

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM categorias_de_quartos WHERE id = :id";
    
    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $categoria = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$categoria) {
            die('Categoria não encontrada.');
        }
    } catch(PDOException $e) {
        die("ERROR: Não foi possível executar a consulta. " . $e->getMessage());
    }
} else {
    die('ID de categoria não especificado.');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = $_POST['tipo'];
    $preco = $_POST['preco'];
    $descricao = $_POST['descricao'];
    $ar_condicionado = $_POST['ar_condicionado'];
    $tv = $_POST['tv'];
    $servico_quarto = $_POST['servico_quarto'];
    $banheiro = $_POST['banheiro'];

    $query = "UPDATE categorias_de_quartos SET tipo = :tipo, preco = :preco, descricao = :descricao, ar_condicionado = :ar_condicionado, tv = :tv, servico_quarto = :servico_quarto, banheiro = :banheiro WHERE id = :id";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':preco', $preco);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':ar_condicionado', $ar_condicionado);
        $stmt->bindParam(':tv', $tv);
        $stmt->bindParam(':servico_quarto', $servico_quarto);
        $stmt->bindParam(':banheiro', $banheiro);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        $stmt->execute();

        header("location: ../gerenciadores/categoriaq.php");
        exit();
    } catch(PDOException $e) {
        die("ERROR: Não foi possível executar a atualização. " . $e->getMessage());
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Categoria de Quarto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <style>
        body { 
            font-family: 'Roboto', sans-serif;
            font-size: 16px;
            text-align: center; 
            background-color: #f5f5f5;
            color: black;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn-submit {
            width: 40%; 
        }
        .btn-cancel {
            width: 40%; 
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Editar Categoria de Quarto</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id; ?>" method="post">
            <div class="form-group">
                <label for="tipo">Tipo:</label>
                <input type="text" class="form-control" id="tipo" name="tipo" value="<?php echo htmlspecialchars($categoria['tipo']); ?>" required>
            </div>
            <div class="form-group">
                <label for="preco">Preço:</label>
                <input type="text" class="form-control" id="preco" name="preco" value="<?php echo htmlspecialchars($categoria['preco']); ?>" required>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="3" required><?php echo htmlspecialchars($categoria['descricao']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="ar_condicionado">Ar Condicionado:</label>
                <input type="text" class="form-control" id="ar_condicionado" name="ar_condicionado" value="<?php echo htmlspecialchars($categoria['ar_condicionado']); ?>" required>
            </div>
            <div class="form-group">
                <label for="tv">TV:</label>
                <input type="text" class="form-control" id="tv" name="tv" value="<?php echo htmlspecialchars($categoria['tv']); ?>" required>
            </div>
            <div class="form-group">
                <label for="servico_quarto">Serviço de Quarto:</label>
                <input type="text" class="form-control" id="servico_quarto" name="servico_quarto" value="<?php echo htmlspecialchars($categoria['servico_quarto']); ?>" required>
            </div>
            <div class="form-group">
                <label for="banheiro">Banheiro:</label>
                <input type="text" class="form-control" id="banheiro" name="banheiro" value="<?php echo htmlspecialchars($categoria['banheiro']); ?>" required>
            </div>
            <div class="form-row">
                <div class="col">
                    <button type="submit" class="btn btn-primary btn-submit">Salvar</button>
                </div>
                <div class="col">
                    <a href="../gerenciadores/categoriaq.php" class="btn btn-danger btn-cancel">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
