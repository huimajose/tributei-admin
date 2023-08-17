<?php

namespace app\controller;

use app\core\Controller;
use app\model\PaymentModel;
use app\classes\Input;

use app\model\AccountModel;
use app\model\CardModel;
use app\model\CountryModel;
use app\model\BankModel;
use app\model\TipoCartaoModel;

use app\functions\GenerateCard;
use app\model\EstadoModel;
use app\model\ContaModel;

class PaymentController extends Controller
{

    //Instância da classe ProdutoModel
    private $paymentModel;
    //Instância da classe 
    private $accountModel;
    private $CardModel;
    private $CountryModel;
    private $BankModel;
    private $TipoCartaoModel;
    private $EstadoModel;
    private $ContaModel;


    /**
     * Método construtor
     *
     * @return void
     */
    public function __construct()
    {
        session_start();
        $this->paymentModel = new PaymentModel();
        $this->accountModel = new AccountModel();
        $this->CardModel = new CardModel();
        $this->CountryModel = new CountryModel();
        $this->BankModel = new BankModel();
        $this->TipoCartaoModel = new TipoCartaoModel();
        $this->EstadoModel = new EstadoModel();
        $this->ContaModel = new ContaModel();
    }

    /**
     * Carrega a página principal
     *
     * @return void
     */
    public function index()
    {
          
        $user = $this->accountModel->getById($_SESSION['userID']);
        $card = $this->CardModel->getById($_SESSION['userID']);
        //var_dump($card);
        //$numero = GenerateCard::gCard();
        $csv = GenerateCard::gPin();
        $saldo = $this->ContaModel->getSaldo($_SESSION['userID']);
        
       
        $this->load('payment/main',[
            'info' => $user,
            'cards'  => $card,
            'saldo'  => $saldo
        ]); 
       
    }

    /**
     * Carrega a página com o formulário para cadastrar um novo produto
     *
     * @return void
     */
    public function novo()
    {
        $this->load('produto/novo');
    }

    public function insert()
    {
        $payment = $this->getInput();

        /*
        if (!$this->validate($produto, false)) {
            return  $this->showMessage(
                'Formulário inválido', 
                'Os dados fornecidos são inválidos',
                BASE  . 'novo-produto/',
                422
            );
        }

        */
        $result = $this->PaymentModel->insert($payment);

        if ($result <= 0) {
            echo 'Erro ao efectuar o pagamento ou transferencia';
            die();
        }

        //redirect(BASE . 'editar-produto/' . $result);
    }



    

    /**
     * Realiza a busca na base de dados e exibe na página de resultados
     *
     * @return void
     */
    public function handler()
    {
        $payment = $this->getInput();
        $payment2 = $this->getInputDeposit();
        $result = $this->paymentModel->insert($payment); 


        $contaDB = $this->ContaModel->verificaSaldo($payment->de);
        //var_dump($contaDB->saldo);
        //var_dump($payment->para);

        //verifica se o numero de conta existe, se sim passa o proximo passo

            $destino = $this->ContaModel->getById($payment->para);

       

        if(is_null($destino->numero)){
            $_SESSION['msg'] = "O numero de conta não existe";
            redirect(BASE . 'account/payment/error');
        }else{
                 //verifica o saldo da conta de se for superior envia, senão envia erro

            if($contaDB->saldo >= $payment->valor){

                $resultadoActualizaSaldo = $this->ContaModel->updateSaldo($payment2); 
                $reduzirSaldo =  $this->ContaModel->reduzir($payment);
                
            }else{
                //print("O seu saldo não lhe permite efectuar a transferência");
                $_SESSION['msg'] = "O seu saldo é inferior";
                redirect(BASE . 'account/payment/error');
            }

        }
     
       
        
    
        $this->load('payment/sucess',[
            'payment' => $payment2,
        ]);
    }

    public function sucess()
    {
        $this->load('payment/sucess');
    }

    public function error(){
        $this->load('payment/error');
    }

    /**
     * Retorna os dados do formulário em uma classe padrão stdObject
     *
     * @return object
     */
    private function getInput()
    {

        return (object)[
            'id'        => Input::get('id', FILTER_SANITIZE_NUMBER_INT),
            'valor'      => Input::post('valor'),
            'de'    => Input::post('de'),
            'para' => Input::post('para')
        ];
    }


    private function getInputDeposit(){
        return (object)[
            
            'saldo'      => Input::post('valor'),
            'numero'      => Input::post('para'),
            
           
            
        ];
    }


    /**
     * Valida se os campos recebidos estão válidos
     *
     * @param  Object $produto
     * @param  bool $validateId
     * @return bool
     */
    private function validate(Object $produto, bool $validateId = true)
    {
        if ($validateId && $produto->id <= 0)
            return false;

        if (strlen($produto->nome) < 3)
            return false;

        if (strlen($produto->imagem) < 5)
            return false;

        if (strlen($produto->descricao) < 10)
            return false;

        return true;
    }
}
