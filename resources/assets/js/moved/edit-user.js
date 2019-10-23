const app = new Vue({
    el: "#app",
    data: {
        editingId: document.getElementById('editingId').value,
          user: {},
          roleQuery: null,
          selectedUserRoles:[],
          editForm: {
              name: ''
          },
          editResponse: {},
          attachDetachResponse: {}
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
              axios.get('/users/' + this.editingId)
              .then(success => {
                  this.user = success.data;
                  this.editForm.name = this.user.name;
              }).catch(error => {
              });
        },
          updateUser() {
              axios.patch('/users/'+this.editingId, this.editForm).
              then(success => {
                  this.editResponse = success;
                  this.user = success.data;
              }).
              catch(error => {
                  this.editResponse = error.response;
              });
          },
          getUserRoles() {
              if (this.roleQuery) {
                  url = '/users/' + this.editingId + '/roles/forcheckbox?role_query=' + this.roleQuery;
              } else {
                  url = '/users/' + this.editingId + '/roles/forcheckbox';
              }
              axios.get(url)
              .then(success => {
                  this.selectedUserRoles = success.data;
              }).catch(error => {
              });
          },
          detachRole(role) {
            axios.patch('/users/'+this.editingId + '/roles/detach', {
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
            axios.patch('/users/'+this.editingId + '/roles/attach', {
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
});