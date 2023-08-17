<?php

namespace app\model;

use app\core\Model;

/**
 * Classe responsável por gerenciar a conexão com a tabela user.
 */
class UserModel
{

    //Instância da classe model
    private $pdo;
    private $tableName = 'users';

    /**
     * Método construtor
     *
     * @return void
     */
    public function __construct()
    {
        $this->pdo = new Model();
    }

    /**
     * Insere um novo registro na tabela de users e retorna seu ID em caso de sucesso
     *
     * @param  Object $params Lista com os parâmetros a serem inseridos
     * @return int Retorna o ID do user inserido ou -1 em caso de erro
     */
    public function insert(object $params)
    {
        $sql = 'INSERT INTO users (name,role,email,password,created_at,updated_at) VALUES (:name,:role, :email,:password,now(),now())';

        $new_password = password_hash($params->password,PASSWORD_DEFAULT);

        $carteira = "wallet_".rand(1000,100000);
        $params = [

            ':name'    => $params->name,
            ':role' => 1,
            ':email' => $params->email,
            ':password' =>$new_password
        ];

        if (!$this->pdo->executeNonQuery($sql, $params))
            return -1; //Código de erro

        return $this->pdo->getLastID();
    }



    /**
     * Atualiza um registro na base de dados através do ID do user
     *
     * @param  Object $params Lista com os parâmetros a serem inseridos
     * @return bool True em caso de sucesso e false em caso de erro
     */
    public function update(object $params,$id)
    {
        $sql = 'UPDATE users SET name = :name, role = :role,email =:email,password =:password WHERE id = :id';
        
//var_dump($params);
        
        $params = [
            ':id'        => $id,
            ':name'      => $params->name,
            ':role'      => 1,
            ':email'      => $params->email,
            ':password'      => $params->password,
            
        ];

        return $this->pdo->executeNonQuery($sql, $params);
    }



        /**
     * Retorna um único registro da base de dados através do ID informado
     *
     * @param  int $id ID do objeto a ser retornado
     * @return object Retorna um objeto populado com os dados do produto ou se não encontrar com seus valores nulos
     */
    public function getById(int $id)
    {
        $sql = 'SELECT * FROM users as u u.id = :idUser';

        $param = [
            ':idUser' => $id
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
            'id'        => $param['id']        ?? null,
            'name'      => $param['name']      ?? null,
            
            
            'email' => $param['email'] ?? null,
            
            'password' => $param['password'] ?? null,
        ];
    }

}
