<?php
class User extends Eloquent{
    protected $table = 'user';
    public $timestamps = false;
    
    //workaround for not having an easy way to get enum values
    public static $user_types=array('User','Technician','Admin');
    
    public function checkPassword($plaintext) {
        return sha1(sha1($plaintext).$this->salt)==$this->pword;
    }
    public function hashPassword($plaintext) {
        return sha1(sha1($plaintext).$this->salt);
    }
}