@extends('layouts.app')

@section('content')
@include('components.heading', ['title' => 'Edit Business'])

@include('components.form-results')
<div class="columns">
	<div class="column">
		<form method="POST" action="{{route('businesses.update', $business->id)}}">
			@csrf
			@method('patch')
			<table class="table is-bordered">
				<tr>
					<th colspan="2">Business Details</th>
				</tr>
				<tr>
					<td>Name:</td>
					<td><input type="text" class="input" name="name" value="{{$business->name}}"></td>
				</tr>
				<tr>
					<td>Name (Dhivehi):</td>
					<td class="dhivehi"><input type="text" class="input" name="name_dv" value="{{$business->name_dv}}"></td>
				</tr>
				<tr>
					<td>Registration No:</td>
					<td><input type="text" class="input" name="registration_no" value="{{$business->registration_no}}"></td>
				</tr>
				<tr>
					<td>Phone:</td>
					<td><input type="text" class="input" name="phone" value="{{$business->phone}}"></td>
				</tr>
<!-- 				<tr>
					<td>Expires at</td>
					<td><input type="text" class="input" name="expire_at" value="{{$business->expire_at}}"></td>
				</tr> -->
				<tr >
					<td style="text-align: center;" colspan="2">
						<button class="button is-warning is-large">Update</button>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
@endsection