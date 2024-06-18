<?php
session_start();
require '../config.php'; 
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
}

$query = "SELECT * FROM categorias_de_quartos";
$categorias = [];

try {
    $stmt = $pdo->query($query);
    if ($stmt->rowCount() > 0) {
        $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch(PDOException $e) {
    die("ERROR: Não foi possível executar a consulta. " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Categoria dos Quartos</title>
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
        .navbar {
            min-height: 65px; 
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 15px; 
        }
        .navbar-brand {
            display: flex;
            align-items: center;
        }
        .navbar-brand img {
            margin-right: 10px;
            height: 40px; 
        }
        .navbar-nav {
            display: flex;
            align-items: center;
        }
        .nav-link {
            color: black !important;
            font-size: 18px; 
            transition: color 0.3s ease;
            padding: 0.5rem 1rem; 
        }
        .nav-link:hover {
            color: gray !important;
        }
        .main-content {
            padding: 20px;
        }
        .container {
            margin-top: 20px; 
        }
        .btn-adicionar {
            margin-bottom: 10px; 
        }
        table {
            font-size: 16px; 
            max-width: 100%; 
            margin: 0 auto; 
            border-collapse: collapse;
        }
        table th, table td {
            padding: 10px; 
            border: 1px solid #dee2e6;
        }
        table th {
            background-color: #f8f9fa;
            font-weight: bold; 
        }
        @media (max-width: 767.98px) {
            .navbar-brand,
            .nav-link {
                font-size: 14px; 
                padding: 0.3rem 0.5rem; 
            }
            .navbar {
                min-height: 50px; 
            }
            .navbar-brand img {
                height: 35px; 
            }
            table {
                font-size: 14px;
            }
        }
        
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <a class="navbar-brand" href="#">
            <img src="../imgi/logo.3.png" height="45">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../welcome.php">Início</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../gerenciadores/quarto.php">Quartos</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="../gerenciadores/categoriaq.php">Categoria dos quartos<span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo htmlspecialchars($_SESSION["username"]); ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="reset-password.php">Redefinir sua senha</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../logout.php">Sair da conta</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-between align-items-center mb-3">
                <h3>LISTA DE CATEGORIA DE QUARTOS</h3>
            </div>
            <?php if (isset($_SESSION['alert'])): ?>
                <div class="alert alert-<?php echo $_SESSION['alert']['type']; ?> alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['alert']['message']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['alert']);  ?>
            <?php endif; ?>

            <?php if (empty($categorias)): ?>
                <p>Nenhuma categoria foi cadastrada.</p>
            <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Preço</th>
                        <th>Descrição</th>
                        <th>Ar Condicionado</th>
                        <th>TV</th>
                        <th>Serviço de Quarto</th>
                        <th>Banheiro</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categorias as $categoria): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($categoria['id']); ?></td>
                        <td><?php echo htmlspecialchars($categoria['tipo']); ?></td>
                        <td><?php echo htmlspecialchars($categoria['preco']); ?></td>
                        <td><?php echo htmlspecialchars($categoria['descricao']); ?></td>
                        <td><?php echo htmlspecialchars($categoria['ar_condicionado']); ?></td>
                        <td><?php echo htmlspecialchars($categoria['tv']); ?></td>
                        <td><?php echo htmlspecialchars($categoria['servico_quarto']); ?></td>
                        <td><?php echo htmlspecialchars($categoria['banheiro']); ?></td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Ações">
                                <a href="../crud/cat_update.php?id=<?php echo htmlspecialchars($categoria['id']); ?>" class="btn btn-warning btn-sm mr-2">Editar</a>
                                <a href="../crud/cat_delete.php?id=<?php echo htmlspecialchars($categoria['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir esta categoria?');">Excluir</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

