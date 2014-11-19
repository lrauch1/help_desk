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
        $msgtext = htmlentities($_POST['msg']);

        $ticket = Ticket::find($id);
        if ($_POST['status'] != $ticket->status) {
            switch ($_POST['status']) {
                case "In Progress":
                    if ($ticket->status == "New") {
                        //assign current user to ticket
                        $ticket->tech_id = Session::get('me')->id;
                        //add note to message
                        $msgtext .= "<br>"
                                . "<span class=small>"
                                . Session::get('me')->fname
                                . " was assigned to this ticket"
                                . "</span>";
                    }
                    break;
                case "Stalled":
                    //don't need to do anything here
                    break;
                case "Cancelled":
                case "Closed":
                    $ticket->closed = date("Y-m-d H:i:s");
                    break;
                default:
                    die("Something broke!"); //should never get here unless i break something
            }
            $msgtext .= "<br>"
                    . "<span class=small>"
                    . "Status: '{$ticket->status}' -> '{$_POST['status']}'"
//no sanitization bc it wouldnt have matched the case statement if there was html in it
                    . "</span>";
        }
        $ticket->status = $_POST['status'];
        $msg = new Message();
        $msg->ticket_id = $id;
        $msg->user_id = Session::get('me')->id;
        $msg->text = $msgtext;
        $msg->save();
        $ticket->save();
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
 public function settingsAction() {
        return View::make('settings');
    }
    public function updateAction($table, $id) {
        switch($table){
            case "user":
                //first check if we're updating ourselves
                if($id==Session::get('me')->id){
                    //we are, so we can use our session object to save a query
                    $me = Session::get('me');
                    //and we need to verify the password too
                    if(!$me->checkPassword($_POST['opword']))
                        return Redirect::to("/secure/settings?badpass");
                    //and double check for spelling mistakes
                    if($_POST['npword']!=$_POST['cpword'])
                        return Redirect::to("/secure/settings?badconfirm");
                    //now we need to update our user object
                    $me->fname=htmlentities($_POST['fname']);
                    $me->lname=htmlentities($_POST['lname']);
                    $me->uname=htmlentities($_POST['uname']);
                    //password is a bit different
                    $me->pword=$me->hashPassword($_POST['npword']);
                    //and save it
                    $me->save();
                }else{
                    //not updating ourselves, so we have to start out by getting the user
                    $user=User::find($id);
                    //update info
                    $user->fname=htmlentities($_POST['fname']);
                    $user->lname=htmlentities($_POST['lname']);
                    $user->uname=htmlentities($_POST['uname']);
                    //password is a bit different
                    $user->password=$user->hashPassword($_POST['npword']);
                    //and save the object
                    $user->save();
                }
                break;
            case "message":
                break;
            case "ticket":
                break;
            default:
                die("Something went wrong!");//we should never get here unless i break something
        }
        //multiple pages link here
        //so we need to see if they left us an url to go back to
        //defaulting to account settings if not (because everyone can access that)
        $url=Session::has('updateBackUrl')?Session::pull('updateBackUrl'):"/secure/settings";
        return Redirect::to($url."?updated");
    }
}
