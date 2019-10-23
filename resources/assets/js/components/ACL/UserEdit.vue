<template>
<div v-can="'api.users.update'">
	<div class="columns">
		<div class="column is-fullwidth">
	      <h1 class="title">
	        Edit User
	      </h1>
		</div>
	</div>
	<div class="container">
		<div class="columns">
			<div class="column">
				<response-messages :response="editResponse"></response-messages>
			</div>
		</div>
		<div class="columns box">
			<div class="column">
				<div class="columns">
					<div class="column">
					  <div class="label is-normal">
					    <label class="label">Editing User: {{user.name}}</label>
					  </div>
					</div>
				</div>
				<div class="columns">
					<div class="column">
						<div class="field has-addons">
						  <div class="control is-expanded">
						    <input type="text" placeholder="name" class="input" v-model="editForm.name">
						  </div>
						  <div class="control">
						    <a class="button is-warning"  @click="updateUser">
						      Update
						    </a>
						  </div>
						</div>
					</div>
				</div>
			</div>

		</div>
		<br>
		<div class="columns">
			<div class="column">
				<response-messages :response="attachDetachResponse"></response-messages>
			</div>
		</div>
		<div class="columns box">
			<div class="column">
				<div class="columns">
					<div class="column">
					  <div class="label is-normal">
					    <label class="label">Add or remove user's roles</label>
					  </div>
					</div>
				</div>
				<div class="columns">
					<div class="column">
						<div class="field has-addons">
						  <div class="control is-expanded">
						    <input class="input" type="text" placeholder="Find a role" v-model="roleQuery">
						  </div>
						</div>
					</div>
				</div>
				<table class="table is-narrow">
					<tr>
						<th>Slug</th>
						<th>Name</th>
						<th>Add(+)/Remove(-)</th>
					</tr>
					<tr v-for="role in selectedUserRoles">
						<td>{{role.slug}}</td>
						<td>{{role.name}}</td>
						<td v-if="role.has_role == 1">
							<button class="button is-danger" @click="detachRole(role)">
					            <b-icon icon="minus"></b-icon>
					        </button>
					    </td>
						<td v-if="role.has_role == 0">
							<button class="button is-success" @click="attachRole(role)">
					            <b-icon icon="plus"></b-icon>
					        </button>
					    </td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
</template>

<script>
export default {
	props: ['userId'],
    data() {
          return {
          	user: {},
			roleQuery: null,
			selectedUserRoles:[],
			editForm: {
				name: ''
			},
			editResponse: {},
			attachDetachResponse: {}
		}
    },
    watch: {
        roleQuery: _.debounce(function (e) {
          this.getUserRoles();
        }, 500)
    },
    mounted() {
          this.getUser();
        this.getUserRoles();
    },
    methods: {
        getUser() {
              axios.get('/api/users/' + this.userId)
              .then(success => {
                  this.user = success.data;
                  this.editForm.name = this.user.name;
              }).catch(error => {
              });
        },
          updateUser() {
              axios.patch('/api/users/'+this.userId, this.editForm).
              then(success => {
                  this.editResponse = success;
                  this.user = success.data;
              }).
              catch(error => {
                  this.editResponse = error.response;
              });
          },
          getUserRoles() {
	          	let url;
              if (this.roleQuery) {
                  url = '/api/users/' + this.userId + '/roles/forcheckbox?role_query=' + this.roleQuery;
              } else {
                  url = '/api/users/' + this.userId + '/roles/forcheckbox';
              }
              axios.get(url)
              .then(success => {
                  this.selectedUserRoles = success.data;
              }).catch(error => {
              });
          },
          detachRole(role) {
            axios.patch('/api/users/'+this.userId + '/roles/detach', {
                role_id: role.role_id
            }).
              then(success => {
                  // this.editResponse = success;
                  this.attachDetachResponse = success;
                  this.getUserRoles();
              }).
              catch(error => {
                  this.editResponse = error.response;
              });
          },
          attachRole(role) {
            axios.patch('/api/users/'+this.userId + '/roles/attach', {
                role_id: role.role_id
            }).
              then(success => {
                  // this.editResponse = success;
                  this.attachDetachResponse = success;
                  this.getUserRoles();
              }).
              catch(error => {
                  this.editResponse = error.response;
              });
          },
    }
}
</script>