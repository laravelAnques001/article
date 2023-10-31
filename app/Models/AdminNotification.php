<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
class AdminNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',      
    ];

    protected $appends=[
        'ago'
    ];

    public function getAgoAttribute(){
        $date = isset($this->created_at) ? $this->created_at : (Carbon::now());        
        $to = Carbon::createFromFormat('Y-m-d H:s:i', $date );
        $from = Carbon::now()->format('Y-m-d H:s:i');   
        $diffInMinutes = $to->diffInMinutes($from);
        if($diffInMinutes < 60){
            return round($diffInMinutes)." minutes ago";
        }elseif($diffInMinutes >= 60 && $diffInMinutes < 1440 ){
            return round($diffInMinutes/60). " hours ago";
        }elseif($diffInMinutes >= 1440 ){
            return round($diffInMinutes/1440). " days ago";
        }
       return "$diffInMinutes minutes ago";
    }
}
