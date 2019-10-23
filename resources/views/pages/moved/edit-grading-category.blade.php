@extends('layouts.app')

@section('content')
@verbatim
<div v-can="'grading-categories.edit'">
@endverbatim

@include('components.heading', ['title' => 'Edit the Grading Category'])

	<div class="container">
		<div class="columns">
			<div class="column">
				<div class="field is-grouped">
				  <div class="control">
					  <a href="{{route('grading-categories.manage')}}" class="button is-info is-medium" >
					    <span class="icon is-small">
					      <i class="fa fa-chevron-left"></i>
					    </span>
					    <span>Back to Grading Categories</span></a>
				  </div>
			  </div>
			</div>
		</div>
	</div>
	<input type='hidden' id="grading_category_id" value="{{$gradingCategoryId}}" />
	@verbatim
	<div class="container">
		<div class="columns">
			<div class="column">
				<table class="table is-bordered">
					<tr>
	          <th class="dhivehi right">ބޭނުންކުރޭ</th>
	          <th class="dhivehi right">ތަރުތީބު</th>
	          <th class="dhivehi right">ތަފްޞީލް</th>
					</tr>
					<tr>
	          <td><b-switch v-model="gradingCategory.is_active"></b-switch></td>
	          <td class="dhivehi"><input class="input" type="number" v-model="gradingCategory.order"></td>
	          <td class="dhivehi"><input class="input" type="text" v-model="gradingCategory.text"></td>
					</tr>	
				</table>
			</div>
		</div>
		<div class="columns">
			<div class="column"></div>
			<div class="column" style="text-align: center;">
				<div class="field is-grouped">
				  <div class="control">
	 					  <button class="button is-large is-warning" @click="updateGradingCategory">
						    <!-- <span class="icon"> -->
						      <!-- <i class="fa fa-save"></i> -->
						      UPDATE
						    <!-- </span> -->
						  </button>
				  </div>
				  <div class="control">
	 					  <button class="button is-large is-info" @click="getGradingCategory">
						    <!-- <span class="icon"> -->
						      <!-- <i class="fa fa-save"></i> -->
						      RESET
						    <!-- </span> -->
						  </button>
				  </div>
				  <div class="control">
	 					  <button class="button is-large is-danger" @click="deleteGradingCategory">
						    <!-- <span class="icon"> -->
						      <!-- <i class="fa fa-save"></i> -->
						      DELETE
						    <!-- </span> -->
						  </button>
				  </div>
				</div>
			</div>
			<div class="column"></div>
		</div>
	</div>
</div>
@endverbatim
@endsection

@section('page-last-scripts')
<script type="text/javascript" src="{{mix('/js/edit-grading-category.js')}}"></script>
@endsection