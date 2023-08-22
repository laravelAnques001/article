<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdvertiseRequest;
use App\Models\Advertise;
use App\Models\Article;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdvertiseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        if ($search) {
            $advertise = Advertise::select('id', 'article_id', 'target', 'latitude', 'longitude', 'redis', 'budget', 'start_date', 'end_date', 'status')
                ->with(['article' => function ($q) {
                    $q->select('id', 'title', 'media', 'created_at');
                }])
                ->orWhereHas('article', function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%');
                })
                ->orWhere('target', 'like', '%' . $search . '%')
                ->orWhere('latitude', 'like', '%' . $search . '%')
                ->orWhere('longitude', 'like', '%' . $search . '%')
                ->orWhere('budget', 'like', '%' . $search . '%')
                ->orWhere('start_date', 'like', '%' . $search . '%')
                ->orWhere('end_date', 'like', '%' . $search . '%')
                ->whereNull('deleted_at')
                ->paginate(10);
        } else {
            $advertise = Advertise::select('id', 'article_id', 'target', 'latitude', 'longitude', 'redis', 'budget', 'start_date', 'end_date', 'status')
                ->with(['article' => function ($q) {
                    $q->select('id', 'title', 'media', 'created_at');
                }])
                ->whereNull('deleted_at')->paginate(10);
        }
        return $this->sendResponse($advertise, 'Advertise List Get Successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdvertiseRequest $request)
    {
        $validated = $request->validated();
        $advertise = Advertise::create($validated);
        return $this->sendResponse($advertise->id, 'Advertise Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $advertise = Advertise::select('id', 'article_id', 'target', 'latitude', 'longitude', 'redis', 'budget', 'start_date', 'end_date', 'status')
            ->with(['article' => function ($q) {
                $q->select('id', 'title', 'media', 'created_at');
            }])
            ->whereNull('deleted_at')
            ->find(base64_decode($id));
        if ($advertise) {
            return $this->sendResponse($advertise, 'Advertise Record Get Successfully.');
        } else {
            return $this->sendError([], 'Record Not Found.');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdvertiseRequest $request, $id)
    {
        $advertise = Advertise::whereNull('deleted_at')->find(base64_decode($id));
        if (!$advertise) {
            return $this->sendError([], 'Record Not Found.');
        }
        $validated = $request->validated();
        $advertise->fill($validated)->save();
        return $this->sendResponse($advertise->id, 'Advertise Updated Successfully.');
    }

    public function destroy($id)
    {
        $advertise = Advertise::whereNull('deleted_at')->find(base64_decode($id));
        if ($advertise) {
            $advertise->fill(['deleted_at' => now()])->save();
            return $this->sendResponse([], 'Advertise Deleted Successfully.');
        } else {
            return $this->sendError([], 'Record Not Found.');
        }
    }

    public function getAdvertise(Request $request)
    {
        $latitude = isset($request->latitude) ? $request->latitude : null;
        $longitude = isset($request->longitude) ? $request->longitude : null;
        $advertise = $this->AdvertiseSingleRecordGet($latitude, $longitude);
        $article = [];
        if ($advertise) {
            $article = Article::with('user')->find($advertise->article_id);
            if ($advertise->target == 1) {
                $today_charges = Transaction::where('article_id', $advertise->article_id)->where('created_at', '>=', Carbon::today())->sum('charge');
                if ($today_charges >= $advertise->budget || $article->user->balance < 0) {
                    $article = [];
                }
            }
            if ($advertise->target == 0) {
                if ($article->user->balance < 0) {
                    $article = [];
                }
            }
        }

        return $this->sendResponse($article, 'Advertise Record Get Successfully.');
    }

    public function AdvertiseSingleRecordGet($lat = null, $log = null)
    {
        $advertise = null;
        if ($lat && $log) {
            $advertise = DB::table('advertises')
                ->select('id', 'article_id', 'target', 'budget', 'start_date', 'end_date', DB::raw("6371 * acos(cos(radians(" . $lat . "))
                * cos(radians(advertises.latitude))
                * cos(radians(advertises.longitude) - radians(" . $log . "))
                + sin(radians(" . $lat . "))
                * sin(radians(advertises.latitude))) AS distance"))
                ->havingRaw('distance < 25')
                ->where('start_date', '<=', now())
                ->orWhereNull('end_date')
                ->orWhereNotNull('end_date', '>=', now())
                ->whereNull('deleted_at')
                ->inRandomOrder()->first();
        }
        if (is_null($advertise)) {
            $advertise = Advertise::where('target', 0)
                ->where('status', 'Public')
                ->whereNull('deleted_at')
                ->inRandomOrder()
                ->first();
        }
        return $advertise;
    }

    public function impressionClick(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'article_id' => 'required|exists:articles,id',
            'impression' => 'nullable|in:0,1',
            'click' => 'nullable|in:0,1',
            'device_detail' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $article = isset($request->article_id) ? $request->article_id : 0;
        $impression = isset($request->impression) ? $request->impression : 0;
        $click = isset($request->click) ? $request->click : 0;
        $device_detail = isset($request->device_detail) ? $request->device_detail : null;

        //impression add
        $impressionArticle = Article::whereNull('deleted_at')->find($article);
        $impressionArticle->impression += 1;
        $impressionArticle->save();

        $charge = 0;
        $impression_charge = 0.25;
        $click_charge = 0.50;

        if ($impression) {
            $charge = $impression_charge;
        }
        if ($click) {
            $charge = $click_charge;
        }
        if ($click && $impression) {
            $charge = $impression_charge + $click_charge;
        }

        // transaction
        Transaction::create([
            'article_id' => $article,
            'impression' => $impression,
            'click' => $click,
            'device_detail' => $device_detail,
            'charge' => $charge,
        ]);

        // article author balance
        $user = User::find($impressionArticle->user_id);
        $user->balance -= $charge;
        $user->save();

        return $this->sendResponse([], 'Article Impression Added.');
    }
}
