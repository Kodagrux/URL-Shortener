<?php
/**
 * Description of dbc.class:
 * dbc is an easy way to do mysql queries. It uses the PDO object to get safe
 * queries without the risk of mysql-injections.
 *
 * @author Albin Hübsch - albin.hubsch@gmail.com
 * @copyright 2012
 * @version 1.4
 * @uses dbcConstants.php
 * 
 * NEW IN 1.4
 * - Methods now returns value, true OR false.
 */

//Require files
require_once 'dbcConstants.php';

class dbc
{
    
    /**
     * Variables
     */
    private $DBH;   //Database Handle
    private $STH;   //Statement Handle
    
    /**
     * dbc Constructor. Initializes a new dbc Object.
     */
    function __construct(){
        
        $this->DBH = null;
        $this->STH = null;
        
        try{
            $this->DBH = new PDO(DB_CONN, DB_USER, DB_PASSWORD);
            $this->DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            $this->error('Kunde inte instansiera en databasanslutning. (Function: __construct())', true);
            //echo $e->getMessage();
        }
        
    }
    
    /**
     * query():
     * Function to call a mysql query.
     * Example: $query = "INSERT INTO fruits (type, color) VALUES (:type, :color)"
     *          $data = array('type' => 'Apple', 'color' => 'Green');
     * 
     * @param string $query
     * @param array $data
     * @return Number of affected rows or false if query failed
     */
    public function query($query, $data = null){
        try{
            $this->STH = $this->DBH->prepare((string)$query);
            $this->STH->execute((array)$data);
            return $this->STH->rowCount();
        }catch(PDOException $e){
            echo $e->getMessage();
            $this->error('Kunde inte utföra SQL förfrågan. (Function: query())');
            return false;
        }
    }
    
    /**
     * getResult():
     * Function returns a row from the result set created by a query. Multiple
     * calls will return next row in set.
     * 
     * @param PDOStatement::setFetchMode $mode
     * @return PDOStatement::fetch
     */
    public function getResult($mode = PDO::FETCH_ASSOC){
        if($this->STH != null){
            try{
                return $this->STH->fetch($mode);
            }catch(PDOException $e){
                $this->error('Kunde inte returnera SQL-resultat. (Function: getResult())');
                return false;
            }
        }else{
            $this->error('Kunde inte returnera SQL-resultat, STH = NULL. (Function: getResult())');
            return false;
        }
        
    }
    
    /**
     * getAllResult():
     * Function will return an array with all the row results from a query.
     * 
     * @param PDOStatement::setFetchMode $mode
     * @return PDOStatement::fetchAll 
     */
    public function getAllResult($mode = PDO::FETCH_ASSOC){
        if($this->STH != null){
            try{
                $this->STH->setFetchMode($mode);
                return $this->STH->fetchAll();
            }catch(PDOException $e){
                $this->error('Kunde inte returnera SQL-resultat. (Function: getAllResult())');
                return false;
            }
        }else{
            $this->error('Kunde inte returnera SQL-resultat, STH = NULL. (Function: getAllResult())');
            return false;
        }
    }
    
    /**
     * close():
     * Close the database connection
     */
    public function close(){
        $this->DBH = null;
        if($this->DBH != null){
            $this->error('Kunde inte stänga anslutningen. (Function: close())');
            return false;
        }
        return true;
    }
    
    /**
     * error():
     * Private function to handle exception and error message to the frontend.
     * 
     * @param String $msg
     * @param boolean $critic
     * DEPRECATED @throws Exception 
     */
    private function error($msg, $critic = false){
        echo 'dbc_ERROR: '.$msg.'<br/>';
        if($critic){
            //throw new Exception('Error defined as Critical, execution was interrupted!');
            echo 'Error defined as Critical, execution was interrupted!';
            exit;
        }
    }
}

?>