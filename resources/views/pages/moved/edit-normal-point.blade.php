@extends('layouts.app')

@section('content')

@include('components.heading', ['title' => 'Edit the Normal Point'])

<div class="container">
	<div class="columns">
		<div class="column">
			<div class="field is-grouped">
			  <div class="control">
				  <a href="{{route('normal-points.manage')}}" class="button is-info is-medium" >
				    <span class="icon is-small">
				      <i class="fa fa-chevron-left"></i>
				    </span>
				    <span>Back to Normal Points</span></a>
			  </div>
		  </div>
		</div>
	</div>
</div>
<input type='hidden' id="normal_point_id" value="{{$normalPointId}}" />
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
          	v-model="normalPoint.is_active"
          	></b-switch></td>
          <td class="dhivehi">
						<div class="select">
							<select v-model="normalPoint.normal_category_id">
							  <option v-for="option in normalCategories" v-bind:value="option.id">
							    {{ option.text }}
							  </option>
							</select>
						</div>
          </td>
          <td class="dhivehi"><input class="input" type="text" v-model="normalPoint.text"></td>
          <td style="text-align: right;">
						<div class="select">
							<select v-model="normalPoint.code" style="min-width: 10px;max-width: 200px; ">
								<option value="CR">Critical (CR)</option>
								<option value="MJ">Major (MJ)</option>
								<option value="MN">Minor (MN)</option>
							</select>
						</div>
					</td>
          <td class="dhivehi" style="min-width: 5px;max-width: 10px;"><input class="input" type="text" v-model="normalPoint.no"></td>
				</tr>
			</table>
		</div>
	</div>
	<div class="columns">
		<div class="column"></div>
		<div class="column" style="text-align: center;">
			<div class="field is-grouped">
			  <div class="control">
 					  <button class="button is-large is-warning" @click="updateNormalPoint">
					    <!-- <span class="icon"> -->
					      <!-- <i class="fa fa-save"></i> -->
					      UPDATE
					    <!-- </span> -->
					  </button>
			  </div>
			  <div class="control">
 					  <button class="button is-large is-info" @click="getNormalPoint">
					    <!-- <span class="icon"> -->
					      <!-- <i class="fa fa-save"></i> -->
					      RESET
					    <!-- </span> -->
					  </button>
			  </div>
			  <div class="control">
 					  <button class="button is-large is-danger" @click="deleteNormalPoint">
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
<script type="text/javascript" src="{{mix('/js/edit-normal-point.js')}}"></script>
@endsection