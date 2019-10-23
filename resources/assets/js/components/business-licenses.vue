<template>
	<div id="licenses" v-if="licenses.length>0 && can('api.licenses.index')">
		<div class="columns">
			<div class="column">
				<table class="table is-bordered is-fullwidth is-narrow is-striped">
					<thead>
						<tr>
							<th colspan="7">Licenses</th>
						</tr>
						<tr>
							<th class="is-info" v-can="'api.applications.show'">Application</th>
							<th class="is-info">Type</th>
							<th class="is-info">License No.</th>
							<th class="is-info">Issued</th>
							<th class="is-info">Expiry</th>
							<th class="is-info">Hardcopy</th>
							<th class="is-info">Receipt</th>
						</tr>
					</thead>
					<tbody v-if="licenses">
						<tr v-for="item, index in licenses">
							<td><router-link v-can="'api.applications.show'" :to="{ name: 'applications.show', params: { applicationId: item.application_id }}">{{item.application_id}}</router-link></td>
							<td>{{item.tobacco_or_food}} ({{item.register_or_renew}})</td>
							<td>{{item.license_no}}</td>
							<td>{{item.issued_at}}</td>
							<td>{{item.expire_at}}</td>
							<td>
                  <a v-if="item.hard_copy_path && can('licenses.hardcopy.show')" class="button is-success is-small" target="_blank" 
                    :href="'/licenses/' + item.id + '/hardcopy'">
                    <b-icon pack="fas" icon="eye"></b-icon>
                  </a>
                  <upload-file-modal 
                    :title="'Upload License Hardcopy'"
                    :is_type_required="false"
                    :permission="'uploads.licenses.hardcopy'"
                    :uri="'/uploads/licenses/' + item.id + '/hardcopy'"
                    @refresh="refreshPage"></upload-file-modal>
							</td>
							<td>
                  <pay-license-modal :license="item" v-if="!item.is_paid" @refresh="refreshPage"></pay-license-modal>
	                <a v-if="item.receipt_path != null && can('licenses.receipt.show')" class="button is-success is-small"
	                	target="_blank" :href="'/licenses/'+item.id +'/receipt'">
											<b-icon pack="fas" icon="eye"></b-icon>
									</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</template>

<script>
import PayLicenseModal from './Common/PayLicenseModal';
import UploadFileModal from './Common/UploadFileModal';

export default {
  props: ['licenses'],
	components: {
		'pay-license-modal': PayLicenseModal,
		'upload-file-modal': UploadFileModal
	},
  methods: {
		refreshPage() {
			this.$emit('refresh');
		}
  }
}
</script>