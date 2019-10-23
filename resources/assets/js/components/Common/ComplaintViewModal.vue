<template>
	<!-- <span v-can="'api.businesses.complaints.store'"> -->
	<span >
<!-- 		<button class="button is-primary is-success" @click="isModalActive = true">View Complaint</button> -->
		<a class="button is-small"  @click="isModalActive = true">
			<b-icon type="is-success" size="is-small" pack="fas" icon="eye"></b-icon>
		</a>
		<b-modal :active.sync="isModalActive" has-modal-card trap-focus>
		  <div class="modal-card" style="width: auto">
		      <header class="modal-card-head">
		          <p class="modal-card-title">Complaint</p>
		      </header>
		      <section class="modal-card-body">
		        <b-field label="Time">
			        <p>{{ complaint.complaint_at }}</p>
		         </b-field>

		          <b-field label="Reference">
			        <p>{{ complaint.reference }}</p>
	            </b-field>
		        <b-field class="dhivehi right" label="ޚުލާސާ">
			        <p class="dhivehi">{{ complaint.summary }}</p>
	            </b-field>

		      </section>
		  </div>
    </b-modal>
	</span>
					
</template>

<script>
    export default {
		  props: ['complaint'],
		  data() {
		  	return {
		  		isModalActive: false
		  	}
		  }
    }
</script>