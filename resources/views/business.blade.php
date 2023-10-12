<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ ucfirst($business->business_name) }}</title>
    <link rel="icon" type="image/x-icon" href="{{ $images ? $images[0] : '' }}">

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/custome.css') }}" rel="stylesheet" type="text/css">
</head>

<body>
    <!-- Page container -->
    <div class="container my-2">
        <div class="d-flex mt-5 mb-2">
            @foreach ($images as $image)
                <img src="{{ $image }}" alt="..." class="rounded img-thumbnail mx-1" width="300"
                    height="300">
            @endforeach
        </div>
        <h2>{{ ucfirst($business->business_name) }}</h2>
        <div class="d-flex align-items-center">
            <Strong class="btn btn-success">{{ $business->rating }}</Strong>
            <span class="ms-1">Rating</span>
            <span class="ms-3">{{ $business->review }} Review</span>
        </div>
        <p class="my-2">WebSite: <a href="{{ $business->website }}" target="blank">{{ $business->website }}</a></p>
        <h6>Description</h6>
        <p>{{ $business->description }}</p>
    </div>
</body>

</html>
