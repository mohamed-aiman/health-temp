@extends('layouts.app')

@section('content')
@include('components.heading', ['title' => '‫INSPECTION REPORT OF FOOD ESTABLISHMENT'])

@include('components.form-results')

<input type='hidden' id="report_id" value="{{(isset($report)) ? $report->id : null}}" />
<input type='hidden' id="inspection_id" value="{{(isset($report)) ? $report->inspection_id : null}}" />
@verbatim
<div class="container">
	<div class="columns box">
		<table class="table is-narrow">
			<tr>
				<td>Establishment Name</td>
				<td>
					<div class="field">
					  <div class="control">
							<input class="input" type="text" disabled v-model="form.establishmentName">
					  </div>
					</div>
				</td>
			</tr>
			<tr>
				<td>Date of Inspection</td>
				<td>
					<div class="field">
					  <div class="control">
							<input class="input" type="text" disabled v-model="form.dateOfInspection">
					  </div>
					</div>
				</td>
			</tr>
		</table>
	</div>
	<br>
	<div class="columns box">
		<div class="column">
			<div class="field">
			  <label class="label">SCOPE OF INSPECTION:</label>
			  <div class="control">
					<textarea class="textarea" v-model="form.scopeOfInspection"></textarea>
			  </div>
			</div>
		</div>
	</div>
	<br>
	<div class="columns box">
		<div class="column">
			<div class="field">
			  <label class="label">AREAS INSPECTED:</label>
			  <div class="control">
					<textarea class="textarea" v-model="form.areasInspected"></textarea>
			  </div>
			</div>
		</div>
	</div>


	<div class="columns">
		<div class="column">
			<label class="label">1. CRITICAL FACTORS / VIOLATIONS that require immediate corrective action</label>
		</div>
	</div>

	<div class="columns box">
		<div class="column">
			<table class="table is-narrowed">
				<tr>
					<th>VIOLATIONS</th>
					<th>CORRECTIVE ACTION</th>
					<th>action</th>
				</tr>
				<tr>
					<td>
						<div class="field">
						  <div class="control">
								<input class="input" type="text" v-model="form.criticalViolation">
						  </div>
						</div>
					</td>
					<td>
						<div class="field">
						  <div class="control">
								<input class="input" type="text" v-model="form.criticalCorrectiveAction">
						  </div>
						</div>
					</td>
					<td>
					  <p class="buttons">
						  <a class="button is-success"  @click="addItem('criticalFactors')">
						    <span class="icon is-small">
						      <i class="fa fa-plus"></i>
						    </span>
						  </a>
						  <!-- <a class="button is-warning" @click="cancel('criticalFactors')">
						    <span class="icon is-small">
						      <i class="fa fa-times"></i>
						    </span>
						  </a> -->
					  </p>
					</td>
				</tr>
				<tr v-for="item,key in critical">
					<td>{{item.v}}</td>
					<td>{{item.r}}</td>
					<td>
						<p class="buttons">
						  <!-- <a class="button is-warning" @click="editItem('criticalFactors',item, key)">
						    <span class="icon is-small">
						      <i class="fa fa-edit"></i>
						    </span>
						  </a> -->
						  <a class="button is-danger" @click="removeItem('criticalFactors', item, key)">
						    <span class="icon is-small">
						      <i class="fa fa-times"></i>
						    </span>
						  </a>
						</p>
					</td>
				</tr>
			</table>
		</div>
	</div>


	<div class="columns">
		<div class="column">
			<label class="label">2. MAJOR FACTORS / VIOLATIONS that require corrective actions in a given time</label>
		</div>
	</div>

	<div class="columns box">
		<div class="column">
			<table class="table is-narrowed">
				<tr>
					<th>VIOLATIONS</th>
					<th>CORRECTIVE ACTIONS</th>
					<th>action</th>
				</tr>
				<tr>
					<td>
						<div class="field">
						  <div class="control">
								<input class="input" type="text" v-model="form.majorViolation">
						  </div>
						</div>
					</td>
					<td>
						<div class="field">
						  <div class="control">
								<input class="input" type="text" v-model="form.majorCorrectiveAction">
						  </div>
						</div>
					</td>
					<td>
					  <p class="buttons">
						  <a class="button is-success"  @click="addItem('majorFactors')">
						    <span class="icon is-small">
						      <i class="fa fa-plus"></i>
						    </span>
						  </a>
						  <!-- <a class="button is-warning" @click="cancel('majorFactors')">
						    <span class="icon is-small">
						      <i class="fa fa-times"></i>
						    </span>
						  </a> -->
					  </p>
					</td>
				</tr>
				<tr v-for="item,key in major">
					<td>{{item.v}}</td>
					<td>{{item.r}}</td>
					<td>
						<p class="buttons">
						  <!-- <a class="button is-warning" @click="editItem('majorFactors',item, key)">
						    <span class="icon is-small">
						      <i class="fa fa-edit"></i>
						    </span>
						  </a> -->
						  <a class="button is-danger" @click="removeItem('majorFactors', item, key)">
						    <span class="icon is-small">
						      <i class="fa fa-times"></i>
						    </span>
						  </a>
						</p>
					</td>
				</tr>
			</table>
		</div>
	</div>

<div class="columns">
		<div class="column">
			<label class="label">3. OTHER OBSERVATIONS (Requires corrective actions)</label>
		</div>
	</div>

	<div class="columns box">
		<div class="column">
			<table class="table is-narrowed">
				<tr>
					<th>OBSERVATIONS</th>
					<th>RECOMMENDED CORRECTIVE ACTIONS</th>
					<th>action</th>
				</tr>
				<tr>
					<td>
						<div class="field">
						  <div class="control">
								<input class="input" type="text" v-model="form.otherObservationsViolation">
						  </div>
						</div>
					</td>
					<td>
						<div class="field">
						  <div class="control">
								<input class="input" type="text" v-model="form.otherObservationsCorrectiveAction">
						  </div>
						</div>
					</td>
					<td>
					  <p class="buttons">
						  <a class="button is-success"  @click="addItem('otherObservations')">
						    <span class="icon is-small">
						      <i class="fa fa-plus"></i>
						    </span>
						  </a>
						  <!-- <a class="button is-warning" @click="cancel('otherObservations')">
						    <span class="icon is-small">
						      <i class="fa fa-times"></i>
						    </span>
						  </a> -->
					  </p>
					</td>
				</tr>
				<tr v-for="item,key in other">
					<td>{{item.v}}</td>
					<td>{{item.r}}</td>
					<td>
						<p class="buttons">
						  <!-- <a class="button is-warning" @click="editItem('otherObservations',item, key)">
						    <span class="icon is-small">
						      <i class="fa fa-edit"></i>
						    </span>
						  </a> -->
						  <a class="button is-danger" @click="removeItem('otherObservations', item, key)">
						    <span class="icon is-small">
						      <i class="fa fa-times"></i>
						    </span>
						  </a>
						</p>
					</td>
				</tr>
			</table>
		</div>
	</div>
<br>
	<div class="columns box">
		<div class="column">
			<div class="field">
			  <label class="label">Comments:</label>
			  <div class="control">
					<textarea class="textarea" v-model="form.comments"></textarea>
			  </div>
			</div>
		</div>
	</div>
  <br>

	<div class="columns box">
		<div class="column">
			<table class="table">
				<tr>
					<td colspan="6">
					  <label class="label">Inspection team:</label>
					<td>
				</tr>
				<tr>
					<td>Name</td>
					<td>
						<div class="field">
						  <div class="control">
								<input class="input" type="text" v-model="form.inspectionMember1Name">
						  </div>
						</div>
					</td>
					<td>Designation</td>
					<td>
						<div class="field">
						  <div class="control">
								<input class="input" type="text" v-model="form.inspectionMember1Designation">
						  </div>
						</div>
					</td>
					<td>Date</td>
					<td>
						<div class="field">
						  <div class="control">
								<input class="input" type="text" v-model="form.inspectionMember1Date">
						  </div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Name</td>
					<td>
						<div class="field">
						  <div class="control">
								<input class="input" type="text" v-model="form.inspectionMember2Name">
						  </div>
						</div>
					</td>
					<td>Designation</td>
					<td>
						<div class="field">
						  <div class="control">
								<input class="input" type="text" v-model="form.inspectionMember2Designation">
						  </div>
						</div>
					</td>
					<td>Date</td>
					<td>
						<div class="field">
						  <div class="control">
								<input class="input" type="text" v-model="form.inspectionMember2Date">
						  </div>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
  <br>

	<div class="columns box">
		<div class="column">
			<table class="table">
				<tr>
					<td colspan="6">
					  <label class="label">Report verified by:</label>
					<td>
				</tr>
				<tr>
					<td>Name</td>
					<td>
						<div class="field">
						  <div class="control">
								<input class="input" type="text" v-model="form.verifiedByName">
						  </div>
						</div>
					</td>
					<td>Designation</td>
					<td>
						<div class="field">
						  <div class="control">
								<input class="input" type="text" v-model="form.verifiedByDesignation">
						  </div>
						</div>
					</td>
					<td>Date</td>
					<td>
						<div class="field">
						  <div class="control">
								<input class="input" type="text" v-model="form.verifiedByDate">
						  </div>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>

<br>
<div class="columns" v-if="statusChangeStatus">
	<div class="column">
		<div class="notification" :class="statusChangeColor">{{statusChangeStatus}}</div>
	</div>
</div>


	<div class="columns">
		<div class="column"></div>
		<div class="column center">
		<button class="button is-success is-large" @click=sendForProcessing>
		    <span>ޕްރޮސެސިން އަށް ފޮނުވާ</span>
		</button>
			<button class="button is-warning is-large" @click=onSubmit>
		    <span>ރައްކާކުރޭ</span>
		  </button>
			<a :href="'/english/reports/' + reportId" class="button is-info is-large">
	    	<span>ޕްރިންޓް</span>
	  	</a :href="'/english/reports/' + reportId">
		</div>
		<div class="column"></div>
	</div>
</div>
@endverbatim
@endsection

@section('page-last-scripts')
<script type="text/javascript" src="{{mix('/js/english-reports-edit.js')}}"></script>
@endsection