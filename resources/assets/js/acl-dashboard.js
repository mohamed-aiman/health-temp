Vue.component('acl-users', require('./components/acl-users.vue'));
Vue.component('acl-roles', require('./components/acl-roles.vue'));
Vue.component('acl-permissions', require('./components/acl-permissions.vue'));
Vue.component('error-messages', require('./components/error-messages.vue'));


const app = new Vue({
    el: "#app",
    data: {
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
    },
    mounted() {
        this.getRoles();
        this.getUsers();
        this.getPermissions();
    },
    methods: {
        getUsers() {
            axios.get('/acl/users')
            .then(response => {
                this.users = response.data;
            });
        },
        getRoles() {
            axios.get('/acl/roles')
            .then(response => {
                this.roles = response.data;
            });
        },
        getPermissions() {
            axios.get('/acl/permissions')
            .then(response => {
                this.permissions = response.data;
            });
        },
        openSaveRole() {
            this.isOpenSaveRole = !this.isOpenSaveRole;
        },
        saveRole() {
            this.resetResponse(this.roleCreateResponse);
            axios.post('/acl/roles', this.roleForm)
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
            axios.post('/acl/users', this.userForm)
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
});
