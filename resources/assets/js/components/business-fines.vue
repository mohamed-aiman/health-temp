	<template>
		<div id="fines" v-if="fines.length>0 && can('api.fines.index')">
			<div class="columns">
				<div class="column">
					<table class="table is-bordered is-fullwidth is-narrow is-striped">
						<thead>
							<tr>
								<th colspan="7">Fines</th>
							</tr>
							<tr>
								<th class="is-info">Id</th>
								<th class="is-info">Fine Type</th>
								<th class="is-info">Inspection Id</th>
								<th class="is-info">Fine Slip</th>
								<th class="is-info">Fined On</th>
								<th class="is-info">Receipt</th>
							</tr>
						</thead>
						<tbody v-if="fines">
							<tr v-for="item, index in fines">
								<td>{{item.id}}</td>
								<td class="dhivehi">
		                        	<span class="pull-right is-fullwidth is-small">{{item.fine_type.description}} {{(item.remarks) ? '('+item.remarks+')' : null}}</span>
		                      	</td>
								<td><router-link v-can="'api.inspections.show'" :to="{ name: 'inspections.show', params: { inspectionId: item.inspection_id }}">{{item.inspection_id}}</router-link></td>
								<td>
									<a v-can="'fines.receipt.show'" target="_blank" :href="'/fines/'+item.id +'/slip'">
			                          {{item.fine_slip_no}}
			                        </a>
			                        <span v-cannot="'fines.receipt.show'">
			                          {{item.fine_slip_no}}
			                        </span>
			                    </td>
								<td>{{item.fined_on}}</td>
								<td>
									<div class="is-pulled-right">
										<pay-fine-modal v-if="!item.is_paid" :fine="item" @refresh="refreshPage"></pay-fine-modal>
										<span v-if="item.receipt_path != null && can('fines.receipt.show')">
											<div class="tags">
												<a class="tag" target="_blank" :href="'/fines/'+item.id +'/receipt'">{{item.receipt_no}} on {{item.paid_on}}
												</a>
											</div>
										</span>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</template>

<script>
	import PayFineModal from './Common/PayFineModal';
    export default {
		  props: ['fines'],
		    components: {
			    'pay-fine-modal': PayFineModal
			},
		  data() {
		  	return {
		  		file: []
		  	}
		  },
		  methods: {
		  	refreshPage() {
		  		this.$emit('refresh');
		  	}
		  }
    }
</script>