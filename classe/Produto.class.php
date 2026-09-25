<?php
class Produto{
    private $id_produto;
    private $nome;
    private $descricao;
    private $valor;
    private $pdo;

    public function conecta(){
        try{
            $dns = "mysql:dbname=loja_etim;host=localhost";
            $dbUser = "root";
            $dbPass = "";
            $this->pdo = new PDO($dns, $dbUser, $dbPass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return true;
        }catch (\Throwable $th){
            return false;
        }
    }

    public function enviarProduto($nome, $descricao, $valor, $fotos = array()){
        // inserir produto na tabela produtos
        $sql = "INSERT INTO produtos SET descricao = :d, nome_produto = :n, valor = :v";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":d", $descricao);
        $sql->bindValue(":n", $nome);
        $sql->bindValue(":v", $valor);

        $isOk = $sql->execute();

        if($isOk){
            $id_produto = $this->pdo->lastInsertId();
        }else{
            return false;
        }

        if(count($fotos)){
            for($i = 0; $i < count($fotos); $i++){
                $nome_foto = $fotos[$i];

                $sql = "INSERT INTO imagens (nome_imagem, fk_id_produto) VALUES (:n, :fk)";
                $sql = $this->pdo->prepare($sql);
                $sql->bindValue(":n", $nome_foto);
                $sql->bindValue(":fk", $id_produto);

                if(!$sql->execute()){
                    return false;
                }
            }
        }

        return true;
    }

    public function buscarProdutos(){
        $sql = "(SELECT *, (SELECT nome_imagem FROM imagens WHERE fk_id_produto = produtos.id_produto LIMIT 1) AS foto_capa FROM produtos)";
        $sql = $this->pdo->query($sql);

        if($sql->rowCount() > 0){
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return array();
        }
    }

    public function buscarProduto($id_produto){
        $sql = "SELECT * FROM produtos WHERE id_produto = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id_produto);

        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetch(PDO::FETCH_ASSOC);
        }else{
            return array();
        }
    }

    // Necessário para a página de detalhes listar todas as imagens do produto.
    public function buscarImagens($id_produto){
        $sql = "SELECT * FROM imagens WHERE fk_id_produto = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id_produto);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return array();
        }
    }
}
