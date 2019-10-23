<template>
	<div id="users" v-can="'api.users.index'" v-if="users.length>0">
		<div class="columns">
			<div class="column">
				<table class="table is-bordered is-fullwidth is-narrow is-striped">
					<thead>
						<tr>
							<th colspan="7">Users</th>
						</tr>
						<tr>
							<th class="is-info">Id</th>
							<th class="is-info">Name</th>
							<th class="is-info">Email</th>
							<th class="is-info">Options</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="item,key in users">
							<td>{{item.id}}</td>
							<td>{{item.name}}</td>
							<td>{{item.email}}</td>
							<td >
					          <p class="buttons">
								  <router-link v-can="'api.users.update'"   class="button is-warning"    :to="{ name: 'users.edit', params: { userId: item.id }}">
								    <span class="icon is-small">
								      <i class="fa fa-edit"></i>
								    </span>
								  </router-link>
								  <a v-can="'api.users.destroy'" class="button is-warning"  target='_blank' @click="deleteItem(item.id)">
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
		  props: ['users'],
		  methods: {
		  	deleteItem(id) {
		  		axios.delete('/api/users/'+id).
		  		then(success => {
		  			this.$emit('update:users', this.users.filter(user => {return user.id != id}))
		  		}).
		  		catch(error => console.log(error));  		
		  	}
		  }
    }
</script>
