<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/produto.css">
    <title>Produtos</title>
</head>
<body>
    <section>
        <h1>Produtos</h1>
        <?php
        require "classe/Produto.class.php";

        $p = new Produto();
        $con = $p->conecta();

        if(!$con){
            echo "<script>alert('Erro ao conectar com o banco de dados!');</script>";
            exit();
        }else{
            $dadosProduto = $p->buscarProdutos();

            if(empty($dadosProduto)){
                echo "<script>alert('Não há produtos cadastrados!');</script>";
            }else{
                foreach($dadosProduto as $produto){
                    ?>
                    <a class="produto" href="exibir_produto.php?id=<?php echo $produto['id_produto']; ?>">
                        <div>
                            <?php if(!empty($produto['foto_capa'])){ ?>
                                <img src="imagens/<?php echo htmlspecialchars($produto['foto_capa']); ?>" alt="">
                            <?php } ?>
                            <h2><?php echo htmlspecialchars($produto['nome_produto']); ?></h2>
                            <p>R$ <?php echo htmlspecialchars($produto['valor']); ?></p>
                        </div>
                    </a>
                    <?php
                }
            }
        }
        ?>
    </section>
</body>
</html>
