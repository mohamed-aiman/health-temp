<template>
	<div>
		<div class="columns">
			<div class="column is-fullwidth">
		      <h1 class="title">
		        ACL Dashboard
		      </h1>
			</div>
		</div>

		<section>
			<div class="columns">
				<div class="column">
					<div v-can="'api.roles.store'" class="box" v-if="isOpenSaveRole">
						<response-messages :response.sync="roleCreateResponse"></response-messages>
						<div class="heading">New Role</div>
						<div class="field is-grouped">
						  <p class="control is-expanded">
						    <input class="input" type="text" placeholder="Name" v-model="roleForm.name">
						  </p>
						  <p class="control">
						    <a class="button is-info" @click="saveRole">
						      Save
						    </a>
						  </p>
						</div>
					</div>
					<button v-can="'api.roles.store'" class="button is-success" @click="openSaveRole">Add New Role</button>
					<div id="roles" v-can="'api.roles.index'">
						<acl-roles :roles.sync="roles"></acl-roles>
					</div>
					<div id="permissions" v-can="'api.permissions.index'">
						<acl-permissions :permissions="permissions"></acl-permissions>
					</div>
				</div>
				<div id="users" class="column">
					<div v-can="'api.users.store'" class="box" v-if="isOpenSaveUser">
						<response-messages :response.sync="userCreateResponse"></response-messages>
						<div class="heading">New User</div>
						<div class="field is-grouped">
						  <p class="control is-expanded">
						    <input class="input" type="text" placeholder="Name" v-model="userForm.name">
						  </p>
						  <p class="control is-expanded">
						    <input class="input" type="text" placeholder="Email" v-model="userForm.email">
						  </p>
						  <p class="control">
						    <a class="button is-info" @click="saveUser">
						      Save
						    </a>
						  </p>
						</div>
					</div>
					<button v-can="'api.users.store'" class="button is-success" @click="openSaveUser">Add New User</button>
					<div id="users" v-can="'api.users.index'">
						<acl-users :users.sync="users"></acl-users>
					</div>
				</div>
			</div>
		</section>
	</div>
</template>

<script>
// Vue.component('acl-users', require('./components/acl-users.vue'));
// Vue.component('acl-roles', require('./components/acl-roles.vue'));
// Vue.component('acl-permissions', require('./components/acl-permissions.vue'));
// Vue.component('error-messages', require('./components/error-messages.vue'));

import AclUsers from '../acl-users.vue';
import AclRoles from '../acl-roles.vue';
import AclPermissions from '../acl-permissions.vue';

export default {
	components: {
		'acl-users': AclUsers,
		'acl-roles': AclRoles,
		'acl-permissions': AclPermissions
	},
    data() {
        return {
        	users: [],
	        roles: [],
	        permissions: [],
	        isOpenSaveRole: false,
	        isOpenSaveUser: false,
	        roleCreateResponse: {},
	        userCreateResponse: {},
	        roleForm: {
	            name:''
	        },
	        userForm: {
	            name:'',
	            email:''
	        }
	    }
    },
    mounted() {
        this.getRoles();
        this.getUsers();
        this.getPermissions();
    },
    methods: {
        getUsers() {
        	if (this.hasPermission('api.users.index')) {
	            axios.get('/api/acl/users')
	            .then(response => {
	                this.users = response.data;
	            });
	        }
        },
        getRoles() {
        	if (this.hasPermission('api.roles.index')) {
	            axios.get('/api/acl/roles')
	            .then(response => {
	                this.roles = response.data;
	            });
	        }
        },
        getPermissions() {
        	if (this.hasPermission('api.permissions.index')) {
	            axios.get('/api/acl/permissions')
	            .then(response => {
	                this.permissions = response.data;
	            });
	        }
        },
        openSaveRole() {
            this.isOpenSaveRole = !this.isOpenSaveRole;
        },
        saveRole() {
            this.resetResponse(this.roleCreateResponse);
            axios.post('/api/acl/roles', this.roleForm)
            .then(response => {
                this.roleCreateResponse = response;
                this.getRoles();
                setTimeout(function() {
                    this.resetResponse(this.roleCreateResponse);
                    this.$emit('update:roleCreateResponse', {});
                    this.isOpenSaveRole = false;
                }.bind(this), 1000);
            })
            .catch(error => {
                this.roleCreateResponse = error.response;
            });
        },
        openSaveUser() {
            this.isOpenSaveUser = !this.isOpenSaveUser;
        },
        saveUser() {
            this.resetResponse(this.userCreateResponse);
            axios.post('/api/acl/users', this.userForm)
            .then(response => {
                this.userCreateResponse = response;
                this.getUsers();
                setTimeout(function() {
                    this.isOpenSaveUser = false;
                    this.resetResponse(this.userCreateResponse);
                }.bind(this), 1000);
            })
            .catch(error => {
                this.userCreateResponse = error.response;
            });
        },
        resetResponse(Response) {
            Response = {};
        }
    }
}
</script>