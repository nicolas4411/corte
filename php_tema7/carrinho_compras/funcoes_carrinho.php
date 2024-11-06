<?php

session_start();

function adicionarItem($item) {
    if (!isset($_SESSION['carrinho_compra'])) {
        $_SESSION['carrinho_compra'] = array();
    }
    
    $_SESSION['carrinho_compra'][] = $item;
}

function removerItem($indice) {
    if (isset($_SESSION['carrinho_compra'][$indice])) {
        unset($_SESSION['carrinho_compra'][$indice]);
        $_SESSION['carrinho_compra'] = array_values($_SESSION['carrinho_compra']);
    }
}

function limparCarrinho() {
    unset($_SESSION['carrinho_compra']);
    return "Carrinho limpo.";
}

function calcularValorTotal() {
    $total = 0;
    if (isset($_SESSION['carrinho_compra'])) {
        foreach ($_SESSION['carrinho_compra'] as $item) {
            $total += $item['preco'];
        }
    }
    return $total;
}

function exibirConteudoCarrinho() {
    $conteudo = "<div class='carrinho-info'>";
    $conteudo .= "<h2>Conteúdo do Carrinho:</h2>";
    if (isset($_SESSION['carrinho_compra'])) {
        foreach ($_SESSION['carrinho_compra'] as $item) {
            $conteudo .= "<pre>";
            $conteudo .= print_r($item, true);
            $conteudo .= "</pre>";
        }
    } else {
        $conteudo .= "<p>Nenhum item no carrinho.</p>";
    }
    $conteudo .= "</div>";
    return $conteudo;
}

?>
