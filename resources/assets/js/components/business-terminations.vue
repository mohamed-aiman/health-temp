<template>
	<!-- <div class="columns" v-if="terminations.length>0 && can('api.terminations.index')"> -->
	<div class="columns" v-if="terminations.length>0">
		<div class="column">
			<table class="table is-bordered is-fullwidth is-narrow is-striped">
				<tr>
					<th colspan="4">Terminations</th>
				</tr>
				<tr>
					<th class="is-info">Id</th>
					<th class="is-info">Terminated On</th>
					<th class="is-info">Reason</th>
					<th class="is-info">Active</th>
				</tr>
				<tr v-for="item in terminations">
					<td>{{item.id}}</td>
					<td>{{item.terminated_on}}</td>
					<td>{{item.reason}} {{item.remarks ? ' (' + item.remarks + ')' : null}}</td>
					<td class="fit">
						<span class="icon is-small" v-if="item.id == active">
					      <i class="fa fa-check"></i>
					    </span>
					    <span class="icon is-small" v-if="item.id != active">
					      <i class="fa fa-close"></i>
					    </span>

					</td>
				</tr>
			</table>
		</div>
	</div>
</template>

<script>
    export default {
		  props: ['terminations', 'active'],
    }
</script>
