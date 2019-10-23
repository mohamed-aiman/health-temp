<template>
	<div v-can="'api.roles.update'">
		<div class="columns">
			<div class="column is-fullwidth">
		      <h1 class="title">
		        Edit Role
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
						    <label class="label">Editing Role: {{role.name}}</label>
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
							    <a class="button is-warning"  @click="updateRole">
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
						    <label class="label">Add or remove role's permissions</label>
						  </div>
						</div>
					</div>
					<div class="columns">
						<div class="column">
							<div class="field has-addons">
							  <div class="control is-expanded">
							    <input class="input" type="text" placeholder="Find a permission" v-model="permissionQuery">
							  </div>
							</div>
						</div>
					</div>
					<table class="table is-narrow">
						<tr>
							<th>Slug</th>
							<th>Url</th>
							<th>Add(+)/Remove(-)</th>
						</tr>
						<tr v-for="permission in selectedRolePermissions">
							<td>{{permission.slug}}</td>
							<td>{{permission.name}}</td>
							<td v-if="permission.has_permission == 1">
								<button class="button is-danger" @click="detachPermission(permission)">
						            <b-icon icon="minus"></b-icon>
						        </button>
						    </td>
							<td v-if="permission.has_permission == 0">
								<button class="button is-success" @click="attachPermission(permission)">
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
	props: ['roleId'],
    data() {
        return {
	          role: {},
	          permissionQuery: null,
	          selectedRolePermissions:[],
	          editForm: {
	              name: ''
	          },
	          editResponse: {},
	          attachDetachResponse: {}
	    }
    },
    watch: {
        permissionQuery: _.debounce(function (e) {
          this.getRolePermissions()
        }, 500)
    },
    mounted() {
        this.getRole();
        this.getRolePermissions();
    },
    methods: {
        getRole() {
              axios.get('/api/roles/' + this.roleId)
              .then(success => {
                  this.role = success.data;
                  this.editForm.name = this.role.name;
              }).catch(error => {
              });
        },
          updateRole() {
              axios.patch('/api/roles/'+this.roleId, this.editForm).
              then(success => {
                  this.editResponse = success;
                  this.role = success.data;
              }).
              catch(error => {
                  this.editResponse = error.response;
              });
          },
          getRolePermissions() {
          	  let url;
              if (this.permissionQuery) {
                  url = '/api/roles/' + this.roleId + '/permissions/forcheckbox?permission_query=' + this.permissionQuery;
              } else {
                  url = '/api/roles/' + this.roleId + '/permissions/forcheckbox';
              }
              axios.get(url)
              .then(success => {
                  this.selectedRolePermissions = success.data;
              }).catch(error => {
              });
          },
          detachPermission(permission) {
            axios.patch('/api/roles/'+this.roleId + '/permissions/detach', {
                slug: permission.slug
            }).
              then(success => {
                  // this.editResponse = success;
                  this.attachDetachResponse = success;
                  this.getRolePermissions();
              }).
              catch(error => {
                  this.editResponse = error.response;
              });
          },
          attachPermission(permission) {
            axios.patch('/api/roles/'+this.roleId + '/permissions/attach', {
                slug: permission.slug
            }).
              then(success => {
                  // this.editResponse = success;
                  this.attachDetachResponse = success;
                  this.getRolePermissions();
              }).
              catch(error => {
                  this.editResponse = error.response;
              });
          },
    }
}
</script>