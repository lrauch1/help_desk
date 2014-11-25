<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * A class of methods for a help desk
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

    /**
     * verifys a users credentials and sends them to the correct spot
     * 
     * @return String HTML page
     * @throws Exception if credentials arent correct
     */
    public function loginCheckAction() {
        try {
            $user = User::where('uname', '=', $_POST['uname'])->firstOrFail();
        } catch (Exception $e) {
            return Redirect::to('/login?badcreds=1');
        }
        if ($user->checkPassword($_POST['pword'])) {
            if (Session::get('auth') == 1) {
                Session::put('auth', 2); //user must auth twice to access admin panel
                Session::put('me', $user);
                return Redirect::to('/admin/tickets');
            } else {
                Session::put('auth', 1);
                Session::put('me', $user);
                return Redirect::to('/secure/browse');
            }
        } else {
            return Redirect::to('/login?badcreds=1');
        }
    }
    /**
     * logs a user out
     *  
     * @return String HTML page
     */
    public function logoutAction() {
        Session::forget('me');
        Session::put('auth', 0);
        return Redirect::to('/');
    }
    /**
     * Shows all tickets in the database
     * 
     * @return String HTML page
     */
    public function browseAction() {
        //$tickets = Ticket::with('creator')->with('tech')->get();
        $tickets = Ticket::with('creator', 'tech')->get();
        // if (Session::get('auth') == 1) return View::make('browse')->with('tickets', $tickets);
        // else return Redirect::to('/login');
        return View::make('browse')->with('tickets', $tickets);
    }
    /**
     * Shows all details about a given ticket
     * 
     * @param integer $id ID of ticket to show
     * @return String HTML page
     */
    public function detailsAction($id) {
        $ticket = Ticket::with('creator')->with('tech')->find($id);
        $messages = Message::where('ticket_id', '=', $id)->with('user')->get();
        return View::make('details')->with('ticket', $ticket)->with('messages', $messages)->with('id', $id);
    }
    /**
     * creates a new message for a given ticket
     * 
     * @param integer $id ID of ticket
     * @return String HTML page
     */
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
    /**
     * creates a new ticket and a corresponding message
     * 
     * @return String HTML page
     */
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
    /**
     * Updates a user, message, or ticket object
     * 
     * @param integer $table ID of database table
     * @param integer $id ID of ticket, user or message
     * @return String HTML page
     */
    public function updateAction($table, $id) {
        switch ($table) {
            case "user":
                //first check if we're updating ourselves
                if ($id == Session::get('me')->id) {
                    //we are, so we can use our session object to save a query
                    $me = Session::get('me');
                    //and we need to verify the password too
                    if (!$me->checkPassword($_POST['opword']))
                        return Redirect::to("/secure/settings?badpass");
                    //and double check for spelling mistakes
                    if ($_POST['npword'] != $_POST['cpword'])
                        return Redirect::to("/secure/settings?badconfirm");
                    //now we need to update our user object
                    $me->fname = htmlentities($_POST['fname']);
                    $me->lname = htmlentities($_POST['lname']);
                    $me->uname = htmlentities($_POST['uname']);
                    //password is a bit different
                    $me->pword = $me->hashPassword($_POST['npword']);
                    //and save it
                    $me->save();
                }else {
                    //not updating ourselves, so we have to start out by getting the user
                    $user = User::find($id);
                    if ($_POST['submit'] == "Delete") {
                        $user->delete();
                        Session::put('updateBackUrl', '/admin/accounts');
                    } else {
                        //update info
                        $user->fname = htmlentities($_POST['fname']);
                        $user->lname = htmlentities($_POST['lname']);
                        $user->uname = htmlentities($_POST['uname']);
                        //password is a bit different
                        //and we may not even have to change it
                        if ($_POST['npword'] != "iamadefaultvalue")
                            $user->pword = $user->hashPassword($_POST['npword']);
                        //and save the object
                        $user->save();
                    }
                }
                break;
            case "message":
                $msg = Message::find($id);
                if ($_POST['submit'] == "Delete") {
                    $msg->delete();
                } else {
                    $msg->user_id = $_POST['user_id'];
                    $msg->timestamp = str_replace("T", " ", $_POST['timestamp']);
                    $msg->text = strip_tags($_POST['text'], "<br><span>");
                    $msg->save();
                }
                break;
            case "ticket":
                $ticket = Ticket::find($id);
                if ($_POST['submit'] == "Delete") {
                    $msgs = Message::where("ticket_id", "=", $ticket->id)->get();
                    foreach ($msgs as $msg)
                        $msg->delete();
                    $ticket->delete();
                    Session::put('updateBackUrl', '/admin/tickets');
                } else {
                    $ticket->created = str_replace("T", " ", $_POST['created']);
                    $ticket->creator_id = $_POST['creator_id'];
                    $ticket->tech_id = $_POST['tech_id'];
                    $ticket->subject = $_POST['subject'];
                    $ticket->priority = $_POST['priority'];
                    $ticket->status = $_POST['status'];
                    $ticket->save();
                }
                break;
            default:
                die("Something went wrong!"); //we should never get here unless i break something
        }
        //multiple pages link here
        //so we need to see if they left us an url to go back to
        //defaulting to account settings if not (because everyone can access that)
        //if statement 1 is true, it executes statement 2, if statement 1 is false, it executes statement 3
        $url = Session::has('updateBackUrl') ? Session::pull('updateBackUrl') : "/secure/settings";
        return Redirect::to($url . "?updated");
    }

    public function registerAction() {
        return View::make('register');
    }
    /**
     * Adds a user object to the database
     * 
     * @return String HTML page
     */
    public function addUserAction() {
        //first, confirm they typed their password correctly
        if ($_POST['pword'] != $_POST['cpword'])
            return Redirect::to('/register?badconfirm');
        //next, we need a new user object
        $user = new User();
        //fill up data
        $user->fname = htmlentities($_POST['fname']);
        $user->lname = htmlentities($_POST['lname']);
        $user->uname = htmlentities($_POST['uname']);
        $user->salt = substr(sha1(sha1(time())), -10);
        $user->pword = $user->hashPassword($_POST['pword']);
        //only allow registration as basic user, only admin can change to admin or tech
        $user->type = "User";
        //and finally, save the object to the database
        $user->save();
        //now we need to manually authenticate them
        Session::put('me', $user);
        Session::put('auth', 1);
        //and send them to the home page
        return Redirect::to("/secure/browse");
    }
    /**
     * Creates a ticket as admin
     * 
     * @return String HTML page
     */
    public function adminTicketsAction() {
        $tickets = Ticket::with('creator')->with('tech')->get();
        return View::make('admin_tickets')->with('tickets', $tickets);
    }
    /**
     * Edits a ticket as admin
     * 
     * @param integer $id id of ticket to be edited
     * @return String HTML page
     */
    public function adminEditTicketAction($id) {
        $ticket = Ticket::with('creator')->with('tech')->find($id);
        $messages = Message::where('ticket_id', '=', $id)->with('user')->get();
        $users = User::get();
        return View::make('admin_edit_ticket')->with('ticket', $ticket)->with('messages', $messages)->with('id', $id)->with('users', $users);
    }
    /**
     * Displays user accounts
     * 
     * @return String HTML page
     */
    public function adminAccountsAction() {
        $users = User::get();
        return View::make('admin_accounts')->with('users', $users);
    }
    /**
     * Edits a user 
     * 
     * @param integer $id id of user to be edited
     * @return String HTML page
     */
    public function adminEditAccountAction($id) {
        $user = User::find($id);
        return View::make('admin_edit_account')->with('user', $user);
    }
    /**
     * Creates a new user 
     * 
     * @return String HTML page
     */
    public function adminNewAccountAction() {
        $user = new User();
        $user->save();
        Session::flash('newAccount', true);
        return View::make('admin_edit_account')->with('user', $user);
    }

}
