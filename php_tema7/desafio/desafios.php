<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desafios PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        h2 {
            margin-top: 0;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .resultado {
            margin-top: 20px;
            background-color: #fff;
            padding: 10px;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Desafios PHP</h2>

        <?php
        // Incluir a página com as funções
        include 'funcoes_desafios.php';

        // Desafio 1
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nome']) && isset($_POST['sexo']) && isset($_POST['idade'])) {
            $nome = $_POST['nome'];
            $sexo = $_POST['sexo'];
            $idade = $_POST['idade'];

            $resultado_desafio1 = verificarAceitacao($nome, $sexo, $idade);
            echo "<div class='resultado'><strong>Resultado Desafio 1:</strong><br>$resultado_desafio1</div>";
        }
        ?>

        <h3>Desafio 1:</h3>
        <form method="post">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="sexo">Sexo:</label>
            <select id="sexo" name="sexo" required>
                <option value="masculino">Masculino</option>
                <option value="feminino">Feminino</option>
            </select>

            <label for="idade">Idade:</label>
            <input type="number" id="idade" name="idade" required>

            <input type="submit" value="Verificar Aceitação">
        </form>

        <?php
        // Desafio 2 - Ordenar números
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['numero1']) && isset($_POST['numero2']) && isset($_POST['numero3'])) {
            $numero1 = $_POST['numero1'];
            $numero2 = $_POST['numero2'];
            $numero3 = $_POST['numero3'];

            $resultado_desafio2 = ordenarNumeros($numero1, $numero2, $numero3);
            echo "<div class='resultado'><strong>Resultado Desafio 2:</strong><br>$resultado_desafio2</div>";
        }
        ?>

        <!-- Desafio 2 -->
        <h3>Desafio 2:</h3>
        <form method="post">
            <label for="numero1">Número 1:</label>
            <input type="number" id="numero1" name="numero1" required>

            <label for="numero2">Número 2:</label>
            <input type="number" id="numero2" name="numero2" required>

            <label for="numero3">Número 3:</label>
            <input type="number" id="numero3" name="numero3" required>

            <input type="submit" value="Ordenar Números">
        </form>

        <!-- Desafio 3 -->
        <?php
        // Desafio 3 - Calcular média
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nota1']) && isset($_POST['nota2']) && isset($_POST['nota3'])) {
            $nota1 = $_POST['nota1'];
            $nota2 = $_POST['nota2'];
            $nota3 = $_POST['nota3'];

            $resultado_desafio3 = calcularMediaAluno($nota1, $nota2, $nota3);
            echo "<div class='resultado'><strong>Resultado Desafio 3:</strong><br>$resultado_desafio3</div>";
        }
        ?>

        <h3>Desafio 3:</h3>
        <form method="post">
            <label for="nota1">Nota 1:</label>
            <input type="number" id="nota1" name="nota1" step="0.01" required>

            <label for="nota2">Nota 2:</label>
            <input type="number" id="nota2" name="nota2" step="0.01" required>

            <label for="nota3">Nota 3:</label>
            <input type="number" id="nota3" name="nota3" step="0.01" required>

            <input type="submit" value="Calcular Média">
        </form>
    </div>
</body>
</html>
