<?php
namespace app\controller;

use app\core\Controller;
use Parse\ParseClient;
use Parse\ParseException;
use Parse\ParseUser; // Importe a classe ParseUser
use app\model\AccountModel;

class PagesController extends Controller
{

    private $accountModel;


        /**
     * Método construtor
     *
     * @return void
     */
    public function __construct()
    {
        session_start();
        $this->accountModel = new AccountModel();
       
    }

    public function home()
    {
    
        // Verificar se não há uma sessão ativa
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
            header('Location: login'); // Redirecionar para a página de login
            exit;
        }
        $profileComplete = $this->accountModel->isProfileComplete($_SESSION['user_id'],$_SESSION['username']);
    
        $this->load('home/main', ['username' => $_SESSION['username'], 'profileComplete' => $profileComplete]);
    }
    

    public function login()
    {
        if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
            header('Location: dashboard');
            exit;
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['email'];
            $password = $_POST['password'];
    
            if ($this->accountModel->login($username, $password)) {
                $user = ParseUser::getCurrentUser();
                $_SESSION['user_id'] = $user->getObjectId();
                $_SESSION['username'] = $username;
                header('Location: dashboard');
                exit;
            } else {
                echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Erro!",
                        text: "Senha incorreta. Por favor, tente novamente.",
                    });
                </script>';
            }
        }
    
        $this->load('home/login');
    }
    
    


    public function register()
    {
       
    
        // Verificar se há uma sessão ativa
        if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
            header('Location: dashboard'); // Redirecionar para o dashboard
            exit;
        }
    
        $this->load('home/signup');
    }
    
    


    public function entrada()
    {
        
        $this->load('home/entrada', ['username' => $_SESSION['username'], 'id' => $_SESSION['user_id']] );
    }

    public function saida()
    {
        
        $this->load('home/saida',  ['username' => $_SESSION['username']]);
    }

    public function simulacao()
    {
        
        $this->load('home/simulacao',  ['username' => $_SESSION['username']]);
    }

    public function logout(){

       
        session_destroy();
        
        header('Location: login');
    }

    public function complete()
    {
        
        $this->load('profile/complete',  ['username' => $_SESSION['username']]);
    }

    public function profile(){

        $this->load('profile/account',  ['username' => $_SESSION['username']]);
    }
}
