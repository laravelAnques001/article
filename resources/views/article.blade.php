<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ucfirst($article->title)}}</title>
    <link rel="icon" type="image/x-icon" href="{{$article->image_type == 0 ? $article->media : ''}}">

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/custome.css') }}" rel="stylesheet" type="text/css">  
</head>

<body class="login-container">
    <!-- Page container -->
    <div class="page-container">
        <!-- Page content -->
        <div class="page-content">

            <!-- Main content -->
            <div class="content-wrapper">

                <!-- Content area -->
                <div class="content">

                    <div class="container" style="margin-top:15px">
                        <div class="justify-content-center">
                            @if ($article->image_type == 0)
                                <img src="{{ $article->media }}" alt="Article Image" class="wizard border-radius">
                            @elseif($article->image_type == 1)
                                <video src="{{ $article->media }}"></video>
                            @endif
                        </div>
                        <h1>{{ ucfirst($article->title) }}</h1>
                        <p>{{ $article->tags }} <img src="{{ asset('assets/images/trending.png') }}" width="20">
                            <span class="m-20">{{ $article->day_ago }}</span>
                        </p>
                        <h5>Category : {{ implode(', ', $article->category->pluck('name')->toArray()) }}</h5>
                        <p>{{ $article->description }}</p>
                        <p>- {{ $article->user->name }}</p>
                        <p><span class="m-20">Like : {{ $article->like_count }}</span> <span class="m-20"> Share :
                                {{ $article->share_count }}</span></p>
                    </div>

                </div>
                <div class="footer text-muted text-center">
                    © {{ date('Y') }} . <a href="#">{{ env('APP_NAME') }}</a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>


