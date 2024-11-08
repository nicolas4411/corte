<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

include 'conexao.php';

// Adicionar nova questão
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adicionar'])) {
    $assunto = $_POST['assunto'];
    $enunciado = $_POST['enunciado'];
    $alternativa1 = $_POST['alternativa1'];
    $alternativa2 = $_POST['alternativa2'];
    $alternativa3 = $_POST['alternativa3'];
    $alternativa4 = $_POST['alternativa4'];
    $alternativa5 = $_POST['alternativa5'];
    $alternativa_correta = $_POST['alternativa_correta'];

    $sql = "INSERT INTO questoes (assunto, enunciado, alternativa1, alternativa2, alternativa3, alternativa4, alternativa5, alternativa_correta)
            VALUES ('$assunto', '$enunciado', '$alternativa1', '$alternativa2', '$alternativa3', '$alternativa4', '$alternativa5', '$alternativa_correta')";

    if ($conexao->query($sql) === TRUE) {
        echo "Questão adicionada com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conexao->error;
    }
}

// Editar questão existente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])) {
    $id = $_POST['id'];
    $assunto = $_POST['assunto'];
    $enunciado = $_POST['enunciado'];
    $alternativa1 = $_POST['alternativa1'];
    $alternativa2 = $_POST['alternativa2'];
    $alternativa3 = $_POST['alternativa3'];
    $alternativa4 = $_POST['alternativa4'];
    $alternativa5 = $_POST['alternativa5'];
    $alternativa_correta = $_POST['alternativa_correta'];

    $sql = "UPDATE questoes SET assunto='$assunto', enunciado='$enunciado', alternativa1='$alternativa1', alternativa2='$alternativa2',
            alternativa3='$alternativa3', alternativa4='$alternativa4', alternativa5='$alternativa5',
            alternativa_correta='$alternativa_correta' WHERE id=$id";

    if ($conexao->query($sql) === TRUE) {
        echo "Questão atualizada com sucesso!";
        header("Location: aplicacao.php");
        exit();
    } else {
        echo "Erro: " . $sql . "<br>" . $conexao->error;
    }
}

// Deletar questão
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deletar'])) {
    $id = $_POST['id'];
    $conexao->query("DELETE FROM questoes WHERE id=$id");
    header("Location: aplicacao.php");
    exit();
}

// Obter assuntos únicos para o filtro
$assuntos_resultado = $conexao->query("SELECT DISTINCT assunto FROM questoes");

// Filtro de assunto
$filtro_assunto = '';
if (isset($_POST['filtro_assunto'])) {
    $filtro_assunto = $_POST['filtro_assunto'];
}

// Obter todas as questões, aplicando filtro se necessário
$sql = "SELECT * FROM questoes";
if ($filtro_assunto) {
    $sql .= " WHERE assunto = '$filtro_assunto'";
}
$resultado = $conexao->query($sql);

// Carregar dados da questão para edição
$questao = null;
if (isset($_POST['load_editar'])) {
    $id = $_POST['id'];
    $questao = $conexao->query("SELECT * FROM questoes WHERE id=$id")->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Banco de Questões</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            padding: 10px;
            background-color: #f4f4f9;
            color: #333;
            padding-bottom: 50px;
            /* Garantir espaço para o botão flutuante */
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .formulario {
            background-color: #fff;
            padding: 20px;
            margin: auto;
            border-radius: 8px;
            max-width: 600px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .formulario label,
        .formulario input,
        .formulario button,
        .formulario select {
            width: 100%;
            margin: 5px 0;
            padding: 10px;
            font-size: 1em;
        }

        .formulario input[type="text"],
        .formulario input[type="number"],
        .formulario select {
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .formulario button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .formulario button:hover {
            background-color: #45a049;
        }

        .tabela {
            width: 100%;
            overflow-x: auto;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size: 0.9em;
            word-break: break-word;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        td a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
            margin-right: 10px;
        }

        td a:hover {
            text-decoration: underline;
        }

        .alternativas {
            padding-left: 15px;
            font-style: italic;
            color: #555;
        }

        .voltar-link {
            position: fixed;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 1em;
            z-index: 1000;
            /* Garante que o link fique acima de outros elementos */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .voltar-link:hover {
            background-color: #45a049;
        }

        @media (max-width: 768px) {

            .formulario,
            table,
            th,
            td {
                font-size: 0.9em;
            }

            .tabela {
                display: block;
                overflow-x: auto;
            }

            table {
                display: inline-block;
                min-width: 100%;
            }
        }
    </style>
    <script>
        function confirmarExclusao() {
            return confirm("Tem certeza que deseja excluir esta questão?");
        }
    </script>
</head>

<body>

    <h1>Banco de Questões</h1>

    <div class="formulario">
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $questao['id'] ?? ''; ?>">

            <label>Assunto:</label>
            <input type="text" name="assunto" value="<?php echo $questao['assunto'] ?? ''; ?>" required>

            <label>Enunciado:</label>
            <input type="text" name="enunciado" value="<?php echo $questao['enunciado'] ?? ''; ?>" required>

            <label>Alternativa 1:</label>
            <input type="text" name="alternativa1" value="<?php echo $questao['alternativa1'] ?? ''; ?>" required>

            <label>Alternativa 2:</label>
            <input type="text" name="alternativa2" value="<?php echo $questao['alternativa2'] ?? ''; ?>" required>

            <label>Alternativa 3:</label>
            <input type="text" name="alternativa3" value="<?php echo $questao['alternativa3'] ?? ''; ?>" required>

            <label>Alternativa 4:</label>
            <input type="text" name="alternativa4" value="<?php echo $questao['alternativa4'] ?? ''; ?>" required>

            <label>Alternativa 5:</label>
            <input type="text" name="alternativa5" value="<?php echo $questao['alternativa5'] ?? ''; ?>" required>

            <label>Alternativa Correta (1-5):</label>
            <input type="number" name="alternativa_correta" min="1" max="5" value="<?php echo $questao['alternativa_correta'] ?? ''; ?>" required>

            <button type="submit" name="<?php echo $questao ? 'editar' : 'adicionar'; ?>">
                <?php echo $questao ? 'Salvar Alterações' : 'Adicionar Questão'; ?>
            </button>
        </form>
    </div>

    <div class="formulario" style="margin-top: 20px;">
        <form method="POST">
            <label for="filtro_assunto">Filtrar por Assunto:</label>
            <select name="filtro_assunto" id="filtro_assunto">
                <option value="">Todos</option>
                <?php while ($assunto = $assuntos_resultado->fetch_assoc()) : ?>
                    <option value="<?php echo $assunto['assunto']; ?>" <?php echo ($assunto['assunto'] == $filtro_assunto) ? 'selected' : ''; ?>>
                        <?php echo $assunto['assunto']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <button type="submit">Filtrar</button>
        </form>
    </div>

    <div class="tabela">
        <table>
            <tr>
                <th>ID</th>
                <th>Assunto</th>
                <th>Enunciado</th>
                <th>Alternativa Correta</th>
                <th>Ações</th>
            </tr>
            <?php while ($linha = $resultado->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $linha['id']; ?></td>
                    <td><?php echo $linha['assunto']; ?></td>
                    <td>
                        <strong><?php echo $linha['enunciado']; ?></strong>
                        <div class="alternativas">
                            1. <?php echo $linha['alternativa1']; ?><br>
                            2. <?php echo $linha['alternativa2']; ?><br>
                            3. <?php echo $linha['alternativa3']; ?><br>
                            4. <?php echo $linha['alternativa4']; ?><br>
                            5. <?php echo $linha['alternativa5']; ?>
                        </div>
                    </td>
                    <td><?php echo $linha['alternativa_correta']; ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $linha['id']; ?>">
                            <button type="submit" name="load_editar">Editar</button>
                        </form>
                        <form method="POST" style="display:inline;" onsubmit="return confirmarExclusao();">
                            <input type="hidden" name="id" value="<?php echo $linha['id']; ?>">
                            <button type="submit" name="deletar">Deletar</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <a href="pagina_principal.php" class="voltar-link">Voltar à Página Principal</a>

</body>

</html>

<?php
$conexao->close();
?>