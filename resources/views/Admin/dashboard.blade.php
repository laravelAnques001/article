@extends('Admin.layouts.common')
@section('title')
    {{ config('app.name') }} | Dashboard
@endsection
@push('head_scripts')
    <script>
        $(document).ready(function() {
            $('.articleList').click(function() {
                window.location.replace("{{ route('article.index') }}");
            });

            $('.advertiseList').click(function() {
                window.location.replace("{{ route('advertise.index') }}");
            });

            $('.businessList').click(function() {
                window.location.replace("{{ route('business.index') }}");
            });

            $('.subscriptionPlanList').click(function() {
                window.location.replace("{{ route('subscriptionPlan.index') }}");
            });

            $('.servicesList').click(function() {
                window.location.replace("{{ route('services.index') }}");
            });

            $('.usersList').click(function() {
                window.location.replace("{{ route('users.index') }}");
            });

        });
    </script>
@endpush
@section('content')
    <div class="content">

        <div class="row">
            <div class="panel-heading pb-5">
                <h6 class="panel-title">Article</h6>
            </div>
            <div class="col-lg-3 articleList">
                <div class="panel bg-teal-400">
                    <div class="panel-body">
                        <h3 class="no-margin">{{ $articleTotal ?? 0 }}</h3>
                        Total Article
                    </div>
                </div>
            </div>

            <div class="col-lg-3 articleList">
                <div class="panel bg-info-300">
                    <div class="panel-body">
                        <h3 class="no-margin">{{ $article['In-Review'] ?? 0 }}</h3>
                        In-Review
                    </div>
                </div>
            </div>

            <div class="col-lg-3 articleList">
                <div class="panel bg-blue-400">
                    <div class="panel-body ">
                        <h3 class="no-margin">{{ $article['Approved'] ?? 0 }}</h3>
                        Approved
                    </div>
                </div>
            </div>

            <div class="col-lg-3 articleList">
                <div class="panel bg-pink-400">
                    <div class="panel-body ">
                        <h3 class="no-margin">{{ $article['Rejected'] ?? 0 }}</h3>
                        Rejected
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="panel-heading  pb-5">
                <h6 class="panel-title">Advertise</h6>
            </div>
            <div class="col-lg-3 advertiseList">
                <div class="panel bg-teal-400">
                    <div class="panel-body">
                        <h3 class="no-margin">{{ $advertiseTotal ?? 0 }}</h3>
                        Total Advertise
                    </div>
                </div>
            </div>

            <div class="col-lg-3 advertiseList">
                <div class="panel bg-info-300">
                    <div class="panel-body">
                        <h3 class="no-margin">{{ $advertise['Pending'] ?? 0 }}</h3>
                        Pending
                    </div>
                </div>
            </div>

            <div class="col-lg-3 advertiseList">
                <div class="panel bg-blue-400">
                    <div class="panel-body ">
                        <h3 class="no-margin">{{ $advertise['Published'] ?? 0 }}</h3>
                        Published
                    </div>
                </div>
            </div>

            <div class="col-lg-3 advertiseList">
                <div class="panel bg-pink-400">
                    <div class="panel-body ">
                        <h3 class="no-margin">{{ $advertise['Rejected'] ?? 0 }}</h3>
                        Rejected
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="panel-heading  pb-5">
                <h6 class="panel-title">Business </h6>
            </div>
            <div class="col-lg-3 businessList">
                <div class="panel bg-teal-400">
                    <div class="panel-body">
                        <h3 class="no-margin">{{ $businessTotal ?? 0 }}</h3>
                        Total Business
                    </div>
                </div>
            </div>

            <div class="col-lg-3 businessList">
                <div class="panel bg-info-300">
                    <div class="panel-body">
                        <h3 class="no-margin">{{ $business['Pending'] ?? 0 }}</h3>
                        Pending
                    </div>
                </div>
            </div>

            <div class="col-lg-3 businessList">
                <div class="panel bg-blue-400">
                    <div class="panel-body ">
                        <h3 class="no-margin">{{ $business['Approved'] ?? 0 }}</h3>
                        Approved
                    </div>
                </div>
            </div>

            <div class="col-lg-3 businessList">
                <div class="panel bg-pink-400">
                    <div class="panel-body ">
                        <h3 class="no-margin">{{ $business['Rejected'] ?? 0 }}</h3>
                        Rejected
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="panel-heading  pb-5">
                <h6 class="panel-title">User</h6>
            </div>
            <div class="col-lg-3 usersList">
                <div class="panel bg-teal-400">
                    <div class="panel-body">
                        <h3 class="no-margin">{{ $userTotal ?? 0 }}</h3>
                        Total User
                    </div>
                </div>
            </div>

            <div class="col-lg-3 usersList">
                <div class="panel bg-blue-400">
                    <div class="panel-body ">
                        <h3 class="no-margin">{{ $userActive ?? 0 }}</h3>
                        Active
                    </div>
                </div>
            </div>

            <div class="col-lg-3 usersList">
                <div class="panel bg-pink-400">
                    <div class="panel-body ">
                        <h3 class="no-margin">{{ $userRemove ?? 0 }}</h3>
                        Deactive
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="panel-heading  pb-5">
                <h6 class="panel-title">Subscription Plan</h6>
            </div>
            <div class="col-lg-3 subscriptionPlanList">
                <div class="panel bg-teal-400">
                    <div class="panel-body">
                        <h3 class="no-margin">{{ $subscriptionPlanTotal ?? 0 }}</h3>
                        Total Subscription Plan
                    </div>
                </div>
            </div>

            <div class="col-lg-3 subscriptionPlanList">
                <div class="panel bg-blue-400">
                    <div class="panel-body ">
                        <h3 class="no-margin">{{ $subscriptionPlan['Active'] ?? 0 }}</h3>
                        Active
                    </div>
                </div>
            </div>

            <div class="col-lg-3 subscriptionPlanList">
                <div class="panel bg-pink-400">
                    <div class="panel-body ">
                        <h3 class="no-margin">{{ $subscriptionPlan['Deactive'] ?? 0 }}</h3>
                        Deactive
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="panel-heading  pb-5">
                <h6 class="panel-title">Services </h6>
            </div>
            <div class="col-lg-3 usersList">
                <div class="panel bg-teal-400">
                    <div class="panel-body">
                        <h3 class="no-margin">{{ $servicesTotal ?? 0 }}</h3>
                        Total Services
                    </div>
                </div>
            </div>

            <div class="col-lg-3 usersList">
                <div class="panel bg-blue-400">
                    <div class="panel-body ">
                        <h3 class="no-margin">{{ $services['Active'] ?? 0 }}</h3>
                        Active
                    </div>
                </div>
            </div>

            <div class="col-lg-3 usersList">
                <div class="panel bg-pink-400">
                    <div class="panel-body ">
                        <h3 class="no-margin">{{ $services['Deactive'] ?? 0 }}</h3>
                        Deactive
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
