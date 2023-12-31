<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
use App\Models\AdminNotification;
use App\Jobs\SendEmail;

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
                // ->where('status', 'Published')
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
    // public function store(AdvertiseRequest $request)
    public function store(Request $request)
    {
        $validated = $request->all();
        $validator = Validator::make($validated, [
            'locations' => 'nullable|string',
            'redis' => 'nullable|numeric',
            'budget' => 'nullable|numeric',
            'budget_type' => 'nullable|in:0,1',
            'ad_status' => 'nullable|in:0,1',
            'start_date' => 'nullable|date_format:Y-m-d H:i:s',
            'end_date' => 'nullable|date_format:Y-m-d H:i:s|after_or_equal:start_date',
            'target' => 'required|in:0,1',
            'article_id' => 'required|exists:articles,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        // $validated = $request->validated();
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

        $validated['id'] = $advertise->id;
        $validated['article_title'] = $advertise->article->title;
        $validated['target'] = $advertise->target ? 'Own' : 'All';
        $validated['budget_type'] = $advertise->budget_type ? 'lifetime' : 'daily';
        $validated['ad_status'] = $advertise->ad_status ? 'Off' : 'On';

        js_send_email('Advertise Create : ' . $request->budget, $validated, config('mail.from.address'),'AdvertiseAdmin');
        // SendEmail::dispatchSync([
        //     'subject' => 'Advertise Create : ' . $request->budget,
        //     'data' => $validated,
        //     'email' => config('mail.from.address'),
        //     'view' => 'AdvertiseAdmin',
        // ]);

        AdminNotification::create([
            'title' => 'Advertise : ' . $validated['budget'],
            'description' => "Advertise Created.",
        ]);

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
            return $this->sendError('Record Not Found.', [], 200);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(AdvertiseRequest $request, $id)
    public function update(Request $request, $id)
    {
        $advertise = Advertise::whereNull('deleted_at')->find(base64_decode($id));
        if (!$advertise) {
            return $this->sendError('Record Not Found.', [], 200);
        }
        $validated = $request->all();
        $validator = Validator::make($validated, [
            'locations' => 'nullable|string',
            'redis' => 'nullable|numeric',
            'budget' => 'nullable|numeric',
            'budget_type' => 'nullable|in:0,1',
            'ad_status' => 'nullable|in:0,1',
            'start_date' => 'nullable|date_format:Y-m-d H:i:s',
            'end_date' => 'nullable|date_format:Y-m-d H:i:s|after_or_equal:start_date',
            'target' => 'nullable|in:0,1',
            'article_id' => 'nullable|in:0,1',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        // $validated = $request->validated();
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
            return $this->sendError('Record Not Found.', [], 200);
        }
    }

    public function getAdvertise(Request $request)
    {
        $latitude = isset($request->latitude) ? $request->latitude : null;
        $longitude = isset($request->longitude) ? $request->longitude : null;

        $advertise = $this->AdvertiseSingleRecordGet($latitude, $longitude);
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
                $click_charge = Transaction::where('article_id', $advertise->article_id)->where('created_at', '>=', Carbon::today())->sum('click_charge');
                $impression_charge = Transaction::where('article_id', $advertise->article_id)->where('created_at', '>=', Carbon::today())->sum('impression_charge');
                $today_charges = $click_charge + $impression_charge;
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

    public function AdvertiseSingleRecordGet($lat = null, $long = null)
    {
        $advertise = null;
        if ($lat && $long) {
            $latLong = DB::table("advertise_lat_longs")
                ->select(DB::raw("6371 * acos(cos(radians(" . $lat . "))
            * cos(radians(advertise_lat_longs.latitude))
            * cos(radians(advertise_lat_longs.longitude) - radians(" . $long . "))
            + sin(radians(" . $lat . "))
            * sin(radians(advertise_lat_longs.latitude))) AS distance,advertise_id"))
                ->having("distance", "<", 40)
                ->inRandomOrder()
                ->get();

            $advertiseId = [];
            foreach ($latLong as $advertise) {
                if (!in_array($advertise->advertise_id, $advertiseId)) {
                    $advertiseId[] = $advertise->advertise_id;
                }
            }
            $advertise = Advertise::where('target', 1)
                ->whereNull('deleted_at')
                ->whereIn('id', $advertiseId)
                ->where('status', 'Published')
                ->where('ad_status', 0)
                ->inRandomOrder()
                ->first();
        }
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
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
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
