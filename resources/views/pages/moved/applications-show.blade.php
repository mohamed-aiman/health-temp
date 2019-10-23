@extends('layouts.app')

@section('content')
@verbatim
<div v-can="'applications.show'">
@endverbatim

	<input type='hidden' id="application_id" value="{{(isset($application)) ? $application->id : null}}" />
	@verbatim
	<div class="container" v-can="'applications.show'">
		@endverbatim
		@include('components.application-view-body')
		@verbatim
	</div>
</div>
@endverbatim
@endsection

@section('page-last-scripts')
<script type="text/javascript" src="{{mix('/js/applications-show.js')}}"></script>
@endsection
