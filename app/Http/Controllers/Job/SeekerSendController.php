<?php

namespace App\Http\Controllers\Job;

use Auth;
use DB;
use Input;
use Redirect;
use Mail;
use Carbon\Carbon;
use App\User;
use App\Company;
use App\CompanyMessage;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Mail\MessageSendMail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;

class SeekerSendController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function all_messages()
    {
        $messages = CompanyMessage::where('seeker_id', Auth::user()->id)->get();
        $ids = array();
        foreach ($messages as $key => $value) {
            $ids[] = $value->company_id;
        }
        $data['companies'] = Company::whereIn('id', $ids)->get();
        return view('seeker.all-messages')->with($data);
    }
    public function append_messages(Request $request)
    {
        $seeker_id = Auth::user()->id;
        $company_id = $request->get('company_id');
        $messages = CompanyMessage::where('company_id', $company_id)->where('seeker_id', $seeker_id)->get();
     
        $seeker = User::where('id', $seeker_id)->first();
        $company = Company::where('id', $company_id)->first();
        $search = view("seeker.append-messages", compact('messages', 'seeker', 'company'))->render();
        return $search;
    }



    function submit_message(Request $request)
    {
        $this->validate($request, [
            'message' => 'required',
        ], [
            'message.required' => 'Message is required.',
        ]);
        $message = new CompanyMessage();
        $message->company_id = $request->company_id;
        $message->message = $request->message;
        $message->seeker_id = Auth::user()->id;
        $message->save();
        $company = Company::where('id', $request->company_id)->first();
        $user = User::where('id', Auth::user()->id)->first();
        $data['name'] = $company->name;
        $data['email'] = $company->email;
        $data['seeker_name'] = $user->name;

        //Mail::send(new MessageSendMail($data));

        if ($message->save() == true) {
            $arr = array('msg' => 'Your message have successfully been posted. ', 'status' => true);
        }
        return Response()->json($arr);
    }
    function submitnew_message(Request $request)
    {
        $this->validate($request, [
            'message' => 'required',
        ], [
            'message.required' => 'Message is required.',
        ]);
        $message = new CompanyMessage();
        $message->company_id = $request->company_id;
        $message->message = $request->message;
        $message->seeker_id = Auth::user()->id;
        $message->save();
        $company = Company::where('id', $request->company_id)->first();
        $user = User::where('id', Auth::user()->id)->first();
        $data['name'] = $company->name;
        $data['email'] = $company->email;
        $data['seeker_name'] = $user->name;

        //Mail::send(new MessageSendMail($data));
        if ($message->save() == true) {
            $messages = CompanyMessage::where('company_id', $request->company_id)->where('seeker_id', Auth::user()->id)->get();
            $seeker = User::where('id', Auth::user()->id)->first();
            $company = Company::where('id', $request->company_id)->first();
            $search = view("seeker.appendonly-messages", compact('messages', 'seeker', 'company'))->render();
            return $search;
        }
    }

    public function appendonly_messages(Request $request)
    {
        $seeker_id = Auth::user()->id;
        $company_id = $request->get('company_id');
        $messages = CompanyMessage::where('company_id', $company_id)->where('seeker_id', $seeker_id)->get();
        $seeker = User::where('id', $seeker_id)->first();
        $company = Company::where('id', $company_id)->first();
        $search = view("seeker.appendonly-messages", compact('messages', 'seeker', 'company'))->render();
        $data = array();
        $data['html_data'] = $search;
        $data['company_id'] = $company_id;
        return \Response::json($data);
    }
    public function change_message_status(Request $request)
    {
        $company_id = $request->get('sender_id');
        $seeker_id = Auth::user()->id;
        $messages = CompanyMessage::where('company_id', $company_id)->where('seeker_id', $seeker_id)->get();
        if ($messages) {
            foreach ($messages as $key => $value) {
                $message = CompanyMessage::findOrFail($value->id);
                $message->status = 'viewed';
                $message->update();
            }
        }
        echo 'done';
    }
}
