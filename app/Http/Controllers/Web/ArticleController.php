<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.Article.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoryList = Category::whereNull('deleted_at')->get();
        return view('Admin.Article.create', compact('categoryList'));
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
        if ($image = $request->media) {
            $validated['media'] = $image->store('public/article');
        }
        $article = Article::create($validated);
        $data = [
            'to' => '/topics/junior',
            "notification" => [
                "title" => $request->title,
                "body" => $request->description,
            ],
        ];

        $encodedData = json_encode($data);
        $apiKey = env('FIREBASE_API_KEY');
        $headers = array(
            'Authorization: key=' . $apiKey,
            'Content-Type: application/json',
        );

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

        return redirect()->route('article.index')->with('success', 'Article Created SuccessFully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::find(base64_decode($id)) ?? abort(404);
        return view('Admin.Article.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::find(base64_decode($id)) ?? abort(404);
        $categoryList = Category::whereNull('deleted_at')->get();
        return view('Admin.Article.edit', compact('article', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, $id)
    {
        $article = Article::find(base64_decode($id)) ?? abort(404);
        $validated = $request->validated();
        if ($image = $validated['media'] ?? null) {
            if ($oldImage = $article->media ?? null) {
                $fileCheck = storage_path('app/' . $oldImage);
                if (file_exists($fileCheck)) {
                    unlink($fileCheck);
                }
            }
            $validated['media'] = $image->store('public/article');
        }
        $article->fill($validated)->save();
        return redirect()->route('article.index')->with('success', 'Article Updated SuccessFully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::where('id', base64_decode($id))->update(['deleted_at' => now()]);
        if ($article) {
            echo 1;
        } else {
            echo 0;
        }
        exit;
    }

    public function getArticleData()
    {
        $data = Article::with('category','user')->whereNull('deleted_at')->orderBy('id', 'desc');

        return DataTables::of($data)
            ->addColumn('active', function ($data) {
                $checked = ($data->status == 'Approved') ? 'checked' : '';
                return '<input type="checkbox" id="switcherySize2"  data-value="' . base64_encode($data->id) . '"  class="switchery switch" data-size="sm" ' . $checked . '  />';
            })
            ->addColumn('action', function ($data) {
                $data = '<a class="font-size-16" href="' . route('article.edit', base64_encode($data->id)) . '"  title="Push Notification"><i class="fa fa-edit fa-1x"></i></a>
                <a class="font-size-16 " href="' . route('article.show', base64_encode($data->id)) . '"  title="Push Notification"><i class="fa fa-eye fa-1x"></i></a>
                <a class="delete_row font-size-16" data-value = "' . route('article.destroy', base64_encode($data->id)) . '" title = "Delete"><i class="fa fa-trash-o"></i></a>';
                return $data;
            })
            ->addColumn('date', function ($data) {
                return date('Y-m-d H:i:s', strtotime($data->created_at));
            })
            ->addColumn('category_name', function ($data) {
                return $data->category->name ?? '';
            })
            ->editColumn('link', function ($data) {
                return '<a href="' . $data->link . '"  title="Article" target="_blank">' . $data->link . '</a>';
            })
            ->editColumn('user_id', function ($data) {
                return $data->user->name;
            })
            ->editColumn('image', function ($data) {
                if ($data->image_type == 0) {
                    return '<img src="' . $data->media_url . '" alt="Category Image" width="60" height="60" class="img-thumbnail">';
                } elseif ($data->image_type == 1) {
                    return '<video width="100" height="100" controls> <source src="' . $data->media_url . '" type="Article Video"></video>';
                }
                return;
            })->rawColumns(['date', 'action', 'category_name', 'image', 'link','active','user_id'])
            ->addIndexColumn()
            ->toJson();
    }

    public function status($id, $status){
        $article = Article::where('id', base64_decode($id))->update(['status' => $status]);
        if ($article) {
            echo 1;
        } else {
            echo 0;
        }
        exit;
    }
}
