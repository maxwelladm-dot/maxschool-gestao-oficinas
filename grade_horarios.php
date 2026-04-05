<?php 
session_start();
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    exit;
}
include 'includes/db.php'; 

// Filtros (Padrão: Segunda e Informática)
$dia_filtro     = isset($_GET['dia']) ? $_GET['dia'] : 'Segunda';
$oficina_filtro = isset($_GET['oficina']) ? $_GET['oficina'] : 'Informática';
$turno_filtro   = 'Vespertino';

// Função para buscar alunos filtrando por Dia e Oficina
function buscarGrade($conn, $dia, $oficina, $bloco, $turno) {
    $sql = "SELECT a.nome, a.ano, a.turma 
            FROM oficinas o 
            JOIN alunos a ON o.aluno_id = a.id 
            WHERE o.dia_semana LIKE '%$dia%' 
            AND o.nome_oficina = '$oficina' 
            AND o.bloco = '$bloco' 
            AND o.turno = '$turno'
            ORDER BY a.nome ASC";
    return $conn->query($sql);
}

$bloco1 = buscarGrade($conn, $dia_filtro, $oficina_filtro, 'Bloco 1', $turno_filtro);
$bloco2 = buscarGrade($conn, $dia_filtro, $oficina_filtro, 'Bloco 2', $turno_filtro);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Grade por Oficina - MaxSchool</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .card-bloco { border-radius: 15px; border: none; min-height: 350px; transition: 0.3s; }
        .card-bloco:hover { box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .head-1 { background: #2c3e50; color: white; border-radius: 15px 15px 0 0; padding: 15px; }
        .head-2 { background: #2980b9; color: white; border-radius: 15px 15px 0 0; padding: 15px; }
        .aluno-linha { border-bottom: 1px solid #f1f1f1; padding: 10px; display: flex; justify-content: space-between; }
        .aluno-linha:last-child { border-bottom: none; }
        .filtro-secao { background: white; padding: 20px; border-radius: 15px; margin-bottom: 30px; }
    </style>
</head>
<body>

<div class="container py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="admin.php" class="btn btn-outline-secondary fw-bold">
            <i class="bi bi-arrow-left"></i> VOLTAR
        </a>
        <h2 class="fw-bold mb-0 text-primary">Horários das Oficinas</h2>
    </div>

    <div class="filtro-secao shadow-sm">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-bold">1. Escolha a Oficina:</label>
                <select name="oficina" class="form-select border-primary" onchange="this.form.submit()">
                    <option value="Informática" <?php if($oficina_filtro == 'Informática') echo 'selected'; ?>>💻 Informática/Robótica</option>
                    <option value="Futsal" <?php if($oficina_filtro == 'Futsal') echo 'selected'; ?>>⚽ Futsal</option>
                    <option value="Horta" <?php if($oficina_filtro == 'Horta') echo 'selected'; ?>>🌱 Horta</option>
                    <option value="Arte" <?php if($oficina_filtro == 'Arte') echo 'selected'; ?>>🎨 Arte</option>
                    <option value="Flauta e Canto" <?php if($oficina_filtro == 'Flauta e Canto') echo 'selected'; ?>>🎶 Flauta e Canto</option>
                    <option value="Recomposição" <?php if($oficina_filtro == 'Recomposição') echo 'selected'; ?>>📚 Recomposição</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">2. Escolha o Dia:</label>
                <div class="btn-group w-100">
                    <?php 
                    $dias = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta'];
                    foreach($dias as $d): 
                        $active = ($dia_filtro == $d) ? 'btn-primary' : 'btn-outline-primary';
                    ?>
                        <a href="?oficina=<?php echo $oficina_filtro; ?>&dia=<?php echo $d; ?>" class="btn <?php echo $active; ?> fw-bold">
                            <?php echo $d; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-md-2 text-center">
                <span class="badge bg-dark p-2 w-100"><?php echo strtoupper($oficina_filtro); ?></span>
            </div>
        </form>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card card-bloco shadow-sm mb-4">
                <div class="head-1 text-center">
                    <h5><i class="bi bi-clock"></i> BLOCO 1 (14:00 - 15:15)</h5>
                </div>
                <div class="card-body p-0">
                    <?php if($bloco1->num_rows > 0): ?>
                        <?php while($al = $bloco1->fetch_assoc()): ?>
                            <div class="aluno-linha">
                                <span><strong><?php echo $al['nome']; ?></strong></span>
                                <span class="badge bg-light text-dark border"><?php echo $al['ano']; ?>º <?php echo $al['turma']; ?></span>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="text-center mt-5 text-muted">Nenhum aluno matriculado neste horário.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-bloco shadow-sm mb-4">
                <div class="head-2 text-center">
                    <h5><i class="bi bi-clock-history"></i> BLOCO 2 (15:45 - 17:00)</h5>
                </div>
                <div class="card-body p-0">
                    <?php if($bloco2->num_rows > 0): ?>
                        <?php while($al = $bloco2->fetch_assoc()): ?>
                            <div class="aluno-linha">
                                <span><strong><?php echo $al['nome']; ?></strong></span>
                                <span class="badge bg-light text-dark border"><?php echo $al['ano']; ?>º <?php echo $al['turma']; ?></span>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="text-center mt-5 text-muted">Nenhum aluno matriculado neste horário.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center mt-4 text-muted small">
        MaxSchool - Escola Arnaldo Antônio de Souza
    </footer>
</div>

</body>
</html>