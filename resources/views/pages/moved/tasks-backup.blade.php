@extends('layouts.app')

@section('content')

@include('components.heading', ['title' => 'Tasks'])


	<div class="columns">
		<div class="column">
			<table class="table">
				<tr>
					<td colspan="2"><b>Front Desk</b></td>
				<tr>
					<td >
						<a class="button is-primary" href="{{route('applications.create')}}"><span>(1)New Application</span></a>
						<a class="button is-primary" href="{{route('applications.draft')}}"><span>(2)Draft Applications</span></a>
					</td>
				</tr>
				<tr>
					<td colspan="2"><b>Inspector</b></td>
				<tr>
					<td colspan="3">
						<a class="button is-primary" href="{{route('applications.create')}}"><span>New Application</span></a>
						<a class="button is-primary" href="{{route('applications.pending')}}"><span>(3)Pending Applications</span></a>
						<a class="button is-primary" href="{{route('inspections.upcoming')}}"><span>(4)Upcoming Inspections</span></a>
						<a class="button is-primary" href="{{route('normal-forms.processed')}}"><span>(6)Processed Inspection Forms</span></a>
						<a class="button is-primary" href="{{route('inspections.processed-reports')}}"><span>(8)Forms with Processed Reports</span></a>
					</td>
				</tr>
				<tr>
					<td colspan="2"><b>Supervisor</b></td>
				<tr>
					<td>
						<a class="button is-primary" href="{{route('applications.create')}}"><span>New Application</span></a>
						<a class="button is-primary" href="{{route('normal-forms.pending')}}"><span>(5)Pending Inspection Forms</span></a>
						<a class="button is-primary" href="{{route('inspections.pending-reports')}}"><span>(7)Forms with Pending Reports</span></a>
					</td>
				</tr>
				<tr>
					<td colspan="2"><b>Head Level</b></td>
				<tr>
					<td>
						<a class="button is-primary" href="{{route('applications.index')}}"><span>All Applications</span></a>
					</td>
				</tr>
			</table>
		</div>
	</div>
<!-- 	<div class="columns">
		<div class="column">
			<div class="field is-grouped">
			  <div class="control">
			    <button class="button is-link">Submit</button>
			  </div>
			  <div class="control">
			    <button class="button is-text">Cancel</button>
			  </div>
			</div>
		</div>
	</div> -->
@endsection