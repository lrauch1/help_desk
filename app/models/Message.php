<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Message
 *
 * @author Lindsey
 */
class Message extends Eloquent {
        protected $table = 'message';
	public	$timestamps =  false;
        
        public function user() {
        return $this->belongsTo('User','user_id');
    }
}
