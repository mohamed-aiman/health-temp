@extends('layouts.app')

@section('content')
@verbatim
<div v-can="'english-reports.show'">
@endverbatim
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
							{{form.establishmentName}}
					  </div>
					</div>
				</td>
			</tr>
			<tr>
				<td>Date of Inspection</td>
				<td>
					<div class="field">
					  <div class="control">
							{{form.dateOfInspection}}
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
					{{form.scopeOfInspection}}
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
					{{form.areasInspected}}
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
			<table class="table is-narrowed is-bordered">
				<tr>
					<th>VIOLATIONS</th>
					<th>CORRECTIVE ACTION</th>
				</tr>
				<tr v-for="item,key in critical">
					<td style="width: 50%;">{{item.v}}</td>
					<td style="width: 50%;">{{item.r}}</td>
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
			<table class="table is-narrowed is-bordered">
				<tr>
					<th>VIOLATIONS</th>
					<th>CORRECTIVE ACTIONS</th>
				</tr>
				<tr v-for="item,key in major">
					<td style="width: 50%;">{{item.v}}</td>
					<td style="width: 50%;">{{item.r}}</td>
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
			<table class="table is-narrowed is-bordered">
				<tr>
					<th>OBSERVATIONS</th>
					<th>RECOMMENDED CORRECTIVE ACTIONS</th>
				</tr>
				<tr v-for="item,key in other">
					<td style="width: 50%;">{{item.v}}</td>
					<td style="width: 50%;">{{item.r}}</td>
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
					{{form.comments}}
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
								{{form.inspectionMember1Name}}
						  </div>
						</div>
					</td>
					<td>Designation</td>
					<td>
						<div class="field">
						  <div class="control">
								{{form.inspectionMember1Designation}}
						  </div>
						</div>
					</td>
					<td>Date</td>
					<td>
						<div class="field">
						  <div class="control">
								{{form.inspectionMember1Date}}
						  </div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Name</td>
					<td>
						<div class="field">
						  <div class="control">
								{{form.inspectionMember2Name}}
						  </div>
						</div>
					</td>
					<td>Designation</td>
					<td>
						<div class="field">
						  <div class="control">
								{{form.inspectionMember2Designation}}
						  </div>
						</div>
					</td>
					<td>Date</td>
					<td>
						<div class="field">
						  <div class="control">
								{{form.inspectionMember2Date}}
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
								{{form.verifiedByName}}
						  </div>
						</div>
					</td>
					<td>Designation</td>
					<td>
						<div class="field">
						  <div class="control">
								{{form.verifiedByDesignation}}
						  </div>
						</div>
					</td>
					<td>Date</td>
					<td>
						<div class="field">
						  <div class="control">
								{{form.verifiedByDate}}
						  </div>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<br>
<div class="columns no-print">
	<div class="column" style="text-align: center;"><button class="is-info button is-large" @click="launchPrint()">Print</button></div>
</div>
</div>
@endverbatim
@endsection

@section('page-last-scripts')
<script type="text/javascript" src="{{mix('/js/english-reports-show.js')}}"></script>
@endsection