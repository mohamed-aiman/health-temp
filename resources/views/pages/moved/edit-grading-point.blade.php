@extends('layouts.app')

@section('content')

@include('components.heading', ['title' => 'Edit the Grading Point'])

<div class="container">
	<div class="columns">
		<div class="column">
			<div class="field is-grouped">
			  <div class="control">
				  <a href="{{route('grading-points.manage')}}" class="button is-info is-medium" >
				    <span class="icon is-small">
				      <i class="fa fa-chevron-left"></i>
				    </span>
				    <span>Back to Grading Points</span></a>
			  </div>
		  </div>
		</div>
	</div>
</div>
<input type='hidden' id="grading_point_id" value="{{$gradingPointId}}" />
@verbatim
<div class="container">
	<div class="columns">
		<div class="column">
			<table class="table is-bordered">
				<tr>
          <th class=>ބޭނުންކުރޭ</th>
          <th class="dhivehi" style="text-align: right;">ގްރޫޕް</th>
          <th class="dhivehi" style="text-align: right;">ޕޮއިންޓް</th>
          <th class="dhivehi" style="text-align: right;">ކޯޑް</th>
          <th class="dhivehi" style="text-align: right;">ނަމްބަރު</th>
				</tr>
				<tr>
          <td><b-switch
          	v-model="gradingPoint.is_active"
          	></b-switch></td>
          <td class="dhivehi">
						<div class="select">
							<select v-model="gradingPoint.grading_category_id">
							  <option v-for="option in gradingCategories" v-bind:value="option.id">
							    {{ option.text }}
							  </option>
							</select>
						</div>
          </td>
          <td class="dhivehi"><input class="input" type="text" v-model="gradingPoint.text"></td>
          <td style="text-align: right;">
						<div class="select">
							<select v-model="gradingPoint.code" style="min-width: 10px;max-width: 200px; ">
								<option value="CR">Critical (CR)</option>
								<option value="MJ">Major (MJ)</option>
								<option value="MN">Minor (MN)</option>
							</select>
						</div>
					</td>
          <td class="dhivehi" style="min-width: 5px;max-width: 10px;"><input class="input" type="text" v-model="gradingPoint.no"></td>
				</tr>
			</table>
		</div>
	</div>
	<div class="columns">
		<div class="column"></div>
		<div class="column" style="text-align: center;">
			<div class="field is-grouped">
			  <div class="control">
 					  <button class="button is-large is-warning" @click="updateGradingPoint">
					    <!-- <span class="icon"> -->
					      <!-- <i class="fa fa-save"></i> -->
					      UPDATE
					    <!-- </span> -->
					  </button>
			  </div>
			  <div class="control">
 					  <button class="button is-large is-info" @click="getGradingPoint">
					    <!-- <span class="icon"> -->
					      <!-- <i class="fa fa-save"></i> -->
					      RESET
					    <!-- </span> -->
					  </button>
			  </div>
			  <div class="control">
 					  <button class="button is-large is-danger" @click="deleteGradingPoint">
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
@endverbatim
@endsection

@section('page-last-scripts')
<script type="text/javascript" src="{{mix('/js/edit-grading-point.js')}}"></script>
@endsection