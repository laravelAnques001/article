<p>Welcome To {{ config('app.name') }}</p>
<p>Your login OTP => {{ $data['otp'] }}</p>
<p>Dear @if($data['user_name']) @{{$data['user_name']}}, @else Sir/Ma'am, @endif</p>
<p>This code is valid for the next 10 min only. If you don't requested the OTP, Please ignore the mail.</p>
<p>Thank you,</p>
<p>({{ config('app.name') }}) -  Product of Technolit Affluenza Private Limited (since 2016)</p>
<img src="https://businessflips.in/assets/images/BusinessFlipslogo.jpg" width="50" height="50" style="margin-right:10px"> {{ config('app.name') }}

