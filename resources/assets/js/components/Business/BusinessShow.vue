<template>
<div v-can="'api.businesses.show'">
	<div class="columns">
      <div class="column is-fullwidth">
          <h1 class="title">
           Business Profile View
          </h1>
      </div>
    </div>
	<template v-if="business">
		<template id="options">
			<div class="columns" v-can="'api.businesses.show'">
				<div class="column">
					<table class="table">
						<tr>
							<td>
								<router-link 
									v-can="'api.businesses.update'" 
									class="button is-primary is-small" 
									:to="{ name: 'businesses.edit', params: { businessId: businessId }}"
									>
								Edit Business
								</router-link>
							</td>
							<td>
								<router-link 
									v-can="'api.applications.store'" 
									class="button is-primary is-small" 
									:to="{ name: 'businesses.applications.create', params: { businessId: businessId }}"
									>
								New Application
							</router-link>
							</td>
							<td>
								<new-manual-inspection-modal :businessId="businessId" :complaints="business.complaints" @refresh="getBusiness()"></new-manual-inspection-modal>
							</td>
							<td>
								<new-complaint-modal :businessId="businessId" @refresh="getBusiness()"></new-complaint-modal>
							</td>
							<td>
								<new-fee-modal :business="business" @refresh="getBusiness"></new-fee-modal>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</template>
		<business-details :business="business"  @refresh="getBusiness"></business-details>
		<business-fees :fees="business.fees"></business-fees>
		<business-applications :applications="business.applications"></business-applications>
		<business-inspections :inspections="business.inspections" @refresh="getBusiness"></business-inspections>
		<business-complaints :complaints="business.complaints" @refresh="getBusiness" @scheduleAnInspection="openScheduleComplaintInspection"></business-complaints>
		<business-grading-inspections v-if="business.grading_inspections && business.grading_inspections.length>0" :grading_inspections="business.grading_inspections"></business-grading-inspections>
		<business-fines :fines="business.fines"></business-fines>
		<business-licenses :licenses="business.licenses" @refresh="getBusiness"></business-licenses>
		<business-terminations :terminations="business.terminations" :active="business.termination_id"></business-terminations>
	</template>
</div>
</template>

<script>

import NewManualInspectionModal from '../Common/NewManualInspectionModal';
import NewComplaintModal from '../Common/NewComplaintModal';
import NewFeeModal from '../Common/NewFeeModal';
import BusinessFees from '../Common/BusinessFees';

export default {
	props: ['businessId'],
	components: {
		'new-manual-inspection-modal': NewManualInspectionModal,
		'new-complaint-modal': NewComplaintModal,
		'new-fee-modal': NewFeeModal,
		'business-fees': BusinessFees,
	},
	data() {
		return {
			business: null,
		}
	},
	mounted() {
		this.getBusiness();
	},
	methods: {
		openScheduleComplaintInspection(complaint) {
			this.inspectionForm.complaint_id = complaint.id;
			this.inspectionForm.reason = "Complaint";
			this.isComponentModalActive = true;
		},
		getBusiness() {
			if (this.hasPermission('api.businesses.show')) {
				axios
		  		.get('/api/businesses/' + this.businessId)
				.then(response => {
					this.business = response.data;
				})
				.catch(errors => console.log(errors));
	    }
		}
	}
}

</script>
