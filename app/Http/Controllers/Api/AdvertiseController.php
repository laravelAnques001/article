<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdvertiseRequest;
use App\Models\Advertise;
use App\Models\AdvertiseLatLong;
use App\Models\Article;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
        $userId = auth()->id();
        if ($search) {
            $advertise = Advertise::select('id', 'article_id', 'target', 'budget', 'budget_type', 'ad_status', 'start_date', 'end_date', 'status')->with('article', 'advertiseLatLong')
                ->whereHas('article', function ($q) use ($search, $userId) {
                    $q->select('id', 'title', 'link', 'tags', 'description', 'image_type', 'user_id', 'category_id', 'created_at', 'media', 'thumbnail', 'status', 'impression', 'share');
                    $q->orWhere('title', 'like', '%' . $search . '%');
                    $q->orWhere('user_id', $userId);
                })
                ->orWhere('target', 'like', '%' . $search . '%')
                ->orWhere('budget', 'like', '%' . $search . '%')
                ->orWhere('start_date', 'like', '%' . $search . '%')
                ->orWhere('end_date', 'like', '%' . $search . '%')
                ->whereNull('deleted_at')
                ->where('status', 'Published')
                ->where('ad_status', 0)
                ->orderByDesc('id')
                ->paginate(10);
        } else {
            $advertise = Advertise::select('id', 'article_id', 'target', 'budget', 'budget_type', 'ad_status', 'start_date', 'end_date', 'status')->with('article', 'advertiseLatLong')
                ->whereHas('article', function ($q) use ($userId) {
                    $q->select('id', 'title', 'link', 'tags', 'description', 'image_type', 'user_id', 'category_id', 'created_at', 'media', 'thumbnail', 'status', 'impression', 'share');
                    $q->where('user_id', $userId);
                })
                ->whereNull('deleted_at')
                ->where('status', 'Published')
                ->where('ad_status', 0)
                ->orderByDesc('id')
                ->paginate(10);
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
        $locations = isset($request->locations) ? json_decode($request->locations) : null;
        if ($locations) {
            foreach ($locations as $latLong) {
                AdvertiseLatLong::create([
                    'advertise_id' => $advertise->id,
                    'latitude' => $latLong->latitude,
                    'longitude' => $latLong->longitude,
                ]);
            }
        }
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
        $advertise = Advertise::select('id', 'article_id', 'target', 'budget', 'budget_type', 'ad_status', 'start_date', 'end_date', 'status')->with('article', 'advertiseLatLong')
            ->whereHas('article', function ($q) {
                $q->select('id', 'title', 'link', 'tags', 'description', 'image_type', 'user_id', 'category_id', 'created_at', 'media', 'thumbnail', 'status', 'impression', 'share');
            })
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
        $locations = isset($request->locations) ? json_decode($request->locations) : null;
        if ($locations) {
            AdvertiseLatLong::where('advertise_id', $advertise->id)->delete();
            foreach ($locations as $latLong) {
                AdvertiseLatLong::create([
                    'advertise_id' => $advertise->id,
                    'latitude' => $latLong->latitude,
                    'longitude' => $latLong->longitude,
                ]);
            }
        }
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

        // $haversine = "(6371 * acos(cos(radians($latitude))* cos(radians(`latitude`))* cos(radians(`longitude`) - radians($longitude))+ sin(radians($latitude)) * sin(radians(`latitude`))))";

        // return Advertise::with('advertiseLatLong')->whereHas('advertiseLatLong' , function($q) use($haversine){
        //     $q->selectRaw("$haversine AS distance")
        //     ->having("distance", "<=", 25);
        // })->inRandomOrder()->first();

        // $nearbyLocationNames = Redis::georadius('locations', $longitude, $latitude, 25, 'km');
        // return $nearbyLocationNames;
        // $showResult = DB::table("advertise_lat_longs")
        //     ->select(DB::raw("6371 * acos(cos(radians(" . $latitude . "))
        //     * cos(radians(advertise_lat_longs.lat))
        //     * cos(radians(advertise_lat_longs.lon) - radians(" . $longitude . "))
        //     + sin(radians(" . $latitude . "))
        //     * sin(radians(advertise_lat_longs.lat))) AS distance"))
        //     ->get();
        // return $showResult;

        // $query = "SELECT *, (6371 * acos (cos (radians(:target_latitude))* cos(radians(latitude))* cos( radians(:target_latitude) - radians(longitude) )+ sin (radians(:target_latitude) )* sin(radians(latitude)))) AS distance FROM advertise_lat_longs HAVING distance <= 25";

        // $query = "SELECT *,6371 * ACOS(COS(RADIANS(latitude)) * COS(RADIANS(:target_latitude)) * COS(RADIANS(:target_longitude) - RADIANS(longitude)) + SIN(RADIANS(latitude)) * SIN(RADIANS(:target_latitude))) AS distance FROM advertise_lat_longs";

        // $bindings = [
        //     'target_latitude' => $latitude,
        //     'target_longitude' => $longitude,
        // ];
        // return DB::query($query, $bindings);

        // $radius = 400;
        // return AdvertiseLatLong::selectRaw("latitude, longitude,
        // ( 6371000  acos( cos( radians(?) )
        //   cos( radians( latitude ) )
        //   * cos( radians( longitude ) - radians(?)
        //   ) + sin( radians(?) ) *
        //   sin( radians( latitude ) ) )
        // ) AS distance", [$latitude, $longitude, $latitude])
        //     ->having("distance", "<", $radius)
        //     ->orderBy("distance", 'asc')
        //     ->offset(0)
        //     ->limit(20)
        //     ->get();

        // return $results;

        // return DB::query($query);
        // return DB::table('advertise_lat_longs')
        //     ->select('*', DB::raw("6371 * acos(cos(radians(" . $latitude . "))
        // * cos(radians(latitude))
        // * cos(radians(longitude) - radians(" . $longitude . "))
        // + sin(radians(" . $latitude . "))
        // * sin(radians(latitude))) AS distance"))
        // // ->join('advertises','advertises.id','=','advertise_lat_longs.advertise_id')
        //     ->havingRaw('distance <= 25')
        //     ->toSql();

        $advertise = $this->AdvertiseSingleRecordGet($latitude, $longitude);
        // return $advertise;
        $article = null;
        if ($advertise) {
            $article = Article::select('id', 'title', 'link', 'tags', 'description', 'image_type', 'user_id', 'category_id', 'created_at', 'media', 'thumbnail', 'status', 'impression', 'share')
                ->with(['user' => function ($q) {
                    $q->select('name', 'email', 'id', 'image');
                }])
                ->with(['category' => function ($q) {
                    $q->select('id', 'name', 'image');

                }])->whereNull('deleted_at')->find($advertise->article_id);
            if ($advertise->target == 1) {
                $today_charges = Transaction::where('article_id', $advertise->article_id)->where('created_at', '>=', Carbon::today())->sum('charge');
                if ($today_charges >= $advertise->budget || $article->user->balance < 0) {
                    $article = null;
                }
            }
            if ($advertise->target == 0) {
                if ($article->user->balance < 0) {
                    $article = null;
                }
            }
        }
        return $this->sendResponse($article, 'Advertise Record Get Successfully.');
    }

    public function AdvertiseSingleRecordGet($lat = null, $log = null)
    {
        $advertise = null;
        if ($lat && $log) {
            // $advertise = DB::table('advertises')
            //     ->select('id', 'article_id', 'target', 'budget', 'start_date', 'end_date', 'status', DB::raw("6371 * acos(cos(radians(" . $lat . "))
            //     * cos(radians(advertises.latitude))
            //     * cos(radians(advertises.longitude) - radians(" . $log . "))
            //     + sin(radians(" . $lat . "))
            //     * sin(radians(advertises.latitude))) AS distance"))
            //     ->havingRaw('distance < 25')
            //     ->where('start_date', '<=', now())
            // // ->orWhereNull('end_date')
            //     ->orWhereNotNull('end_date', '>=', now())
            //     ->whereRaw('status', 'Published')
            //     ->whereRaw('ad_status', 0)
            //     ->whereNull('deleted_at')
            //     ->inRandomOrder()
            //     ->first();
        }
        // return $advertise;
        if (is_null($advertise)) {
            $advertise = Advertise::where('target', 0)
                ->whereNull('deleted_at')
                ->where('status', 'Published')
                ->where('ad_status', 0)
                ->inRandomOrder()
                ->first();
        }
        return $advertise;
    }

    public function impressionClick(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'article_id' => ['required', Rule::exists('articles', 'id')->whereNull('deleted_at')],
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

        // impression and click increment
        $impressionArticle = Article::whereNull('deleted_at')->find($article);

        // charge impression and click
        $setting = Setting::whereIn('key', ['impression', 'click'])->pluck('value', 'key')->toArray();
        $impression_charge = $click_charge = 0;
        if ($impression) {
            $impression_charge = $setting['impression'];
            $impressionArticle->impression += 1;
            $impressionArticle->save();
        }
        if ($click) {
            $click_charge = $setting['click'];
        }

        // transaction
        Transaction::create([
            'article_id' => $article,
            'impression' => $impression,
            'click' => $click,
            'device_detail' => $device_detail,
            'impression_charge' => $impression_charge,
            'click_charge' => $click_charge,
        ]);

        //article author balance
        if ($impressionArticle) {
            $user = User::find($impressionArticle->user_id);
            $user->balance -= ($impression_charge + $click_charge);
            $user->save();
        }

        return $this->sendResponse([], 'Article Impression Added.');
    }
}
