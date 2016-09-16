<?php
namespace model;
use PDO;

class SPDO{
  private $PDOInstance = null;  
  private static $instance = null;

  public function __construct($host, $user, $password, $dbName){
          $this->PDOInstance = new PDO('mysql:dbname='.$dbName.';host='.$host, $user , $password);
  }
  
  public static function getInstance(){
    if(is_null(self::$instance)){
        $ini_array = parse_ini_file('config.ini');
        self::$instance = new SPDO($ini_array['dbHost'], $ini_array['dbUser'], $ini_array['dbPassword'], $ini_array['dbName']);
    }
    return self::$instance;
  }
  
  public function query($query, $bind = null, $fetch = null, $fetchStyle = null, $fetchParam = null){
      try {
          $sth = $this->PDOInstance->prepare($query);
          if($bind != null && is_array($bind)){
              foreach($bind as $key => $value){
                  $sth->bindValue(':'.$key, $value);
              }
          }
          $result = $sth->execute();
          if(preg_match('/^SELECT/',$query)){
              if($fetch == 1){
                return $sth->fetchAll($fetchStyle, $fetchParam);
              }else{
                return $sth->fetch($fetchStyle, $fetchParam); 
              }
          }else{
              return $result;
          }
      } catch (PDOException $ex) {
          echo $ex->getMessage;
      }
  }
  
  private function bind($bind, $sth){
      if($bind != null && is_array($bind)){
          foreach($bind as $key => $value){
              $sth->bindValue(':'.$key, $value);
          }
      }
  }
}

