<?php

namespace App\Jobs;

use App\Common\GeneralComponent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ArticleCreateFirebaseJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
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
        $data = [
            'to' => '/topics/broadcast-all',
            "notification" => [
                "title" => $this->article->title,
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
