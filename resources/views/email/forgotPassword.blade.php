 @component('mail::message')
	<h1>We have received your request to reset your account password</h1>
	<p>You can click the folllowing link to reset your password:</p>

	@component('mail::panel')
	<a href="{{ route('reset.password.get', $token) }}" style="color:blue;text-decoration: none;font-size:15px;float:center">Click here to reset password</a>
	@endcomponent

<!-- p>The allowed duration of the code is one hour from the time the message was sent</p> -->
@endcomponent 

