<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class mysqlid2 {

     public $connection;

     public function __construct($config) {
        try {
            $this->connection = new mysqli($config['dbhost'], $config['dbuser'],
                    $config['dbpassword'], $config['dbschema']);
        } catch (exception $e) {
            throw $e;
        }
    }
}
?>
