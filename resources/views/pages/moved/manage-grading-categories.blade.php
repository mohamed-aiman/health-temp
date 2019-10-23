@extends('layouts.app')

@section('content')

@include('components.heading', ['title' => 'Manage Grading Categories'])
@verbatim
<div>
	<div class="columns">
		<div class="column">
			<div class="field is-grouped">
			  <div class="control">
 					  <a v-can="'manage'" href="/manage" class="button is-info is-medium" >
					    <span class="icon is-small">
					      <i class="fa fa-chevron-left"></i>
					    </span>
 					  	<span>Back to Manage</span>
 					  </a>
			  </div>
			  <div class="control">
 					  <button v-can="'grading-categories.storeApi'" v-if="!openForm" @click="switchOpenCloseForm" class="button is-success is-medium" >
 					  	<span>New Grading Category</span>
					    <span class="icon is-small">
					      <i class="fa fa-plus"></i>
					    </span>
 					  </button>
 					  <button v-can="'grading-categories.storeApi'" v-if="openForm" @click="switchOpenCloseForm" class="button is-warning is-medium" >
 					  	<span>Close Grading Category Form</span>
					    <span class="icon is-small">
					      <i class="fa fa-close"></i>
					    </span>
 					  </button>
			  </div>
		  </div>
		</div>
	</div>
</div>

<div v-can="'grading-categories.storeApi'" v-if="openForm">
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
          <td class="dhivehi"><input class="input" type="text" v-model="gradingCategory.order"></td>
          <td class="dhivehi"><input class="input" type="text" v-model="gradingCategory.text"></td>
				</tr>
				<tr>
 					  <td colspan="5" style="text-align: center;"><button class="button is-medium is-warning" @click="saveGradingCategory">SAVE</button></td>
				</tr>	
			</table>
		</div>
	</div>
</div>

<div v-can="'grading-categories.indexApi'">
	<div class="columns">
		<div class="column">
			<table class="table is-bordered">
				<tr>
					<th class="dhivehi right">ބޭނުންކުރޭ</th>
					<th class="dhivehi right">ތަރުތީބު</th>
					<th class="dhivehi right">ތަފްޞީލް</th>
					<th class="dhivehi right" v-can="'grading-categories.edit'">ބަދަލުގެނޭ</th>
				</tr>
				<tr v-for="item in items">
					<td>
					    <span class="icon has-text-success" v-if="item.is_active">
						  <i class="fas fa-check-square"></i>
						</span>
					    <span class="icon has-text-danger" v-if="!item.is_active">
						  <i class="fas fa-close"></i>
						</span>
		            </td>
		            <td class="dhivehi">{{item.order}}</td>
		            <td class="dhivehi">{{item.text}}</td>
		            <td v-can="'grading-categories.edit'">
					  <a class="button is-warning" :href="'/gradingcategories/' + item.id + '/edit'">
					    <span class="icon is-small">
					      <i class="fa fa-edit"></i>
					    </span>
					  </a>
		            </td>
				</tr>	
			</table>
		</div>
	</div>
</div>
@endverbatim
@endsection

@section('page-last-scripts')
<script type="text/javascript" src="{{mix('/js/manage-grading-categories.js')}}"></script>
@endsection