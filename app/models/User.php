<?php

class User extends Eloquent{
    protected $table = 'user';
    public $timestamps = false;
    
        public function checkPassword($plaintext) {
        return $plaintext==$this->pword;
    }

}
