<template>
	<div id="permissions" v-can="'api.permissions.index'" v-if="permissions.length>0">
		<div class="columns">
			<div class="column">
				<table class="table is-bordered is-fullwidth is-narrow is-striped">
					<thead>
						<tr>
							<th colspan="7">permissions</th>
						</tr>
						<tr>
							<th class="is-info">url</th>
							<th class="is-info">Slug</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="item,key in permissions">
							<td>{{item.name}}</td>
							<td>{{item.slug}}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</template>

<script>
    export default {
		  props: ['permissions']
    }
</script>