<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Mail\SupportMailManager;
use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SupportTicketController extends Controller
{
    public function admin_index(Request $request)
    {
        $sort_search = null;
        $tickets = Ticket::orderBy('created_at', 'desc');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $tickets = $tickets->where('code', 'like', '%' . $sort_search . '%');
        }
        $tickets = $tickets->paginate(15);
        return view('backend.support.support_tickets.index', compact('tickets', 'sort_search'));
    }

    public function send_support_mail_to_admin($ticket)
    {
        $array['view'] = 'emails.support';
        $array['subject'] = 'Support ticket Code is:- ' . $ticket->code;
        $array['from'] = env('MAIL_FROM_ADDRESS');
        $array['content'] = 'Hi. A ticket has been created. Please check the ticket.';
        $array['link'] = route('support_ticket.admin_show', encrypt($ticket->id));
        $array['sender'] = $ticket->user->name;
        $array['details'] = $ticket->details;
        try {
            Mail::to(User::where('user_type', 'admin')->first()->email)->queue(new SupportMailManager($array));
        } catch (\Exception $e) {
        }
    }

    public function send_support_reply_email_to_user($ticket, $tkt_reply)
    {
        $array['view'] = 'emails.support';
        $array['subject'] = 'Support ticket Code is:- ' . $ticket->code;
        $array['from'] = env('MAIL_FROM_ADDRESS');
        $array['content'] = 'Hi. A ticket has been created. Please check the ticket.';
        $array['link'] = route('support_ticket.show', encrypt($ticket->id));
        $array['sender'] = $tkt_reply->user->name;
        $array['details'] = $tkt_reply->reply;

        try {
            Mail::to($ticket->user->email)->queue(new SupportMailManager($array));
        } catch (\Exception $e) {
        }
    }

    public function admin_store(Request $request)
    {
        $ticket_reply = new TicketReply();
        $ticket_reply->ticket_id = $request->ticket_id;
        $ticket_reply->user_id = Auth::user()->id;
        $ticket_reply->reply = $request->reply;
        $ticket_reply->files = $request->attachments;
        $ticket_reply->ticket->client_viewed = 0;
        $ticket_reply->ticket->status = $request->status;
        $ticket_reply->ticket->save();

        if ($ticket_reply->save()) {
            flash(translate('Reply has been sent successfully'))->success();
            $this->send_support_reply_email_to_user($ticket_reply->ticket, $ticket_reply);
            return back();
        } else {
            flash(translate('Something went wrong'))->error();
        }
    }

    public function admin_show($id)
    {
        $ticket = Ticket::findOrFail(decrypt($id));
        $ticket->viewed = 1;
        $ticket->save();
        return view('backend.support.support_tickets.show', compact('ticket'));
    }
}
