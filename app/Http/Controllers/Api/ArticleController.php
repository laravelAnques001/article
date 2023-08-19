<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Models\ArticleLikeShare;
use App\Models\CategoryUser;
use FFMpeg;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = auth()->id();
        $search = isset($request->search) ? $request->search : null;
        $myArticle = isset($request->myArticle) ? $request->myArticle : null;
        // $topStories = isset($request->topStories) ? $request->topStories : null;
        $relevanceStories = isset($request->relevanceStories) ? $request->relevanceStories : null;
        $trending = isset($request->trending) ? $request->trending : null;
        $bookmarked = isset($request->bookmarked) ? $request->bookmarked : null;
        $userCategory = CategoryUser::where('user_id', $userId)->pluck('category_id')->toArray();

        $articles = Article::select('id', 'title', 'link', 'tags', 'description', 'image_type', 'user_id', 'category_id', 'created_at', 'media', 'thumbnail', 'status')
            ->with(['user' => function ($q) {
                $q->select('name', 'email', 'id', 'image');
            }])
            ->with(['category' => function ($q) {
                $q->select('id', 'name', 'image');

            }])
            ->whereIn('category_id', $userCategory);

        if ($search) {
            $articlesData = $articles->where('title', 'like', '%' . $search . '%')
                ->orWhere('link', 'like', '%' . $search . '%')
                ->orWhere('tags', 'like', '%' . $search . '%')
                ->orWhere('image_type', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('category', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })
                ->whereNull('deleted_at')
                ->orderByDesc('id')
                ->paginate(20);
        } elseif ($myArticle) {
            $orderDataDesc = $articles->where('user_id', $userId)->whereNull('deleted_at')->orderByDesc('id')->get();
            $articlesData = $this->paginate('myArticle=1', $orderDataDesc, 20);
        } elseif ($bookmarked) {
            $orderDataDesc = $articles->whereNull('deleted_at')->whereHas('articleLikeShare', function ($q) use ($userId) {
                $q->where('bookmark', 1)->where('user_id', $userId);
            })->orderByDesc('id')->get();
            $articlesData = $this->paginate('bookmarked=1', $orderDataDesc, 20);
        } elseif ($trending) {
            $articleData = $articles->whereNull('deleted_at')->orderByDesc('id')->get();
            $orderData = new Collection($articleData);
            $orderDataDesc = $orderData->sortByDesc('like_count')->sortByDesc('share_count')->sortByDesc('impressions_count');
            $articlesData = $this->paginate('topStories=1', $orderDataDesc, 20);
        } else {
            $articlesData = $articles->whereNull('deleted_at')->orderByDesc('id')->paginate(20);
        }
        return $this->sendResponse($articlesData, 'Article List Get Successfully.');
    }

    public function paginate($flag = null, $items, $perPage = 20, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath() . '?' . $flag,
            'pageName' => 'page',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        $validated = $request->validated();
        $image = isset($validated['media']) ? $validated['media'] : null;
        if ($image) {
            $validated['media'] = $image->store('public/storage/article');
            if ($request->image_type) {
                $filePath = substr($validated['media'], 7);
                $storagePath = 'article/thumbnail/' . time() . ".png";
                FFMpeg::fromDisk('public')
                    ->open($filePath)
                    ->getFrameFromSeconds(10)
                    ->export()
                    ->toDisk('public')
                    ->save($storagePath);
                $validated['thumbnail'] = 'public/' . $storagePath;
            }
        }
        $article = Article::create($validated);
        // $data = [
        //     'to' => '/topics/junior',
        //     "notification" => [
        //         "title" => $request->title,
        //         "body" => $request->description,
        //     ],
        // ];

        // $encodedData = json_encode($data);
        // $apiKey = env('FIREBASE_API_KEY');
        // $headers = array(
        //     'Authorization: key=' . $apiKey,
        //     'Content-Type: application/json',
        // );

        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // $result = curl_exec($ch);
        // curl_close($ch);

        $fcmTokens = User::whereNotNull('device_token')->pluck('device_token')->toArray();
        Larafirebase::withTitle($request->title)
            ->withBody($request->description)
            ->sendMessage($fcmTokens);

        return $this->sendResponse($article->id, 'Article Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::select('id', 'title', 'link', 'tags', 'description', 'image_type', 'user_id', 'category_id', 'created_at', 'media', 'status')
            ->with(['user' => function ($q) {
                $q->select('name', 'email', 'id', 'image');
            }])
            ->with(['category' => function ($q) {
                $q->select('id', 'name', 'image');
            }])
            ->whereNull('deleted_at')->find(base64_decode($id));
        if ($article) {
            return $this->sendResponse($article, 'Article Record Get Successfully.');
        } else {
            return $this->sendError([], 'Record Not Found.');
        }
    }

    public function update(ArticleRequest $request, $id)
    {
        $article = Article::whereNull('deleted_at')->find(base64_decode($id));
        if (!$article) {
            return $this->sendError([], 'Record Not Found.');
        }
        $validated = $request->validated();
        // return $request->media;
        $image = isset($validated['media']) ? $validated['media'] : null;
        $oldMedia = isset($article->media) ? $article->media : null;
        $oldThumbnail = isset($article->thumbnail) ? $article->thumbnail : null;
        if ($image) {
            if ($oldMedia) {
                $fileCheck = storage_path('app/' . $oldMedia);
                if (file_exists($fileCheck)) {
                    unlink($fileCheck);
                }
            }
            if ($oldThumbnail) {
                $fileCheck = storage_path('app/' . $oldThumbnail);
                if (file_exists($fileCheck)) {
                    unlink($fileCheck);
                }
            }
            $validated['media'] = $image->store('public/article');
            if ($request->image_type) {
                $filePath = substr($validated['media'], 7);
                $storagePath = 'article/thumbnail/' . time() . ".png";
                FFMpeg::fromDisk('public')
                    ->open($filePath)
                    ->getFrameFromSeconds(10)
                    ->export()
                    ->toDisk('public')
                    ->save($storagePath);
                $validated['thumbnail'] = 'public/' . $storagePath;
            }
        }
        // return $validated;
        $article->fill($validated)->save();
        return $this->sendResponse([], 'Article Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::whereNull('deleted_at')->find(base64_decode($id));
        if ($article) {
            $article->fill(['deleted_at' => now()])->save();
            return $this->sendResponse([], 'Article Deleted Successfully.');
        } else {
            return $this->sendError([], 'Record Not Found.');
        }
    }

    public function likeShare(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'article_id' => 'required|exists:articles,id',
            'like' => 'nullable|in:1,0',
            'share' => 'nullable|in:1,0',
            'impressions' => 'nullable|in:1,0',
            'bookmark' => 'nullable|in:1,0',
        ]);

        if ($validated->fails()) {
            return $this->sendError($validated->errors(), 'Validation Error.');
        }

        $articleLSI = ArticleLikeShare::where('user_id', auth()->id())->where('article_id', $request->article_id)->first();

        $impressions = isset($request->impressions) ? $request->impressions : 0;
        $like = isset($request->like) ? $request->like : 0;
        $share = isset($request->share) ? $request->share : 0;
        $bookmark = isset($request->bookmark) ? $request->bookmark : 0;
        $report = isset($request->report) ? $request->report : null;
        if (is_null($articleLSI)) {
            ArticleLikeShare::create([
                'article_id' => $request->article_id,
                'user_id' => auth()->id(),
                'impressions' => $impressions,
                'like' => $like,
                'share' => $share,
                'bookmark' => $bookmark,
                'report' => $report,
            ]);
        } else {
            if ($impressions) {
                $articleLSI->increment('impressions', 1);
            }
            if ($like) {
                $articleLSI['like'] = $like;
            }
            if ($share) {
                $articleLSI['share'] = $share;
            }
            if ($bookmark) {
                $articleLSI['bookmark'] = $bookmark;
            }
            if ($report) {
                $articleLSI['report'] = $report;
            }
            $articleLSI->save();
        }

        return $this->sendResponse([], 'Like-Share Article Successfully.');
    }
}
