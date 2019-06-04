<?php
namespace components\models;

use components\interfaces\DataProviderInterface;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DataProvider
 *
 * @author agroprom
 */
class DataProvider implements DataProviderInterface {
    
    private $host;
    private $user;
    private $password;

    /**
     * 
     * @param type $host
     * @param type $user
     * @param type $password
     */
    public function __construct($host, $user, $password)
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * 
     * @param array $request
     */
    public function get(array $request) {
    //тут чего-то делаем    
    }

}
