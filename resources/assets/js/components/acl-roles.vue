<template>
	<div id="roles" v-can="'api.roles.index'" v-if="roles.length>0">
		<div class="columns">
			<div class="column">
				<table class="table is-bordered is-fullwidth is-narrow is-striped">
					<thead>
						<tr>
							<th colspan="7">Roles</th>
						</tr>
						<tr>
							<th class="is-info">Id</th>
							<th class="is-info">Name</th>
							<th class="is-info">Slug</th>
							<th class="is-info">Options</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="item,key in roles">
							<td>{{item.id}}</td>
							<td>{{item.name}}</td>
							<td>{{item.slug}}</td>
							<td>
					          <p class="buttons">
								  <a  v-can="'api.roles.update'" class="button is-warning"  target='_blank' @click="goToEditPage(item)">
								    <span class="icon is-small">
								      <i class="fa fa-edit"></i>
								    </span>
								  </a>
								  <a v-can="'api.roles.destroy'" class="button is-warning"  target='_blank' @click="deleteItem(item.id)">
								    <span class="icon is-small">
								      <i class="fa fa-close"></i>
								    </span>
								  </a>
								</p>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</template>

<script>
    export default {
		  props: ['roles'],
		  data() {
		  	return {
		  		editErrorResponse: {},
		  		editResponse: {},
		  	}
		  },
		  methods: {
		  	deleteItem(id) {
		  		axios.delete('/api/roles/'+id).
		  		then(success => {
		  			this.$emit('update:roles', this.roles.filter(role => {return role.id != id}))
		  		}).
		  		catch(error => console.log(error));
		  	},
		  	goToEditPage(item) {
		  		this.$router.push({ name: 'roles.edit', params: { roleId: item.id } })
		  	}
		  }
    }
</script>
