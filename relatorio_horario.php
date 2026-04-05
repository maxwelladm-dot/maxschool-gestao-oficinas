<?php
session_start();
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    exit;
}
include 'includes/db.php';

// Pegamos o dia e o turno que você quer imprimir (pode vir da URL)
$dia_filtro = isset($_GET['dia']) ? $_GET['dia'] : 'Segunda';
$turno_filtro = isset($_GET['turno']) ? $_GET['turno'] : 'Vespertino';

// Função para buscar alunos por bloco
function buscarAlunos($conn, $dia, $turno, $bloco) {
    $sql = "SELECT a.nome, a.ano, a.turma, o.nome_oficina 
            FROM oficinas o 
            JOIN alunos a ON o.aluno_id = a.id 
            WHERE o.dia_semana LIKE '%$dia%' 
            AND o.turno = '$turno' 
            AND o.bloco = '$bloco'
            ORDER BY a.nome ASC";
    return $conn->query($sql);
}

$bloco1 = buscarAlunos($conn, $dia_filtro, $turno_filtro, 'Bloco 1');
$bloco2 = buscarAlunos($conn, $dia_filtro, $turno_filtro, 'Bloco 2');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Alunos - MaxSchool</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: white; font-family: sans-serif; }
        .cabecalho { border-bottom: 2px solid #333; margin-bottom: 20px; padding-bottom: 10px; }
        .tabela-relatorio th { background-color: #f8f9fa !important; color: black !important; border: 1px solid #ddd; }
        .tabela-relatorio td { border: 1px solid #ddd; font-size: 14px; }
        @media print {
            .no-print { display: none; }
            .page-break { page-break-after: always; }
            body { margin: 0; padding: 20px; }
        }
    </style>
</head>
<body>

<div class="container py-4">
    <div class="no-print mb-4 text-center">
        <button onclick="window.print()" class="btn btn-primary btn-lg"><i class="bi bi-printer"></i> Imprimir Relatório</button>
        <a href="admin.php" class="btn btn-secondary btn-lg">Voltar ao Painel</a>
    </div>

    <div class="cabecalho text-center">
        <h2>ESCOLA ARNALDO ANTÔNIO</h2>
        <h4>Relatório de Alunos por Horário</h4>
        <p class="mb-0"><strong>Dia:</strong> <?php echo $dia_filtro; ?> | <strong>Turno:</strong> <?php echo $turno_filtro; ?></p>
    </div>

    <div class="mt-4">
        <h5 class="bg-dark text-white p-2 rounded">🟦 BLOCO 1 (Início do Turno)</h5>
        <table class="table tabela-relatorio table-striped">
            <thead>
                <tr>
                    <th width="5%">Nº</th>
                    <th width="50%">Nome do Aluno</th>
                    <th width="15%">Turma</th>
                    <th width="30%">Oficina</th>
                </tr>
            </thead>
            <tbody>
                <?php $n = 1; while($row = $bloco1->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $n++; ?></td>
                    <td><?php echo $row['nome']; ?></td>
                    <td><?php echo $row['ano']; ?>º <?php echo $row['turma']; ?></td>
                    <td><?php echo $row['nome_oficina']; ?></td>
                </tr>
                <?php endwhile; if($n == 1) echo "<tr><td colspan='4' class='text-center'>Nenhum aluno matriculado neste bloco.</td></tr>"; ?>
            </tbody>
        </table>
    </div>

    <div class="page-break"></div>

    <div class="mt-5">
        <h5 class="bg-primary text-white p-2 rounded">🟩 BLOCO 2 (Final do Turno)</h5>
        <table class="table tabela-relatorio table-striped">
            <thead>
                <tr>
                    <th width="5%">Nº</th>
                    <th width="50%">Nome do Aluno</th>
                    <th width="15%">Turma</th>
                    <th width="30%">Oficina</th>
                </tr>
            </thead>
            <tbody>
                <?php $n = 1; while($row = $bloco2->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $n++; ?></td>
                    <td><?php echo $row['nome']; ?></td>
                    <td><?php echo $row['ano']; ?>º <?php echo $row['turma']; ?></td>
                    <td><?php echo $row['nome_oficina']; ?></td>
                </tr>
                <?php endwhile; if($n == 1) echo "<tr><td colspan='4' class='text-center'>Nenhum aluno matriculado neste bloco.</td></tr>"; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-5 text-center small text-muted">
        <p>Relatório gerado pelo Sistema MaxSchool em <?php echo date('d/m/Y H:i'); ?></p>
    </div>
</div>

</body>
</html>