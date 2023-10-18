<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\ArticleCreateFirebaseJob;
use App\Mail\ArticleCreateAdminMail;
use App\Models\Article;
use App\Models\ArticleLikeShare;
use App\Models\ArticleNotification;
use App\Models\CategoryUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
        $search = isset($request->search) ? $request->search : null;
        $insights = isset($request->insights) ? $request->insights : null;
        $trending = isset($request->trending) ? $request->trending : null;

        $articles = $this->commonArticle()->where('status', 'Approved');

        if ($search) {
            $articlesData = $articles->where('title', 'like', '%' . $search . '%')
                ->orWhere('tags', 'like', '%' . $search . '%')
                ->orWhereHas('category', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })
                ->orderByDesc('id')
                ->paginate(10);

        } elseif ($trending) {
            $articlesData = $articles->orderByDesc('impression')->paginate(10);
        } elseif ($insights) {
            $articlesData = $articles->orderByDesc('id')->paginate(10);
        } else {
            $articlesData = $articles->orderByDesc('id')->paginate(10);
        }
        return $this->sendResponse($articlesData, 'Article List Get Successfully.');
    }

    public function userArticle(Request $request)
    {
        $userId = auth()->id();
        $userCategory = CategoryUser::where('user_id', $userId)->pluck('category_id')->toArray();
        $relevanceStories = isset($request->relevanceStories) ? $request->relevanceStories : null;
        $myArticle = isset($request->myArticle) ? $request->myArticle : null;
        $bookmarked = isset($request->bookmarked) ? $request->bookmarked : null;
        $insights = isset($request->insights) ? $request->insights : null;
        $trending = isset($request->trending) ? $request->trending : null;
        $search = isset($request->search) ? $request->search : null;

        // $articles = $this->commonArticle()->when($userCategory, function ($q) use ($userCategory) {
        //     $q->whereIn('category_id', $userCategory);
        // });
        $articles = $this->commonArticle();

        if ($search) {
            $articlesData = $articles->where('title', 'like', '%' . $search . '%')
                ->orWhere('tags', 'like', '%' . $search . '%')
                ->orWhereHas('category', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })->where('status', 'Approved')
                ->orderByDesc('id')
                ->paginate(10);

        } elseif ($myArticle) {
            $articlesData = $articles->where('user_id', $userId)->orderByDesc('id')->paginate(10);
        } elseif ($bookmarked) {
            $articlesData = $articles->whereHas('articleLikeShare', function ($q) use ($userId) {
                $q->where('bookmark', 1)->where('user_id', $userId);
            })->orderByDesc('id')->paginate(10);
        } elseif ($trending) {
            $articlesData = $articles->where('status', 'Approved')->orderByDesc('impression')->paginate(10);
        } elseif ($insights) {
            $articlesData = $articles->where('status', 'Approved')->orderByDesc('id')->paginate(10);
        } elseif ($relevanceStories) {
            $articlesData = $articles->where('status', 'Approved')->orderByDesc('id')->paginate(10);
        } else {
            $articlesData = $articles->where('status', 'Approved')->orderByDesc('id')->paginate(10);
        }
        return $this->sendResponse($articlesData, 'Article List Get Successfully.');
    }

    public function commonArticle()
    {
        $userId = auth()->id();
        // $userCategory = CategoryUser::where('user_id', $userId)->pluck('category_id')->toArray();
        return Article::select('id', 'title', 'link', 'tags', 'description', 'image_type', 'user_id', 'category_id', 'created_at', 'media', 'thumbnail', 'status', 'impression', 'share')
            ->with(['user' => function ($q) {
                $q->select('name', 'email', 'id', 'image');
            }])
            ->with(['category' => function ($q) {
                $q->select('id', 'name', 'image');

            }])->whereNull('deleted_at');
    }

    public function topics(Request $request)
    {
        $category_id = isset($request->category_id) ? $request->category_id : null;
        if ($category_id) {
            $articles = $this->commonArticle()->whereHas('category', function ($q) use ($category_id) {
                $q->where('id', $category_id);
            })->orderByDesc('id')->paginate(10);
        } else {
            $articles = $this->commonArticle()->orderByDesc('id')->paginate(10);
        }
        return $this->sendResponse($articles, 'Article List Get Successfully.');
    }

    // public function myArticle()
    // {
    //     $userId = auth()->id();
    //     $articles = $this->commonArticle()->where('user_id', $userId)->orderByDesc('id')->paginate(20);
    //     return $this->sendResponse($articles, 'Article List Get Successfully.');
    // }

    // public function bookmarkArticle()
    // {
    //     $userId = auth()->id();
    //     $articles = $this->commonArticle()->whereHas('articleLikeShare', function ($q) use ($userId) {
    //         $q->where('bookmark', 1)->where('user_id', $userId);
    //     })->orderByDesc('id')->paginate(20);
    //     return $this->sendResponse($articles, 'Article List Get Successfully.');
    // }

    // public function trendingArticle()
    // {
    //     $articles = $this->commonArticle()->orderByDesc('impression')->paginate(20);
    //     return $this->sendResponse($articles, 'Article List Get Successfully.');
    // }

    // public function paginate($flag = null, $items, $perPage = 20, $page = null, $options = [])
    // {
    //     $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
    //     $items = $items instanceof Collection ? $items : Collection::make($items);
    //     return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, [
    //         'path' => LengthAwarePaginator::resolveCurrentPath() . '?' . $flag,
    //         'pageName' => 'page',
    //     ]);
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(ArticleRequest $request)
    public function store(Request $request)
    {
        $validated = $request->all();
        $categories = array_filter((explode(',', $request->input('category_id'))), 'strlen');
        $validated['category_id'] = $categories;
        $validator = Validator::make($validated, [
            'link' => 'nullable|string',
            'tags' => 'nullable|string|min:3',
            'description' => 'nullable|string|min:3',
            'image_type' => 'nullable|in:0,1,2',
            'media' => 'nullable|string',
            'thumbnail' => 'nullable|string',
            'status' => 'nullable|in:In-Review,Approved,Rejected',
            'category_id.*' => 'required|exists:categories,id',
            'title' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        // $validated = $request->validated();
        // $categories = explode(',', $request->input('category_id'));
        // $validator = Validator::make(['category_id' => $categories], [
        //     'category_id.*' => 'exists:categories,id',
        // ]);
        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 422);
        // }
        unset($validated['category_id']);
        // $image = isset($validated['media']) ? $validated['media'] : null;
        // if ($image) {
        //     $validated['media'] = $image->store('public/storage/article');
        //     if ($request->image_type) {
        //         $filePath = substr($validated['media'], 7);
        //         $storagePath = 'article/thumbnail/' . time() . ".png";
        //         FFMpeg::fromDisk('public')
        //             ->open($filePath)
        //             ->getFrameFromSeconds(10)
        //             ->export()
        //             ->toDisk('public')
        //             ->save($storagePath);
        //         $validated['thumbnail'] = 'public/' . $storagePath;
        //     }
        // }
        $article = Article::create($validated);
        $article->category()->attach($categories);
        dispatch(new ArticleCreateFirebaseJob($article));
        ArticleNotification::create([
            'article_id' => $article->id,
        ]);
        // Notification::send(null, new SendPushNotification($request->title, $article, $fcmTokens));
        Mail::to(config('mail.from.address'))->send(new ArticleCreateAdminMail($article));

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
        $article = Article::select('id', 'title', 'link', 'tags', 'description', 'image_type', 'user_id', 'category_id', 'created_at', 'media', 'status', 'impression', 'share', 'thumbnail')
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
            return $this->sendError('Record Not Found.');
        }
    }

    public function update(Request $request, $id)
    {
        $article = Article::whereNull('deleted_at')->find(base64_decode($id));
        if (!$article) {
            return $this->sendError('Record Not Found.');
        }
        $validated = $request->all();
        $categories = array_filter((explode(',', $request->input('category_id'))), 'strlen');
        $validated['category_id'] = $categories;
        $validator = Validator::make($validated, [
            'link' => 'nullable|string',
            'tags' => 'nullable|string|min:3',
            'description' => 'nullable|string|min:3',
            'image_type' => 'nullable|in:0,1,2',
            'media' => 'nullable|string',
            'thumbnail' => 'nullable|string',
            'status' => 'nullable|in:In-Review,Approved,Rejected',
            'category_id.*' => 'nullable|exists:categories,id',
            'title' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        // $validated = $request->validated();
        // if ($category_id = $request->category_id) {
        //     $categories = explode(',', $category_id);
        //     $validator = Validator::make(['category_id' => $categories], [
        //         'category_id.*' => 'exists:categories,id',
        //     ]);
        //     if ($validator->fails()) {
        //         return response()->json(['errors' => $validator->errors()], 422);
        //     }
        $article->category()->sync($categories);
        // }
        unset($validated['category_id']);

        // $image = isset($validated['media']) ? $validated['media'] : null;
        // $oldMedia = isset($article->media) ? $article->media : null;
        // $oldThumbnail = isset($article->thumbnail) ? $article->thumbnail : null;
        // if ($image) {
        //     if ($oldMedia) {
        //         $fileCheck = storage_path('app/' . $oldMedia);
        //         if (file_exists($fileCheck)) {
        //             unlink($fileCheck);
        //         }
        //     }
        //     if ($oldThumbnail) {
        //         $fileCheck = storage_path('app/' . $oldThumbnail);
        //         if (file_exists($fileCheck)) {
        //             unlink($fileCheck);
        //         }
        //     }
        //     $validated['media'] = $image->store('public/article');
        //     if ($request->image_type) {
        //         $filePath = substr($validated['media'], 7);
        //         $storagePath = 'article/thumbnail/' . time() . ".png";
        //         FFMpeg::fromDisk('public')
        //             ->open($filePath)
        //             ->getFrameFromSeconds(10)
        //             ->export()
        //             ->toDisk('public')
        //             ->save($storagePath);
        //         $validated['thumbnail'] = 'public/' . $storagePath;
        //     }
        // }

        $validated['status'] = 'In-Review';
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
            return $this->sendError('Record Not Found.');
        }
    }

    public function likeShare(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'article_id' => 'required|exists:articles,id',
            'share' => 'nullable|in:1,0',
            'impressions' => 'nullable|in:1,0',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => $validated->errors()->first()]);
        }

        //article start
        $share = isset($request->share) ? 1 : 0;
        $impressions = isset($request->impressions) ? 1 : 0;

        $article = Article::find($request->article_id);
        $article->share += $share;
        $article->impression += $impressions;
        $article->save();
        //article end

        return $this->sendResponse([], 'Like-Share Article Successfully.');
    }

    public function likeShareUser(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'article_id' => 'required|exists:articles,id',
            'like' => 'nullable|in:1,0',
            'impressions' => 'nullable|in:1,0',
            'bookmark' => 'nullable|in:1,0',
            'report' => 'nullable|string',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => $validated->errors()->first()]);
        }

        $articleLSI = ArticleLikeShare::where('user_id', auth()->id())->where('article_id', $request->article_id)->first();

        // $impressions = isset($request->impressions) ? $request->impressions : 0;
        $like = isset($request->like) ? $request->like : 0;
        // $share = isset($request->share) ? $request->share : 0;
        $bookmark = isset($request->bookmark) ? $request->bookmark : 0;
        $report = isset($request->report) ? $request->report : null;
        if (is_null($articleLSI)) {
            ArticleLikeShare::create([
                'article_id' => $request->article_id,
                'user_id' => auth()->id(),
                // 'impressions' => $impressions,
                'like' => $like,
                // 'share' => $share,
                'bookmark' => $bookmark,
                'report' => $report,
            ]);
        } else {
            // if ($impressions) {
            //     $articleLSI->increment('impressions', 1);
            // }
            if ($like) {
                $articleLSI['like'] = $like;
            }
            // if ($share) {
            //     $articleLSI['share'] = $share;
            // }
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

    public function articleNotification()
    {
        $notification = ArticleNotification::with(['article' => function ($q) {
            $q->select('id', 'title', 'link', 'tags', 'description', 'image_type', 'user_id', 'category_id', 'created_at', 'media', 'thumbnail', 'status', 'impression');
        }])->with(['article.user' => function ($q) {
            $q->select('name', 'email', 'id', 'image');
        }])->with(['article.category' => function ($q) {
            $q->select('id', 'name', 'image');
        }])->orderByDesc('id')->paginate(10);

        return $this->sendResponse($notification, 'Article List Get Successfully.');
    }

    public function impressionIncrement($id)
    {
        $article = Article::find(base64_decode($id));
        $article->impression += 1;
        $article->save();
        return $this->sendResponse(['count' => $article->impression], 'Article List Get Successfully.');
    }
}
