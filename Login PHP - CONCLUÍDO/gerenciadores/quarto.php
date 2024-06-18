<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login.php");
    exit;
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
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-between align-items-center mb-3">
                    <h3>LISTA DE QUARTOS</h3>
                    <a href="../crud/qua_create.php" class="btn btn-primary">Adicionar</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Número</th>
                            <th>Vista</th>
                            <th>Descrição</th>
                            <th>Andar</th>
                            <th>Categoria</th>
                            <th>Preço</th>
                            <th>Descrição da Categoria</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'config.php';

                        try {
                            $sql = "SELECT q.id, q.numero, q.vista, q.descricao AS quarto_descricao, 
                                           q.andar, c.tipo AS categoria, c.preco, c.descricao AS categoria_descricao
                                    FROM Quarto q
                                    JOIN Categorias_de_quartos c ON q.Categorias_de_quartos_id = c.id";

                            $stmt = $pdo->query($sql);

                            if ($stmt->rowCount() > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo '<tr>';
                                    echo '<td>' . $row['id'] . '</td>';
                                    echo '<td>' . $row['numero'] . '</td>';
                                    echo '<td>' . $row['vista'] . '</td>';
                                    echo '<td>' . $row['quarto_descricao'] . '</td>';
                                    echo '<td>' . $row['andar'] . '</td>';
                                    echo '<td>' . $row['categoria'] . '</td>';
                                    echo '<td>' . $row['preco'] . '</td>';
                                    echo '<td>' . $row['categoria_descricao'] . '</td>';
                                    echo '<td>';
                                    echo '<div class="btn-group" role="group">';
                                    echo '<a href="../crud/qua_update.php?id=' . $row['id'] . '" class="btn btn-sm btn-warning">Editar</a>';
                                    echo '<a href="../crud/qua_delete.php?id=' . $row['id'] . '" class="btn btn-sm btn-danger ml-1" onclick="return confirm(\'Tem certeza que deseja excluir este quarto?\')">Excluir</a>';
                                    echo '</div>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="9">Não há quartos cadastrados.</td></tr>';
                            }
                        } catch (PDOException $e) {
                            echo "Erro ao buscar quartos: " . $e->getMessage();
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
