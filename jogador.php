<?php
class Jogador{
    private $pdo;
    /*CONEXAO COM O BANCO DE DADOS */
    public function __construct($dbname,$host,$user,$senha)
    {
        try{
            $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$senha);
        }
        catch(PDOException $e){
            echo "Erro no BD: ". $e->getMessage();
        }
        catch(Exception $e){
            echo "Erro no geral: ". $e->getMessage();
        }
    }
   
}
?>