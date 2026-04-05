<?php
session_start();
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    exit;
}
include 'includes/db.php'; // Continua com o restante do código...
?>
<?php 
include 'includes/db.php'; 

// Lógica para Excluir Aluno
if (isset($_GET['excluir'])) {
    $id_excluir = intval($_GET['excluir']);
    $conn->query("DELETE FROM alunos WHERE id = $id_excluir");
    header("Location: lista_alunos.php?status=removido");
    exit;
}

// Lógica para Filtrar por Turno
$filtro_turno = isset($_GET['filtro_turno']) ? $_GET['filtro_turno'] : '';
$sql = "SELECT * FROM alunos";
if ($filtro_turno != '') {
    $sql .= " WHERE turno = '$filtro_turno'";
}
$sql .= " ORDER BY ano ASC, turma ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>MaxSchool - Lista de Alunos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .table-container { background: white; border-radius: 15px; padding: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .badge-turno { font-size: 0.8rem; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">🏫 MaxSchool Admin</a>
        <a href="index.php" class="btn btn-outline-light btn-sm">+ Novo Aluno</a>
    </div>
</nav>

<div class="container">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="fw-bold text-dark">Lista de Matriculados 📚</h2>
        </div>
        <div class="col-md-6 text-md-end">
            <form method="GET" class="d-inline-flex gap-2">
                <select name="filtro_turno" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Todos os Turnos</option>
                    <option value="Matutino" <?php echo $filtro_turno == 'Matutino' ? 'selected' : ''; ?>>Manhã</option>
                    <option value="Vespertino" <?php echo $filtro_turno == 'Vespertino' ? 'selected' : ''; ?>>Tarde</option>
                </select>
            </form>
        </div>
    </div>

    <?php if(isset($_GET['status']) && $_GET['status'] == 'removido'): ?>
        <div class="alert alert-warning">Aluno removido com sucesso.</div>
    <?php endif; ?>

    <div class="table-container">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nome</th>
                    <th class="text-center">Ano/Turma</th>
                    <th class="text-center">Turno</th>
                    <th class="text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($aluno = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="fw-bold"><?php echo htmlspecialchars($aluno['nome']); ?></td>
                            <td class="text-center">
                                <span class="badge bg-primary"><?php echo $aluno['ano']; ?>º Ano <?php echo $aluno['turma']; ?></span>
                            </td>
                            <td class="text-center">
                                <?php if($aluno['turno'] == 'Matutino'): ?>
                                    <span class="badge bg-info text-dark">☀️ Manhã</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">🌤️ Tarde</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <a href="lista_alunos.php?excluir=<?php echo $aluno['id']; ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Tem certeza que deseja remover este aluno?')">
                                   🗑️
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Nenhum aluno encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>