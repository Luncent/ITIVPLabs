<?php 
require_once "../Dao/UserDao.php";

Class UsersController{
    public static function getManagers($department_id){
        return UserDao::getManagers($department_id);
    }    
}

?>