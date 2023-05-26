<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\FCMUser;
use App\Models\User;

class SendPushNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $title;
    protected $description;
    protected $type;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($title, $description, $type)
    {
        $this->title = $title;
        $this->description = $description;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $msg = array( 
            'title' => $this->title, 
            'body' => $this->description, 
            'total_notification'=>1, 
            'alert' => "GGPA", 
            'vibrate' => 1,
            'sound' => 1, 
            'type' => $this->type, 
          );
        $fcmUsers = FCMUser::join('users','fcm_users.user_id', '=', 'users.id')->get();
        send_notification($fcmUsers, $msg);
    }
}
