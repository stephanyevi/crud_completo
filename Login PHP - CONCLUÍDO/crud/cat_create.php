<?php
session_start();
require '../config.php'; 

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';
    $preco = isset($_POST['preco']) ? $_POST['preco'] : '';
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
    $ar_condicionado = isset($_POST['ar_condicionado']) ? 'Sim' : 'Não';
    $tv = isset($_POST['tv']) ? 'Sim' : 'Não';
    $servico_quarto = isset($_POST['servico_quarto']) ? 'Sim' : 'Não';
    $banheiro = isset($_POST['banheiro']) ? 'Sim' : 'Não';

    $sql = "INSERT INTO categorias_de_quartos (tipo, preco, descricao, ar_condicionado, tv, servico_quarto, banheiro) 
            VALUES (:tipo, :preco, :descricao, :ar_condicionado, :tv, :servico_quarto, :banheiro)";

    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":tipo", $tipo);
        $stmt->bindParam(":preco", $preco);
        $stmt->bindParam(":descricao", $descricao);
        $stmt->bindParam(":ar_condicionado", $ar_condicionado);
        $stmt->bindParam(":tv", $tv);
        $stmt->bindParam(":servico_quarto", $servico_quarto);
        $stmt->bindParam(":banheiro", $banheiro);

        if ($stmt->execute()) {
            $_SESSION['categoria_cadastrada'] = true; 
            header("location: ../welcome.php");
            exit;
        } else {
            echo "Algo deu errado. Por favor, tente novamente mais tarde.";
        }
    }
    unset($stmt);
}
unset($pdo);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Criar Categoria</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .form-control {
            height: calc(2.25rem + 2px); 
            font-size: 0.875rem; 
        }
        .form-check-label {
            font-size: 0.875rem; 
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mt-5">Criar Categoria de Quarto</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <input type="text" name="tipo" class="form-control" placeholder="Tipo" maxlength="50" required>
                    </div>
                    <div class="form-group">
                        <input type="number" name="preco" class="form-control" placeholder="Preço" required>
                    </div>
                    <div class="form-group">
                        <textarea name="descricao" class="form-control" placeholder="Descrição" rows="3" required></textarea>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="ar_condicionado" name="ar_condicionado">
                        <label class="form-check-label" for="ar_condicionado">Ar Condicionado</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="tv" name="tv">
                        <label class="form-check-label" for="tv">TV</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="servico_quarto" name="servico_quarto">
                        <label class="form-check-label" for="servico_quarto">Serviço de Quarto</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="banheiro" name="banheiro">
                        <label class="form-check-label" for="banheiro">Banheiro</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Criar</button>
                    <a href="../welcome.php" class="btn btn-danger ml-2">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
