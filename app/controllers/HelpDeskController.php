<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HelpDeskController
 *
 * @author Lindsey
 */
class HelpDeskController extends BaseController {

    public function indexAction() {
        return Redirect::to('/login');
    }

    public function loginAction() {
        return View::make('login');
    }

    public function loginCheckAction() {
        try {
            $user = User::where('uname', '=', $_POST['uname'])->firstOrFail();
        } catch (Exception $e) {
            return Redirect::to('/login?badcreds=1');
        }
        if ($user->checkPassword($_POST['pword'])) {
            Session::put('auth', 1);
            Session::put('me', $user);
            return Redirect::to('/secure/browse');
        } else {
            return Redirect::to('/login?badcreds=1');
        }
    }

    public function logoutAction() {
        Session::forget('me');
        Session::put('auth', 0);
        return Redirect::to('/');
    }

    public function browseAction() {
        $tickets = Ticket::with('creator')->with('tech')->get();
        if (Session::get('auth') == 1)
            return View::make('browse')->with('tickets', $tickets);
        else
            return Redirect::to('/login');
    }

    public function detailsAction($id) {
        $ticket = Ticket::with('creator')->with('tech')->find($id);
        $messages = Message::where('ticket_id', '=', $id)->with('user')->get();
        return View::make('details')->with('ticket', $ticket)->with('messages', $messages)->with('id', $id);
    }

    public function newMsgAction($id) {
        $msg = new Message();
        $msg->ticket_id = $id;
        $msg->user_id = Session::get('me')->id;
        $msg->text = htmlentities($_POST['msg']);
        $msg->save();
        return Redirect::to("/secure/details/$id");
    }

    public function newTicketAction() {
        return View::make('new');
    }

    public function processNewTicketAction() {
        $ticket = new Ticket();
        $ticket->creator_id = Session::get('me')->id;
        $ticket->subject = htmlentities($_POST['subject']);
        $ticket->save();

        $msg = new Message();
        $msg->ticket_id = $ticket->id; //$ticket->save() sets this despite it starting out null
        $msg->user_id = Session::get('me')->id;
        $msg->text = htmlentities($_POST['desc']);
        $msg->save();

        return Redirect::to("/secure/details/" . $ticket->id);
    }

}
