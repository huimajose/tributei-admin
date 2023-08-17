<?php

namespace app\model;

use app\core\Model;

/**
 * Classe responsável por gerenciar a conexão com a tabela produto.
 */
class ContaModel
{

    //Instância da classe model
    private $pdo;

    /**
     * Método construtor
     *
     * @return void
     */
    public function __construct()
    {
        $this->pdo = new Model();
    }

    public function getAll()
    {
        //Excrevemos a consulta SQL e atribuimos a váriavel $sql
        $sql = 'SELECT * FROM wallet';

        //Executamos a consulta chamando o método da modelo. Atribuimos o resultado a variável $dr
        $dt = $this->pdo->executeQuery($sql);

        //Declara uma lista inicialmente nula
        $listaProduto = null;

        //Percorremos todas as linhas do resultado da busca
        foreach ($dt as $dr)
            //Atribuimos a última posição do array o produto devidamente tratado
            $listaProduto[] = $this->collection($dr);

        //Retornamos a lista de produtos
        return $listaProduto;
    }


    public function getSaldo(int $id){

        $sql = 'SELECT sum(saldo) as saldo from contas where owner = :idOwner';

        $param = [
            ':idOwner' => $id
        ];

        $dr = $this->pdo->executeQueryOneRow($sql, $param);

        return $this->collection($dr);
    }

    /**
     * Retorna um único registro da base de dados através do ID informado
     *
     * @param  int $id ID do objeto a ser retornado
     * @return object Retorna um objeto populado com os dados do produto ou se não encontrar com seus valores nulos
     */
    public function getByConta(int $id)
    {
        $sql = 'SELECT * from wallet where account = :idCard';

        $param = [
            ':idCard' => $id
        ];

        //Executamos a consulta chamando o método da modelo. Atribuimos o resultado a variável $dr
        $dt = $this->pdo->executeQuery($sql,$param);

        //Declara uma lista inicialmente nula
        $listaProduto = null;

        //Percorremos todas as linhas do resultado da busca
        foreach ($dt as $dr)
            //Atribuimos a última posição do array o produto devidamente tratado
            $listaProduto[] = $this->collection($dr);

        //Retornamos a lista de produtos
        return $listaProduto;
    }

    public function updateSaldo(object $params)
    {
        //aumenta o valor do saldo com valor da transação
        $sql = 'UPDATE contas SET saldo = saldo + :saldo WHERE numero = :numero';
       
        
//var_dump($params);
        
        $params = [
            ':numero'        => $params->numero,
            ':saldo'      => $params->saldo,    
        ];

        return $this->pdo->executeNonQuery($sql, $params);

        

    }


    public function reduzir(object $params){

        $sqlReduzir = "UPDATE contas SET saldo = saldo - :saldo WHERE numero = :numero";

        $params = [
            ':numero'        => $params->de,
            ':saldo'      => $params->valor,    
        ];
        return $this->pdo->executeNonQuery($sqlReduzir, $params);
    }



    //verificar o saldo de conta
    public function verificaSaldo($conta){

        $sql = 'SELECT saldo from contas where numero = :conta';

        $param = [
            ':conta' => $conta
        ];

        $dr = $this->pdo->executeQueryOneRow($sql, $param);

        return $this->collection($dr);
    }



        /**
     * Insere um novo registro na tabela de produtos e retorna seu ID em caso de sucesso
     *
     * @param  Object $params Lista com os parâmetros a serem inseridos
     * @return int Retorna o ID do produto inserido ou -1 em caso de erro
     */
    public function insert(object $params,$owner,$numero)
    {
        $sql = 'INSERT INTO contas (numero, owner, saldo,banco,criada,moeda) VALUES (:numero, :owner, :saldo,:banco,now(),4)';

        $params = [
            ':numero'      => $numero,
            ':owner'    => $owner,
            ':saldo' => $params->saldo,
            ':banco' => $params->banco,
            
        ];

        if (!$this->pdo->executeNonQuery($sql, $params))
            return -1; //Código de erro

        return $this->pdo->getLastID();
    }



    public function getById(int $id)
    {
        $sql = 'SELECT * FROM contas WHERE numero = :numero';

        $param = [
            ':numero' => $id
        ];

        $dr = $this->pdo->executeQueryOneRow($sql, $param);

        return $this->collection($dr);
    }



    /**
     * Converte uma estrutura de array vinda da base de dados em um objeto devidamente tratado
     *
     * @param  array|object $param Revebe o parâmetro que é retornado na consulta com a base de dados
     * @return object Retorna um objeto devidamente tratado com a estrutura de produtos
     */
    private function collection($param)
    {
        return (object)[
            'idConta'        => $param['idConta']        ?? null,
            'numero'      => $param['numero']      ?? null,
            'owner'      => $param['owner']      ?? null,
            'saldo'      => $param['saldo']      ?? null,
            'banco'    => $param['banco']    ?? null,
            'criada'    => $param['criada']    ?? null,
            'moeda'    => $param['moeda']    ?? null,
           
        ];
    }
}
