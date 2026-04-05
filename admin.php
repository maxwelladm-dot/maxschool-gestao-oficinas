<?php 
session_start();
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    exit;
}
include 'includes/db.php'; 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel Central - MaxSchool</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; font-family: Arial, sans-serif; }
        .card-menu { 
            border: none; 
            border-radius: 10px; 
            transition: 0.3s; 
            text-decoration: none; 
            color: #333; 
            background: #fff;
        }
        .card-menu:hover { 
            transform: scale(1.05); 
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            color: #0d6efd;
        }
        .icon-size { font-size: 2.5rem; margin-bottom: 10px; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Escola Arnaldo Antônio</h2>
        <p class="text-muted text-uppercase">Sistema de Gestão de Oficinas</p>
        <hr style="width: 100px; margin: auto; border: 2px solid #0d6efd;">
    </div>

    <div class="row g-4 text-center">
        
        <div class="col-md-4">
            <a href="index.php" class="card card-menu shadow-sm p-4">
                <i class="bi bi-person-plus-fill text-primary icon-size"></i>
                <h5>Novo Aluno</h5>
            </a>
        </div>

        <div class="col-md-4">
            <a href="matricular_oficina.php" class="card card-menu shadow-sm p-4">
                <i class="bi bi-pencil-square text-success icon-size"></i>
                <h5>Matrícula Oficina</h5>
            </a>
        </div>

        <div class="col-md-4">
            <a href="grade_horarios.php" class="card card-menu shadow-sm p-4">
                <i class="bi bi-calendar3 text-warning icon-size"></i>
                <h5>Grade Semanal</h5>
            </a>
        </div>

        <div class="col-md-4">
            <a href="transferir_aluno.php" class="card card-menu shadow-sm p-4">
                <i class="bi bi-arrow-left-right text-danger icon-size"></i>
                <h5>Mudar Horário</h5>
            </a>
        </div>

        <div class="col-md-4">
            <a href="relatorio_horario.php" class="card card-menu shadow-sm p-4">
                <i class="bi bi-printer-fill text-info icon-size"></i>
                <h5>Imprimir Relatórios</h5>
            </a>
        </div>

        <div class="col-md-4">
            <a href="logout.php" class="card card-menu shadow-sm p-4">
                <i class="bi bi-box-arrow-right text-secondary icon-size"></i>
                <h5>Sair do Sistema</h5>
            </a>
        </div>

    </div>

    <p class="text-center mt-5 text-muted small">MaxSchool - 2026</p>
</div>

</body>
</html>