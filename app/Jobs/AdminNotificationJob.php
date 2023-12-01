<?php

namespace App\Jobs;

use App\Mail\AdminNotification;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $note;
    public $user_id;

    /**
     * Create a new job instance.
     */
    public function __construct($note, $user_id)
    {
        $this->note = $note;
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $admins = User::query()->where('role_id', 2)->get()->toArray();
        $admins_email = array_column($admins, 'email');

        foreach ($admins_email as $email) {

            Mail::to($email)->send(new AdminNotification(
                [
                    'to' => $email,
                    'user_id' => $this->user_id,
                    'note' => [
                        'id' => $this->note->id,
                        'title' => $this->note->title,
                        'note_body' => $this->note->note_body
                    ]
                ]
            ));

        }


    }
}
