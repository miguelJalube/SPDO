<?php
namespace model;
use PDO;

class SPDO{
  private $PDOInstance = null;  
  private static $instance = null;
  const DEFAULT_SQL_USER = '';
  const DEFAULT_SQL_HOST = '';
  const DEFAULT_SQL_PASS = '';
  const DEFAULT_SQL_DTB = '';

  public function __construct(){
          $this->PDOInstance = new PDO('mysql:dbname='.self::DEFAULT_SQL_DTB.';host='.self::DEFAULT_SQL_HOST, self::DEFAULT_SQL_USER , self::DEFAULT_SQL_PASS);
  }
  
  public static function getInstance(){  
    if(is_null(self::$instance)){
        self::$instance = new SPDO();
    }
    return self::$instance;
  }
  
  public function query($query, $bind = null, $fetch = null, $fetchStyle = null, $fetchParam = null){
      try {
          $sth = $this->PDOInstance->prepare($query);
          $this->bind($bind);
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
  
  private function bind($bind){
      if($bind != null && is_array($bind)){
          foreach($bind as $key => $value){
              $sth->bindValue(':'.$key, $value);
          }
      }
  }
}

