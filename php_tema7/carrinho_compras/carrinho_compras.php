<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras</title>
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
        input[type="submit"], input[type="button"] {
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
        .carrinho-info {
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
            padding: 10px;
        }
        .carrinho-info h2 {
            margin-top: 0;
        }
        .carrinho-info pre {
            white-space: pre-wrap;
            word-wrap: break-word;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="conteudo-carrinho">
        <?php
        include 'funcoes_carrinho.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['adicionar'])) {
                $item = array(
                    'produto' => $_POST['produto'],
                    'preco' => $_POST['preco']
                );
                adicionarItem($item);
            } elseif (isset($_POST['remover'])) {
                $indice = $_POST['indice'];
                removerItem($indice);
            } elseif (isset($_POST['limpar'])) {
                $mensagem = limparCarrinho();
                echo "<div class='resultado'>$mensagem</div>";
            }
        }

        // Exibir o conteúdo do carrinho após as ações
        echo exibirConteudoCarrinho();

        if (isset($_SESSION['carrinho_compra'])) {
            echo "<h3>Itens no Carrinho:</h3>";
            foreach ($_SESSION['carrinho_compra'] as $indice => $item) {
                echo "<div>";
                echo "<strong>Produto:</strong> " . $item['produto'] . "<br>";
                echo "<strong>Preço:</strong> R$ " . number_format($item['preco'], 2, ',', '.') . "<br>";
                echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
                echo "<input type='hidden' name='indice' value='$indice'>";
                echo "<input type='submit' name='remover' value='Remover'>";
                echo "</form>";
                echo "</div>";
            }
            echo "<hr>";
            echo "<strong>Total: R$ " . number_format(calcularValorTotal(), 2, ',', '.') . "</strong>";
            echo "<br><br>";
        } else {
            echo "<p>Nenhum item no carrinho.</p>";
        }
        ?>
    </div>

    <h2>Carrinho de Compras</h2>

    <h3>Adicionar Item ao Carrinho:</h3>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="produto">Produto:</label>
        <input type="text" name="produto" id="produto" required>
        <label for="preco">Preço:</label>
        <input type="number" name="preco" id="preco" step="0.01" min="0" required>
        <input type="submit" name="adicionar" value="Adicionar">
    </form>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="submit" name="limpar" value="Limpar Carrinho">
    </form>
</div>

</body>
</html>
