@extends('layouts.app')

@section('content')

@include('components.heading-dhivehi', ['title' => '‫ކާބޯތަކެތީގެ ޚިދުމަތްދޭ ތަންތަން ރަޖިސްޓްރީ ކުރުމާއި ހުއްދަ އާކުރަން އަދި ދުންފަތުގެ އިސްތިޢުމާލު ކުރުމަށް ޚާއްޞަ ކުރެވިފައިވާ ތަނުގެ/އޭރިޔާގެ ހުއްދައަށް އެދޭ ފޯމް'])

@include('components.form-results')

<form method="POST" action="{{route('applications.store')}}" v-on:submit.prevent="onSubmit">
	@csrf
@verbatim
<div class="container" v-can="'applications.store'">
	@endverbatim
	@include('components.application-form-body')
	@verbatim
	<div class="columns no-print" v-can="'applications.store'">
		<div class="column center">
		    <button class="button is-success is-large">ރައްކާ ކުރޭ</button>
		</div>
	</div>
</div>
</form>
@endverbatim
@endsection


@section('page-last-scripts')
<script type="text/javascript" src="{{mix('/js/applications-create.js')}}"></script>
@endsection