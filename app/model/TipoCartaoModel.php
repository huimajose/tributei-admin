<?php

namespace app\model;

use app\core\Model;

/**
 * Classe responsável por gerenciar a conexão com a tabela produto.
 */
class TipoCartaoModel
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

    public function getWallet()
    {
        //Excrevemos a consulta SQL e atribuimos a váriavel $sql
        $sql = 'SELECT * FROM tipowallet';

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

    /**
     * Retorna um único registro da base de dados através do ID informado
     *
     * @param  int $id ID do objeto a ser retornado
     * @return object Retorna um objeto populado com os dados do produto ou se não encontrar com seus valores nulos
     */
    public function getById(int $id)
    {
        $sql = 'SELECT w.idWallet,w.numero,w.expira,bn.code as banco,tw.nome as tipo, tw.limite as limite,c.code as moeda, tw.fundo FROM wallet as w inner join bancos as bn on bn.idBanco = w.banco inner join tipowallet as tw on tw.idTipoWallet = w.tipo inner join currency as c on c.currency_id = w.moeda WHERE owner = :idWallet';

        $param = [
            ':idWallet' => $id
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

    /**
     * Converte uma estrutura de array vinda da base de dados em um objeto devidamente tratado
     *
     * @param  array|object $param Revebe o parâmetro que é retornado na consulta com a base de dados
     * @return object Retorna um objeto devidamente tratado com a estrutura de produtos
     */
    private function collection($param)
    {
        return (object)[
            'idTipoWallet'        => $param['idTipoWallet']        ?? null,
            'nome'      => $param['nome']      ?? null,
            'limite'      => $param['limite']      ?? null,
            
           
        ];
    }
}
