<?php 
session_start();
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    exit;
}
include 'includes/db.php'; 
$mensagem = "";

// Processamento da Matrícula em Massa
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['alunos_selecionados'])) {
    $oficina     = $_POST['nome_oficina'];
    $bloco       = $_POST['bloco'];
    $turno       = $_POST['turno'];
    $alunos_ids  = $_POST['alunos_selecionados']; // Array de IDs
    
    if (isset($_POST['dias']) && is_array($_POST['dias'])) {
        $dia_semana = implode(", ", $_POST['dias']);
    } else {
        $dia_semana = "";
    }

    if (empty($dia_semana)) {
        $mensagem = "<div class='alert alert-warning'>⚠️ Selecione os dias da semana!</div>";
    } else {
        $sucesso = 0;
        $stmt = $conn->prepare("INSERT INTO oficinas (nome_oficina, aluno_id, dia_semana, bloco, turno) VALUES (?, ?, ?, ?, ?)");
        
        foreach ($alunos_ids as $id) {
            $stmt->bind_param("sisss", $oficina, $id, $dia_semana, $bloco, $turno);
            if ($stmt->execute()) $sucesso++;
        }
        $mensagem = "<div class='alert alert-success'>✅ $sucesso alunos matriculados em <strong>$oficina</strong> para <strong>$dia_semana</strong>!</div>";
    }
}

// Busca todos os alunos para listar
$alunos_res = $conn->query("SELECT id, nome, ano, turma, turno FROM alunos ORDER BY nome ASC");
$todos_alunos = [];
while($row = $alunos_res->fetch_assoc()) { $todos_alunos[] = $row; }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Matrícula em Massa - MaxSchool</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f7f6; }
        .card-bulk { border-radius: 15px; border: none; }
        .lista-alunos { max-height: 300px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 8px; background: white; }
        .aluno-row:hover { background: #f8f9fa; }
    </style>
</head>
<body>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card card-bulk shadow">
                <div class="card-header bg-dark text-white p-3 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">📝 Matrícula Coletiva</h4>
                    <a href="admin.php" class="btn btn-sm btn-outline-light">Voltar ao Painel</a>
                </div>
                <div class="card-body p-4">
                    <?php echo $mensagem; ?>

                    <form method="POST" id="formMatricula">
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">1. Filtrar por Turma:</label>
                                <select id="filtro_turma" class="form-select bg-light fw-bold" onchange="filtrarAlunos()">
                                    <option value="todos">-- Todas as Turmas --</option>
                                    <option value="3A">3º Ano A</option>
                                    <option value="3B">3º Ano B</option>
                                    <option value="4A">4º Ano A</option>
                                    <option value="5A">5º Ano A</option>
                                </select>
                            </div>
                            
                            <div class="col-md-4">
                                <label class="form-label fw-bold">2. Oficina:</label>
                                <select name="nome_oficina" class="form-select" required>
                                    <option value="Informática">Informática/Robótica</option>
                                    <option value="Futsal">Futsal</option>
                                    <option value="Horta">Horta</option>
                                    <option value="Arte">Arte</option>
                                    <option value="Flauta e Canto">Flauta e Canto</option>
                                    <option value="Recomposição">Recomposição</option>
                                </select>
                            </div>

                            <div class="col-md-4 text-end align-self-end">
                                <button type="button" class="btn btn-sm btn-secondary" onclick="marcarTodos(true)">Marcar Todos Visíveis</button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">3. Selecione os Alunos:</label>
                            <div class="lista-alunos" id="lista_alunos">
                                <?php foreach($todos_alunos as $al): 
                                    $chave_turma = $al['ano'] . $al['turma']; // Ex: 3A
                                ?>
                                    <div class="aluno-row p-2 border-bottom" data-turma="<?php echo $chave_turma; ?>">
                                        <input class="form-check-input check-aluno" type="checkbox" name="alunos_selecionados[]" value="<?php echo $al['id']; ?>" id="aluno_<?php echo $al['id']; ?>">
                                        <label class="form-check-label ms-2" for="aluno_<?php echo $al['id']; ?>">
                                            <strong><?php echo $al['nome']; ?></strong> (<?php echo $al['ano']; ?>º <?php echo $al['turma']; ?> - <?php echo $al['turno']; ?>)
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="row bg-light p-3 rounded mb-4">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Dias:</label><br>
                                <div class="btn-group btn-group-sm" role="group">
                                    <input type="checkbox" class="btn-check" name="dias[]" value="Segunda" id="d1"><label class="btn btn-outline-primary" for="d1">Seg</label>
                                    <input type="checkbox" class="btn-check" name="dias[]" value="Terça" id="d2"><label class="btn btn-outline-primary" for="d2">Ter</label>
                                    <input type="checkbox" class="btn-check" name="dias[]" value="Quarta" id="d3"><label class="btn btn-outline-primary" for="d3">Qua</label>
                                    <input type="checkbox" class="btn-check" name="dias[]" value="Quinta" id="d4"><label class="btn btn-outline-primary" for="d4">Qui</label>
                                    <input type="checkbox" class="btn-check" name="dias[]" value="Sexta" id="d5"><label class="btn btn-outline-primary" for="d5">Sex</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Bloco:</label>
                                <select name="bloco" class="form-select">
                                    <option value="Bloco 1">Bloco 1 (14:00)</option>
                                    <option value="Bloco 2">Bloco 2 (15:45)</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Turno:</label>
                                <select name="turno" class="form-select">
                                    <option value="Vespertino">Vespertino</option>
                                    <option value="Matutino">Matutino</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100 fw-bold py-3 shadow-sm">
                            <i class="bi bi-person-check-fill"></i> MATRICULAR ALUNOS SELECIONADOS
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function filtrarAlunos() {
    let turma = document.getElementById('filtro_turma').value;
    let rows = document.querySelectorAll('.aluno-row');
    
    rows.forEach(row => {
        if (turma === 'todos' || row.getAttribute('data-turma') === turma) {
            row.style.display = 'block';
        } else {
            row.style.display = 'none';
            row.querySelector('.check-aluno').checked = false; // Desmarca se sumir
        }
    });
}

function marcarTodos(status) {
    let rows = document.querySelectorAll('.aluno-row');
    rows.forEach(row => {
        if (row.style.display !== 'none') {
            row.querySelector('.check-aluno').checked = status;
        }
    });
}
</script>

</body>
</html>