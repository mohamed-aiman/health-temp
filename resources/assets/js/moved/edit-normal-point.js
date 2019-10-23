const app = new Vue({
    el: "#app",
    data: {
        isActive: false,
        normalPointId: document.getElementById('normal_point_id').value,
        normalPoint: {},
        normalCategories: {},
        form: new Form({})
    },
    mounted() {
        this.getNormalPoint();
        this.getNormalCategories();
    },
    methods: {
        getNormalPoint() {
            axios
              .get('/api/normalpoints/' + this.normalPointId)
                .then(response => {
                    this.normalPoint = response.data;
                })
                .catch(errors => console.log(errors));
        },
        getNormalCategories() {
            axios
              .get('/api/normalcategories/forselect')
                .then(response => {
                    // console.log(response.data);
                    this.normalCategories = response.data;
                })
                .catch(errors => console.log(errors));
        },
        updateNormalPoint() {
            axios
              .patch('/api/normalpoints/' + this.normalPointId, this.normalPoint)
                .then(response => {
                    this.normalPoint = response.data;
                })
                .catch(errors => console.log(errors));
        },
        deleteNormalPoint() {
          if(!confirm("Are you sure you want to delete this?")) { return;}
            axios
              .delete('/api/normalpoints/' + this.normalPointId)
                .then(response => {
                    alert('deleted successfully');
                    this.normalPoint = {};
                })
                .catch(errors => {
                    alert('unable to delete');
                    this.getNormalPoint();
                });
        }
    }
});