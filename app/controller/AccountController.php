<?php

namespace app\controller;

use app\core\Controller;
use app\model\AccountModel;
use app\model\CardModel;
use app\model\CountryModel;
use app\model\BankModel;
use app\model\TipoCartaoModel;
use app\classes\Input;
use app\functions\GenerateCard;
use app\model\EstadoModel;
use app\model\ContaModel;
use app\model\UserModel;

class AccountController extends Controller
{

    //Instância da classe ProdutoModel
    private $accountModel;
    private $CardModel;
    private $CountryModel;
    private $BankModel;
    private $TipoCartaoModel;
    private $EstadoModel;
    private $ContaModel;
    private $UserModel;

    /**
     * Método construtor
     *
     * @return void
     */
    public function __construct()
    {
        
        session_start();
        $this->accountModel = new AccountModel();
        $this->CardModel = new CardModel();
        $this->CountryModel = new CountryModel();
        $this->BankModel = new BankModel();
        $this->TipoCartaoModel = new TipoCartaoModel();
        $this->EstadoModel = new EstadoModel();
        $this->ContaModel = new ContaModel();
        $this->UserModel = new UserModel();
        
    }

    /**
     * Carrega a página principal
     *
     * @return void
     */
    public function index()
    {
        $this->checkLogged();

        
        $this->load('account/main');
    }

    /**
     * Carrega a página com o formulário para cadastrar um novo produto
     *
     * @return void
     */
    public function novo()
    {
        $this->load('account/novo');
    }

    public function insert()
    {
        $perfil = $this->getInput();

        
        if (!$this->validate($perfil, false)) {
            return  $this->showMessage(
                'Formulário inválido', 
                'Os dados fornecidos são inválidos',
                BASE  . 'register/',
                422
            );
        }

        $result = $this->UserModel->insert($perfil);

        if ($result <= 0) {
            echo 'Erro ao cadastrar nova conta';
            die();
        }

       session_start();
        $_SESSION['userID'] = $result;
        $user = $this->UserModel->getById($result);

       redirect(BASE . 'account/completar-perfil');
       
   
    }



    //update info

    public function completar()
    {
        $perfil = $this->getInput();

        //var_dump($perfil);
        $result = $this->UserModel->update($perfil,$_SESSION['userID']);  
        redirect(BASE . 'account/dashboard');
    }

    public function updateSettings(){
        $perfil = $this->getInputUpdate();



        var_dump($perfil);
        $result = $this->UserModel->updateSettings($perfil,$_SESSION['userID']);  
        redirect(BASE . 'account/profile');
    }

    public function profile()
    {      

        $user = $this->UserModel->getById($_SESSION['userID']);
        $card = $this->UserModel->getById($_SESSION['userID']);
        $saldo = $this->UserModel->getSaldo($_SESSION['userID']);
        
        $this->load('account/profile',[
            'info' => $user,
            'cards'  => $card,
            'saldo'  => $saldo
        ]); 
    }


    public function dashboard()
    {
        
        $user = $this->UserModel->getById($_SESSION['userID']);
        $card = $this->CardModel->getById($_SESSION['userID']);
        $saldo = $this->ContaModel->getSaldo($_SESSION['userID']);
        $csv = GenerateCard::gPin();
       
        $this->load('account/dashboard',[
            'info' => $user,
            'cards'  => $card,
            'saldo'  => $saldo
        ]); 
    }

    

    public function login()
    {
    
        $this->load('account/login');
    }


    public function logout(){

        session_destroy();
        
        redirect(BASE . 'account/login');
    }


    public function register()
    {
        $paises = $this->CountryModel->getCountry();
        $this->load('account/register',
    ['paises'=> $paises]);
    }



    private function getInputCreateAccount(){
        return (object)[
            
            'saldo'      => Input::post('saldo'),
            'tipo'      => Input::post('tipo'),
            'banco'      => Input::post('banco'),
            
           
            
        ];
    }

    public function addBank()
    {     
        $bancos = $this->BankModel->getBank();
        $tipoWallet = $this->TipoCartaoModel->getWallet(); 
        $user = $this->accountModel->getById($_SESSION['userID']);
        $card = $this->CardModel->getById($_SESSION['userID']);
        
        $csv = GenerateCard::gPin();

        /*

        $Contagerada = $this->getInputCreateAccount();

        $bank = Input::post('banco');
       $numeroCartao = GenerateCard::gAccount();
        $gerarConta = $this->ContaModel->insert($Contagerada,$_SESSION['userID'], $numeroCartao,$bank);
      
        if ($gerarConta <= 0) {
            echo 'Erro ao cadastrar nova conta';
            die();
        }

        /**
         * gerando conta (numero,owner,saldo,banco,criada,moeda)
         * 
         * gerando wallet(numercoCartão,csv,pin,criado,expira,tipowallet,banco,estado,moeda,account)
         * 
         * */

        
        $saldo = $this->ContaModel->getSaldo($_SESSION['userID']);
        
        $this->load('account/add-bank',[
            'info' => $user,
            'cards'  => $card,
            'bancos' => $bancos,
            'wallets' => $tipoWallet,
            'saldo'  => $saldo
        ]);
    }


    public function successBank(){
        $bancos = $this->BankModel->getBank();
        $tipoWallet = $this->TipoCartaoModel->getWallet(); 
        $user = $this->accountModel->getById($_SESSION['userID']);
        $card = $this->CardModel->getById($_SESSION['userID']);
        
        $csv = GenerateCard::gCsv();

        $conta = GenerateCard::gAccount();
        //var_dump($numero);
        $pin = GenerateCard::gPin();

        $Contagerada = $this->getInputCreateAccount();
        $wallet = $this->getWalletInput();
        $numeroCartao = GenerateCard::gAccount();

        //$gerarConta = $this->ContaModel->insert($Contagerada);
        $gerarConta = $this->ContaModel->insert($Contagerada,$_SESSION['userID'], $numeroCartao);
      
        //var_dump($Contagerada);
        if ($gerarConta <= 0) {
            echo 'Erro ao cadastrar nova conta';
            die();
        }

        $numeroCard = GenerateCard::gCard();
        //criar e associar cartão a uma conta
        //gerando wallet(numercoCartão,csv,pin,criado,expira,tipowallet,banco,estado,moeda,account)
        $gerarCartao = $this->CardModel->insert($wallet,$_SESSION['userID'],$numeroCard,$csv,$pin,$gerarConta);

        if ($gerarCartao <= 0) {
            echo 'Erro ao cadastrar nova conta';
            die();
        }

        $this->load('account/success-add-bank',[
            'info' => $user,
            'card'  => $card,
            'bancos' => $bancos,
            'wallets' => $tipoWallet
        ]);
    }
    /**
     * Realiza a busca na base de dados e exibe na página de resultados
     *
     * @return void
     */
    public function pesquisar()
    {
        $param = Input::get('pes');

        $this->load('produto/pesquisa', [
            'termo' => $param
        ]);
    }

    public function editar()
    {
       
       $user = $this->accountModel->getById($_SESSION['userID']);
 
        
        $this->load('account/editar', [
            'user'  => $user,
            'perfil'  => 'testee',
        ]);
    }

    /**
     * Retorna os dados do formulário em uma classe padrão stdObject
     *
     * @return object
     */
    private function getInput()
    {

        return (object)[
            'name'      => Input::post('txtName'),
            'email'      => Input::post('txtEmail'),
            'password'      => Input::post('txtPassword'),
            
        ];
    }


        /**
     * Retorna os dados do formulário em uma classe padrão stdObject
     *
     * @return object
     */
    private function getWalletInput()
    {

        return (object)[
            'banco'      => Input::post('banco'),
            'tipo'      => Input::post('tipo'),
            
        ];
    }

    private function getInputLogin(){
        return (object)[
            
            'username'      => Input::post('txtUsername'),
            'password'      => Input::post('txtPassword'),
            
        ];
    }

    private function getInputDeposit(){
        return (object)[
            
            'saldo'      => Input::post('saldo'),
            'numero'      => Input::post('numero'),
            
           
            
        ];
    }



    private function getInputUpdate()
    {

        return (object)[
            
            'pnome'      => Input::post('pnome'),
            'unome'      => Input::post('unome'),
            'username'      => Input::post('username'),
            'pais'      => Input::post('pais'),
            'morada'      => Input::post('morada'),
            'telefone'      => Input::post('telefone'),
            'email'      => Input::post('email'),
            'bio'      => Input::post('bio'),
            'identificacao'      => Input::post('identificacao'),
            
            
        ];
    }

    /**
     * Valida se os campos recebidos estão válidos
     *
     * @param  Object $produto
     * @param  bool $validateId
     * @return bool
     */
    private function validate(Object $perfil, bool $validateId = true)
    {
        if ($validateId && $perfil->id <= 0)
            return false;


        if (strlen($perfil->name) < 3)
            return false;

        if (strlen($perfil->email) < 3)
            return false;

        if (strlen($perfil->password) < 2)
            return false;

        return true;
    }


    public function generate(){

        $numero = GenerateCard::gCard();
    }

    public function settings()
    {
        $user = $this->accountModel->getById($_SESSION['userID']);
        $paises = $this->CountryModel->getCountry();
        $estadoCivil = $this->EstadoModel->getEstadoCivil();

        
       
        $saldo = $this->ContaModel->getSaldo($_SESSION['userID']);
    

        //var_dump($paises);
        $this->load('account/settings',[
            'info' => $user,
            'paises' => $paises,
            'estadoCivil' => $estadoCivil,
            'saldo'  => $saldo
        ]); 
    }


    public function depositar(){

        
        $user = $this->accountModel->getById($_SESSION['userID']);
        $card = $this->CardModel->getById($_SESSION['userID']);
        //var_dump($card);
        //$numero = GenerateCard::gCard();
        $csv = GenerateCard::gPin();
        $saldo = $this->ContaModel->getSaldo($_SESSION['userID']);
        
       
        $this->load('account/add-money',[
            'info' => $user,
            'cards'  => $card,
            'saldo'  => $saldo
        ]); 
       
    }


    public function addMoney(){

        $card = $this->getInputDeposit();
        

        
        $result = $this->ContaModel->updateSaldo($card); 
        //var_dump($card);
        $this->load('account/sucesso-deposit',[
            'cards'  => $card
        ]); 
    }

}
