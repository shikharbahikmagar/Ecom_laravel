<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;

class ContactController extends Controller
{
    public function sendMail(Request $request)
    {
        if($request->isMethod('post'))
        {
            $contactDetails = $request->all();
           // echo "<pre>"; print_r($contactDetails); die;
            $from = $contactDetails['email'];
            $email = "merokapada.np@gmail.com";
            $message = $contactDetails['message'];
            $subject = $contactDetails['subject'];
             $messageData = [
                'from' => $from,
                'email' => $email,
                'cutomer_subject' => $subject,
                'name' => $contactDetails['name'],
                'mail_message' => $contactDetails['message'],
            ];
            Mail::send('emails.contact_us', $messageData, function($message) use($email){
               
                $message->to($email)->subject("Enquiry From users(merokapada.com.np)");
            });
            $message = "Thanks For your Message, We will get back to you soon.";
            return redirect()->back()->with('success_message', $message);
        }

    }
}
