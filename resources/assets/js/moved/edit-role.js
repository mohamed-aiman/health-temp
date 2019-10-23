const app = new Vue({
    el: "#app",
    data: {
        editingId: document.getElementById('editingId').value,
          role: {},
          permissionQuery: null,
          selectedRolePermissions:[],
          editForm: {
              name: ''
          },
          editResponse: {},
          attachDetachResponse: {}
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
              axios.get('/roles/' + this.editingId)
              .then(success => {
                  this.role = success.data;
                  this.editForm.name = this.role.name;
              }).catch(error => {
              });
        },
          updateRole() {
              axios.patch('/roles/'+this.editingId, this.editForm).
              then(success => {
                  this.editResponse = success;
                  this.role = success.data;
              }).
              catch(error => {
                  this.editResponse = error.response;
              });
          },
          getRolePermissions() {
              if (this.permissionQuery) {
                  url = '/roles/' + this.editingId + '/permissions/forcheckbox?permission_query=' + this.permissionQuery;
              } else {
                  url = '/roles/' + this.editingId + '/permissions/forcheckbox';
              }
              axios.get(url)
              .then(success => {
                  this.selectedRolePermissions = success.data;
              }).catch(error => {
              });
          },
          detachPermission(permission) {
            axios.patch('/roles/'+this.editingId + '/permissions/detach', {
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
            axios.patch('/roles/'+this.editingId + '/permissions/attach', {
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
});