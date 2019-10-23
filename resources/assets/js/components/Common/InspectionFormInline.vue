<template>
	<div class="columns">
		<div class="column">
			<response-messages :response="response"></response-messages>
			<table class="table">
				<tr>
					<td colspan="4">
						<div class="label is-normal">
							<label class="label">{{headingDisplay}}</label>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<label class="label">At:</label>
						<datetime type="datetime" class="input" v-model="form.inspection_at" format="yyyy-MM-dd HH:mm:ss"></datetime>
					</td>
<!-- 					<td>
						<label class="label">Reason:</label>
						<div class="select control">
							<select v-model="form.reason">
								<option value="followup" selected>Followup</option>
								<option value="complaint">Complaint</option>
								<option value="routine">Routine</option>
								<option value="unspecified">Unspecified </option>
							</select>
						</div>
					</td> -->
					<td>
						<label class="label">Remarks:</label>
						<div class="control">
							<input type="text" placeholder="remarks" class="input" v-model="form.remarks">
						</div>
					</td>
					<td rowspan="2">
						<br>
						<div class="control is-pulled-right">
							<button class="button is-link is-vcentered" @click="save()">Save</button>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
</template>

<script>
    import { inlineFormPost } from '../../mixins/inlineFormPost';
	/**
	 * if parentInspectioId is not passed it will be considered as a new inspection else a followup
	 */
	export default {
		props: {
			parentInspectionId: null,
			heading: {
				type: String
			}
		},
        mixins: [inlineFormPost],
		data() {
			return {
				headingDisplay: 'Schedule an inspection',
				form: {
					reason:'Followup',
					remarks: null,
					inspection_at: "",
				},
				response: {}
			}
		},
		mounted() {
			this.setOptions();
		},
		methods: {
			setOptions() {
				if (this.heading) {
					this.headingDisplay = this.heading;
				} else {
					this.headingDisplay = (this.isFollowupInspectionForm()) ? 'Schedule a followup inspection' : this.headingDisplay;
				}
			},
		    inspectionAtDateTimeSelected(formattedInspectionAt) {
		    	this.form.inspection_at = formattedInspectionAt;
		    },
			save() {
				if (this.isFollowupInspectionForm()) {
					this.postForm('/api/inspections/' + this.parentInspectionId + '/followupinspections', {
						reason: this.form.reason,
						remarks: this.form.remarks,
						inspection_at: (this.form.inspection_at) ? moment(this.form.inspection_at).format("Y-MM-DD HH:mm:ss") : "",
					} , 'Error saving new follow up inspection: ')
				} else {
					this.postForm('/api/inspections', {
						reason: this.form.reason,
						remarks: this.form.remarks,
						inspection_at: moment(this.form.inspection_at).format("Y-MM-DD HH:mm:ss"),
					} , 'Error saving new inspection: ')
				}
			},
			isFollowupInspectionForm() {
				return (this.parentInspectionId) ? true : false;
			}
		}
	}
</script>
