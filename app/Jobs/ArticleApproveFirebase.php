<?php

namespace App\Jobs;

use App\Common\GeneralComponent;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ArticleApproveFirebase implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $article;
    public $general;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($article)
    {
        $this->article = $article;
        $this->general = new GeneralComponent();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $firebaseToken = User::where('id', $this->article->user_id)->pluck('device_token')->first();

        if ($firebaseToken) {
            $data = [
                // 'to' => '/topics/broadcast-all',
                // "registration_ids" => $firebaseToken,
                "token" => $firebaseToken,
                "notification" => [
                    "title" => $this->article->status . ' : ' . $this->article->title,
                    "body" => $this->article->description,
                    "data" => $this->article,
                ],
            ];
            $serverKey = env('FIREBASE_SERVER_KEY');
            $headers = array(
                'Authorization: key=' . $serverKey,
                'Content-Type: application/json',
            );
            $this->general->curl_data('https://fcm.googleapis.com/fcm/send', $data, $headers);
        }
    }
}
