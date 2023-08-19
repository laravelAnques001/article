<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Polls;

class PollsController extends Controller
{
    public function index()
    {
        $polls = Polls::select('id', 'title', 'image', 'link', 'description')->whereNull('deleted_at')->paginate(10);
        return $this->sendResponse($polls, 'Polls list get successfully.');
    }
}
