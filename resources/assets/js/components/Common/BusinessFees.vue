	<template>
		<div id="fees" v-if="fees.length>0 && can('fees.slip.show')">
			<div class="columns">
				<div class="column">
					<table class="table is-bordered is-fullwidth is-narrow is-striped">
						<thead>
							<tr>
								<th colspan="7">Fees</th>
							</tr>
							<tr>
								<th class="is-info">Id</th>
								<th class="is-info">Fee Type</th>
								<th class="is-info">Fee Slip</th>
								<th class="is-info">Applied On</th>
								<th class="is-info">Payment</th>
							</tr>
						</thead>
						<tbody v-if="fees">
							<tr v-for="item, index in fees">
								<td>{{item.id}}</td>
								<td class="dhivehi">
		                        	<span class="pull-right is-fullwidth is-small">{{item.fee_type.description}} {{(item.remarks != null) ? '('+item.remarks+')' : null}}</span>
		                      	</td>
		                      	<td>
									<a v-can="'fees.receipt.show'" target="_blank" :href="'/fees/'+item.id +'/slip'">
			                          {{item.fee_slip_no}}
			                        </a>
			                        <span v-cannot="'fees.receipt.show'">
			                          {{item.fee_slip_no}}
			                        </span>
			                    </td>
								<td>{{dateOnly(item.applied_on)}}</td>
								<td>
									<div class="is-pulled-right">
										<pay-fee-modal v-if="!item.is_paid" :fee="item" @refresh="refreshPage"></pay-fee-modal>
										<span v-if="item.receipt_path != null && can('fees.receipt.show')">
											<div class="tags">
											  <a class="tag" target="_blank" :href="'/fees/'+item.id +'/receipt'">{{item.receipt_no}} on {{item.paid_on}}</a>
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
	import PayFeeModal from './PayFeeModal';
    export default {
		  props: ['fees'],
		    components: {
			    'pay-fee-modal': PayFeeModal
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