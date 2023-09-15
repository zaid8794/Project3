<?php

namespace App\Http\Controllers;

use App\Mail\Notification;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function mailView()
    {
        return view('/mailView');       
    }

    /**
     * save file and send mail.
     *
     * @return $this
     */
    public function mailSend(Request $request)
    {
        $input = $request->validate([
            'email' => 'required',
            'attachment' => 'required',
        ]);

        $path = public_path('uploads');
        $attachment = $request->file('attachment');

        $name = time() . '.' . $attachment->getClientOriginalExtension();;

        // create folder
        if (!File::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }
        $attachment->move($path, $name);

        $filename = $path . '/' . $name;

        try {
            Mail::to($input['email'])->send(new Notification($filename));
        } catch (\Exception $e) {
            return redirect('mail')->with('success',$e->getMessage());
        }

        return redirect('mail')->with('success', 'Mail sent successfully.');
    }
}
