@extends('layouts.app')

@section('content')

@include('components.heading', ['title' => 'Schedule a new Inspection'])

@include('components.form-results')

	@csrf
@verbatim
<div class="container">
	<div class="columns box">
		<div class="column">
			<div class="field">
			  <label class="label">Select Business</label>
			  <div class="control">
			  </div>
			</div>
		</div>
	</div>
	<br>
	<div class="columns box">
		<div class="column">
			<div class="field">
			  <label class="label">Select Business</label>
			  <div class="control">
					<input class="input" type="text" v-model="form.businessesSearchTerm">
			  </div>
			</div>
		</div>
	</div>
</div>
@endverbatim
@endsection

@section('page-last-scripts')
<script type="text/javascript" src="{{mix('/js/inspections-create.js')}}"></script>
@endsection