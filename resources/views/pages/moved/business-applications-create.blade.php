@extends('layouts.app')

@section('content')
@verbatim
<div v-can="'businesses.applications.create'">
@endverbatim

	@include('components.heading-dhivehi', ['title' => '‫ކާބޯތަކެތީގެ ޚިދުމަތްދޭ ތަންތަން ރަޖިސްޓްރީ ކުރުމާއި ހުއްދަ އާކުރަން އަދި ދުންފަތުގެ އިސްތިޢުމާލު ކުރުމަށް ޚާއްޞަ ކުރެވިފައިވާ ތަނުގެ/އޭރިޔާގެ ހުއްދައަށް އެދޭ ފޯމް'])

	@include('components.form-results')
	<input type='hidden' id="business_id" value="{{$businessId}}" />
	@verbatim
	<div class="container">	@endverbatim
		@include('components.application-form-body')
		@verbatim
		<div class="columns no-print">
			<div class="column center">
			    <button class="button is-success is-large" @click="onSubmit">ރައްކާ ކުރޭ</button>
			</div>
		</div>
	</div>
</div>
@endverbatim
@endsection

@section('page-last-scripts')
<script type="text/javascript" src="{{mix('/js/business-applications-create.js')}}"></script>
@endsection