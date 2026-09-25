<?php
require "classe/Produto.class.php";

$p = new Produto();
$con = $p->conecta();

if (!$con) {
    echo "<script>alert('Erro ao conectar com o banco de dados!');</script>";
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('Produto inválido!');</script>";
    exit();
}

$id_produto = (int) $_GET['id'];
$dadosDoProduto = $p->buscarProduto($id_produto);

if (empty($dadosDoProduto)) {
    echo "<script>alert('Produto não encontrado!');</script>";
    exit();
}

$imagensDoProduto = $p->buscarImagens($id_produto);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/exibir.css">
    <title>Detalhes do Produto</title>
</head>

<body>
    <section>
        <a class="voltar" href="produto.php">← Voltar para produtos</a>

        <h1><?php echo htmlspecialchars($dadosDoProduto['nome_produto']); ?></h1>
        <h2>R$ <?php echo htmlspecialchars($dadosDoProduto['valor']); ?></h2>
        <p><b>Descrição:</b> <?php echo htmlspecialchars($dadosDoProduto['descricao']); ?></p>

        <div class="galeria">
            <?php foreach ($imagensDoProduto as $imagem) { ?>
                <div class="caixa_img">
                    <img src="imagens/<?php echo htmlspecialchars($imagem['nome_imagem']); ?>"
                        alt="<?php echo htmlspecialchars($dadosDoProduto['nome_produto']); ?>">
                </div>
            <?php } ?>
        </div>
    </section>
</body>

</html>