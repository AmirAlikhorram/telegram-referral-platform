<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Broadcast;
use App\Models\User;
use App\Services\Telegram\TelegramService;
use Illuminate\Http\Request;

class BroadcastController extends Controller
{
    public function __construct(
        private TelegramService $telegram
    ) {
    }

    public function index()
    {
        return view(
            'admin.broadcasts.index',
            [
                'broadcasts' => Broadcast::latest()->paginate(20),
            ]
        );
    }

    public function send(Request $request)
    {
        $request->validate([
            'message'=>'required|string|max:4096',
        ]);

        $broadcast = Broadcast::create([
            'message'=>$request->message,
        ]);

        $sent = 0;

        $failed = 0;

        User::chunk(100,function($users) use(&$sent,&$failed,$request){

            foreach($users as $user){

                try{

                    $this->telegram->sendMessage(
                        $user->telegram_id,
                        $request->message
                    );

                    $sent++;

                }catch(\Throwable){

                    $failed++;

                }

            }

        });

        $broadcast->update([
            'sent'=>$sent,
            'failed'=>$failed,
        ]);

        return back()->with(
            'success',
            "ارسال انجام شد.
موفق: {$sent}
ناموفق: {$failed}"
        );
    }
}
