<?php

namespace App\Jobs;

use App\Models\TelegramState;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class BroadcastJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        switch ($broadcast->target) {

            case 'all':
                $users = User::all();
                break;

            case 'active':
                $users = User::where('status','active')->get();
                break;

            case 'professional':
                $users = User::whereNotNull('professional_activated_at')->get();
                break;
        }
        TelegramState::sendMessage([
            'chat_id'=>$user->telegram_id,
            'text'=>$broadcast->message,
        ]);
    }
}
