<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ticket
 *
 * @author Lindsey
 */
class Ticket extends Eloquent {
    	protected $table = 'ticket';
	public	$timestamps =  false;
        
         public static $status_types=array('New','In Progress','Closed','Cancelled','Stalled');
        
    public function creator() {
        return $this->belongsTo('User','creator_id');
    }
    public function tech() {
        return $this->belongsTo('User','tech_id');
    }        
}
