<template>
	<div class="columns no-print">
		<div class="column">
			<table class="table is-bordered is-narrow">
				<tr>
					<td>Handover Staff</td>
					<td>Handover At</td>
					<td>Received By</td>
					<td>Hardcopy</td>
					<td v-if="form.status != 'issued'" class="fit" v-can="'api.english-reports.issueReport'" rowspan="2" style="vertical-align:middle;"><button class="button is-success" @click="saveForm()">Submit Handover</button></td>
				</tr>
				<tr>
					<td>{{form.issued_by_name}}</td>
					<td>{{form.issued_on}}</td>
					<td><input type="text" class="input" v-model="form.received_by"/></td>
					<td>
						<template v-if="form.hard_copy_path == null">
						    <b-field class="file" v-can="'uploads.english-reports.hardcopy'">
						        <b-upload 
						        v-model="file[0]"
						        @input="uploadHardCopy(file[0])"
						        >
						            <a class="button is-primary is-small">
						                <b-icon icon="upload"></b-icon>
						            </a>
						        </b-upload>
						        <span class="file-name" v-if="file[0]">
						            {{ file[0].name }}
						        </span>
						    </b-field>    
						</template>
						<template v-if="form.hard_copy_path != null" v-can="'english-reports.hardcopy.show'">
							<a class="button is-success is-small" target="_blank" :href="'/english/reports/'+id +'/hardcopy'"><b-icon icon="eye"></b-icon></a>
						</template>
					</td>
				</tr>
			</table>
		</div>
	</div>
</template>

<script>
    export default {
		  props: ['form', 'id'],
		  data() {
		  	return {
		  		file: []
		  	}
		  },
		  methods: {
		  		saveForm() {
		  			axios
					.patch('/api/english/reports/'+this.id+'/issuereport', this.form)
					.then(response => {
						this.$emit('update',response.data);
					}, error => {
						alert('Error uploading file: ' + error.respose.data.message);
					});
		  		},
				uploadHardCopy(file) {
					const fd = new FormData();
					fd.append('image', file, file.name);

					axios
					.post('/uploads/english/reports/'+this.id+'/hardcopy', fd)
					.then(response => {
						this.form.hard_copy_path = response.data.hard_copy_path;
					}, error => {
						alert('Error uploading file: ' + error.respose.data.message);
					});
				}
		  }
    }
</script>