<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Bem vindo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
        }
        .navbar-nav {
            margin-left: auto; 
        }
        .nav-item.dropdown {
            margin-left: 15px; 
        }
        .navbar-collapse {
            display: flex;
            align-items: center;
        }
        .navbar-nav.main-links {
            margin-right: auto;
        }

        .fade-out {
            animation: fadeOut 0.5s forwards;
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
                visibility: hidden;
                height: 0;
                padding: 0;
                margin: 0;
            }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <a class="navbar-brand" href="#">
        <img src="imgi/logo.3.png" height="45">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <div>
            <ul class="navbar-nav main-links">
                <li class="nav-item">
                    <a class="nav-link" href="welcome.php">Início</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="gerenciadores/quarto.php">Quartos</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="gerenciadores/categoriaq.php">Categoria dos quartos<span class="sr-only"></span></a>
                </li>
            </ul>
        </div>
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo htmlspecialchars($_SESSION["username"]); ?>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="reset-password.php">Redefinir sua senha</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php">Sair da conta</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<div class="container mt-5">
    <div class="row mt-5">
        <div class="col-md-12">
            <?php if(isset($_SESSION['categoria_cadastrada']) && $_SESSION['categoria_cadastrada']): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Categoria de quarto cadastrada com sucesso!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                </div>
                <?php unset($_SESSION['categoria_cadastrada']); ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-4">
            <div class="card bg-white">
                <img src="imgi/hotelr.jpg" class="card-img-top" alt="Imagem 1">
                <div class="card-body">
                    <h5 class="card-title">Cadastrar Quarto</h5>
                    <a href="crud/qua_create.php" class="btn btn-primary">Cadastrar</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-white">
                <img src="imgi/hotelroom.jpg" class="card-img-top" alt="Imagem 2">
                <div class="card-body">
                    <h5 class="card-title">Cadastrar Categoria</h5>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCadastrarCategoria">
                        Cadastrar
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-white">
                <img src="imgi/re_hotel.avif" class="card-img-top" alt="Imagem 3">
                <div class="card-body">
                    <h5 class="card-title">Relatório</h5>
                    <a href="gerenciadores/relatorio.php" class="btn btn-primary">Acessar</a>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalCadastrarCategoria" tabindex="-1" aria-labelledby="modalCadastrarCategoriaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCadastrarCategoriaLabel">CRIAR CATEGORIA DE QUARTO:</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form action="crud/cat_create.php" method="post">
                    <div class="row mb-3">
                        <label for="tipo" class="col-sm-3 col-form-label">Tipo</label>
                        <div class="col-sm-9">
                            <input type="text" id="tipo" name="tipo" class="form-control form-control-sm" placeholder="Tipo" maxlength="50" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="preco" class="col-sm-3 col-form-label">Preço</label>
                        <div class="col-sm-9">
                            <input type="number" id="preco" name="preco" class="form-control form-control-sm" placeholder="Preço" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="descricao" class="col-sm-3 col-form-label">Descrição</label>
                        <div class="col-sm-9">
                            <textarea id="descricao" name="descricao" class="form-control form-control-sm" placeholder="Descrição" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label class="form-check-label">Ar Condicionado</label>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="ar_condicionado" name="ar_condicionado">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label class="form-check-label">TV</label>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="tv" name="tv">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label class="form-check-label">Serviço de Quarto</label>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="servico_quarto" name="servico_quarto">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label class="form-check-label">Banheiro</label>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="banheiro" name="banheiro">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-9">
                            <button type="submit" class="btn btn-primary">Criar</button>
                            <button type="button" class="btn btn-danger ms-2" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script>
    
    document.addEventListener("DOMContentLoaded", function() {
        var alertSuccess = document.querySelector(".alert-success");
        if(alertSuccess) {
            alertSuccess.addEventListener("click", function() {
                this.classList.add('fade-out');
            });

            alertSuccess.addEventListener("animationend", function() {
                this.remove();
            });
        }
    });
</script>
</body>
</html>
