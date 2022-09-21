<?php
   class DataBase
   {
     private $host_name;
     private $db_name;
     private $db_login;
     private $db_password;
     
     public function __construct($host_name, $db_name, $db_login, $db_password)
     {
       $this->host_name = $host_name;
       $this->db_name = $db_name;
       $this->db_login = $db_login;
       $this->db_password = $db_password;
     }
       
     public function connect(){
       $db = new PDO('mysql:host='.$this->host_name.';dbname='.$this->db_name, $this->db_login, $this->db_password);
       session_start();
       return $db;
     }
   }

    class User{
        
        private $login;
        private $password;
      
        public function setLogin($login){
            $this->login = $login;
        }
        public function getLogin(){
            return $this->login;
        }
        public function setPassword($password){
            $this->password = $password;
        }
        public function getPassword(){
            return $this->password;
        }
    
    }

    abstract class Builder{
        protected $user;

        final public function getUser(){
            return $this->user;
        }

        public function buildUser(){
            $this->user = new User();
        }
    }

    class FormBuilder extends Builder{
        public function buildUser(){
            parent::buildUser();
            
            $this->user->setLogin($_POST["login"]);
            $this->user->setPassword(md5($_POST["password"]));
      
    }
}

    class VkBuilder extends Builder{
        public function buildUser(){
            parent::buildUser();
            
            if (!empty($_GET['code'])) {

                $params = array(
            
                    'client_id'     => '',
            
                    'client_secret' => '',
            
                    'redirect_uri'  => 'http://1laba/login.php',
            
                    'code'          => $_GET['code']
            
                );
            
                
            
                // Получение access_token
            
                $data = file_get_contents('https://oauth.vk.com/access_token?' . urldecode(http_build_query($params)));
                echo $data;
                $data = json_decode($data, true);
            
                if (!empty($data['access_token'])) {
            
                    // Получили email
            
                    $email = $data['email'];
                    
                    
            
                    // Получим данные пользователя
                    $params = array(
                        'v'            => '5.81',
                        'uids'         => $data['user_id'],
                        'access_token' => $data['access_token'],
                        'fields'       => 'photo_big',
                    );
            
             
            
                    $info = file_get_contents('https://api.vk.com/method/users.get?' . urldecode(http_build_query($params)));
                    $info = json_decode($info, true);	
            
                    
            
                    // echo $email;
            
                    // print_r($info["response"]["0"]);
                    $this->user->setLogin($email);
                    $this->user->setPassword(md5($info["response"]["0"]["first_name"]));
                }
            
            }
        }
    }

    class BdBuilder extends Builder{
        public function buildUser(){
            parent::buildUser();

            $sql = "SELECT name, password FROM users";
    
            $data_base = new DataBase('localhost','d95058y2_db', "root", "root");
            $db = $data_base->connect();
            
            $chk_login = $db->prepare($sql);
            
            $chk_login->execute();
            $row = $chk_login->fetch(PDO::FETCH_ASSOC);
            
            // print_r($row);
            $this->user->setLogin($row["name"]);
            $this->user->setPassword($row["password"]);
        }

    }
 
    $user = new FormBuilder();
    $user->buildUser();
    print_r($user);
    echo "<br>";
    $user = new VkBuilder();
    $user->buildUser();
    print_r($user);
    echo "<br>";
    $user = new BdBuilder();
    $user->buildUser();
    print_r($user);
    


?>