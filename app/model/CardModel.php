<?php

namespace app\model;

use app\core\Model;

/**
 * Classe responsável por gerenciar a conexão com a tabela produto.
 */
class CardModel
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

    /**
     * Retorna um único registro da base de dados através do ID informado
     *
     * @param  int $id ID do objeto a ser retornado
     * @return object Retorna um objeto populado com os dados do produto ou se não encontrar com seus valores nulos
     */
    public function getById(int $id)
    {
        $sql = 'SELECT w.idWallet,w.numero,w.expira,bn.code as banco,tw.nome as tipo, tw.limite as limite,c.code as moeda, tw.fundo,cont.saldo,cont.numero as conta FROM wallet as w inner join bancos as bn on bn.idBanco = w.banco inner join tipowallet as tw on tw.idTipoWallet = w.tipo inner join currency as c on c.currency_id = w.moeda inner join contas as cont on w.account = cont.idConta WHERE w.owner = :idWallet and w.estado = 1';

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




    public function insert(object $params,$owner,$numero,$csv,$pin,$conta)
    {
        $sql = 'INSERT INTO wallet (owner,numero,csv,pin,criado,expira,tipo,banco,estado,moeda,account) VALUES (:owner,:numero,:csv,:pin,now(),:expira,:tipo,:banco,:estado,:moeda,:account)';

        $params = [
            ':owner'=> $owner,
            ':numero'=> $numero,
            ':csv' => $csv,
            ':pin' => $pin,
            ':tipo'=> $params->tipo,
            ':expira'=> '2024-04-01',
            ':banco'=> $params->banco,
            ':estado'=> 1,
            ':moeda'=> 4,
            ':account'=> $conta,
            
            
        ];

        if (!$this->pdo->executeNonQuery($sql, $params))
            return -1; //Código de erro

        return $this->pdo->getLastID();
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
            'idWallet'        => $param['idWallet']        ?? null,
            'numero'      => $param['numero']      ?? null,
            'expira'      => $param['expira']      ?? null,
            'banco'      => $param['banco']      ?? null,
            'tipo'    => $param['tipo']    ?? null,
            'limite'    => $param['limite']    ?? null,
            'moeda'    => $param['moeda']    ?? null,
            'fundo'    => $param['fundo']    ?? null,
            'saldo'    => $param['saldo']    ?? null,
            'conta'    => $param['conta']    ?? null,
           
        ];
    }
}
