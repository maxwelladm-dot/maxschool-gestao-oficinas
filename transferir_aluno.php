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
$mensagem = "";

if (isset($_POST['transferir'])) {
    $id_matricula = $_POST['id_matricula'];
    $novo_dia     = $_POST['novo_dia'];
    $novo_bloco   = $_POST['novo_bloco'];
    $novo_turno   = $_POST['novo_turno'];

    $update = $conn->prepare("UPDATE oficinas SET dia_semana = ?, bloco = ?, turno = ? WHERE id = ?");
    $update->bind_param("sssi", $novo_dia, $novo_bloco, $novo_turno, $id_matricula);
    
    if ($update->execute()) {
        $mensagem = "<div class='alert alert-success border-0 shadow-sm'>✅ Transferência de <strong>" . $_POST['nome_aluno'] . "</strong> realizada!</div>";
    }
}

$sql = "SELECT o.id as id_mat, a.nome, a.ano, a.turma, o.nome_oficina, o.dia_semana, o.bloco, o.turno 
        FROM oficinas o 
        JOIN alunos a ON o.aluno_id = a.id 
        ORDER BY a.nome ASC";
$matriculas = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>MaxSchool - Transferências</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f0f2f5; font-family: 'Inter', sans-serif; }
        .search-box { border-radius: 20px; padding-left: 45px; border: 2px solid #dee2e6; transition: 0.3s; }
        .search-box:focus { border-color: #0d6efd; box-shadow: none; }
        .search-icon { position: absolute; left: 15px; top: 12px; color: #adb5bd; }
        .card-table { border-radius: 15px; border: none; overflow: hidden; }
        .table thead { background-color: #212529; color: white; }
        .row-aluno:hover { background-color: #f8f9fa; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-dark">🔄 Gestão de Transferências</h2>
        <p class="text-secondary">Mude os alunos da Escola Arnaldo Antônio entre blocos de horário</p>
    </div>

    <?php echo $mensagem; ?>

    <div class="row justify-content-center mb-4">
        <div class="col-md-6 position-relative">
            <i class="bi bi-search search-icon"></i>
            <input type="text" id="inputPesquisa" class="form-control form-control-lg search-box" placeholder="Pesquisar aluno pelo nome...">
        </div>
    </div>

    <div class="card card-table shadow">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="tabelaAlunos">
                <thead>
                    <tr class="text-center">
                        <th class="text-start ps-4">Aluno / Turma</th>
                        <th>Horário Atual</th>
                        <th>Novo Horário</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($m = $matriculas->fetch_assoc()): ?>
                    <tr class="row-aluno text-center align-middle">
                        <td class="text-start ps-4">
                            <div class="fw-bold text-primary"><?php echo htmlspecialchars($m['nome']); ?></div>
                            <small class="badge bg-light text-dark border"><?php echo $m['ano']; ?>º Ano - Turma <?php echo $m['turma']; ?></small>
                        </td>
                        <td>
                            <div class="small fw-bold text-muted"><?php echo $m['dia_semana']; ?></div>
                            <div class="small"><?php echo $m['turno']; ?> | <?php echo $m['bloco']; ?></div>
                        </td>
                        <td>
                            <form method="POST" class="d-flex flex-column gap-1">
                                <input type="hidden" name="id_matricula" value="<?php echo $m['id_mat']; ?>">
                                <input type="hidden" name="nome_aluno" value="<?php echo htmlspecialchars($m['nome']); ?>">
                                
                                <select name="novo_dia" class="form-select form-select-sm">
                                    <option value="Segunda-feira">Segunda-feira</option>
                                    <option value="Terça-feira">Terça-feira</option>
                                    <option value="Quarta-feira">Quarta-feira</option>
                                    <option value="Quinta-feira">Quinta-feira</option>
                                    <option value="Sexta-feira">Sexta-feira</option>
                                    <option value="Segunda e Quarta">Segunda e Quarta</option>
                                    <option value="Terça e Quinta">Terça e Quinta</option>
                                </select>
                                <div class="d-flex gap-1">
                                    <select name="novo_turno" class="form-select form-select-sm">
                                        <option value="Matutino" <?php echo ($m['turno'] == 'Matutino') ? 'selected' : ''; ?>>Manhã</option>
                                        <option value="Vespertino" <?php echo ($m['turno'] == 'Vespertino') ? 'selected' : ''; ?>>Tarde</option>
                                    </select>
                                    <select name="novo_bloco" class="form-select form-select-sm">
                                        <option value="Bloco 1">Bloco 1</option>
                                        <option value="Bloco 2">Bloco 2</option>
                                    </select>
                                </div>
                        </td>
                        <td>
                                <button type="submit" name="transferir" class="btn btn-primary btn-sm px-3 shadow-sm">
                                    <i class="bi bi-arrow-left-right"></i> Mudar
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="text-center mt-4">
        <a href="grade_horarios.php" class="btn btn-outline-secondary">Voltar para Grade Geral</a>
    </div>
</div>

<script>
    document.getElementById('inputPesquisa').addEventListener('keyup', function() {
        let filtro = this.value.toLowerCase();
        let linhas = document.getElementById('tabelaAlunos').getElementsByTagName('tr');

        for (let i = 1; i < linhas.length; i++) {
            let nome = linhas[i].getElementsByTagName('td')[0].innerText.toLowerCase();
            if (nome.includes(filtro)) {
                linhas[i].style.display = "";
            } else {
                linhas[i].style.display = "none";
            }
        }
    });
</script>

</body>
</html>