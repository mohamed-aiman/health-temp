const app = new Vue({
    el: "#app",
    data: {
        isActive: false,
        gradingPointId: document.getElementById('grading_point_id').value,
        gradingPoint: {},
        gradingCategories: {},
        form: new Form({})
    },
    mounted() {
        this.getGradingPoint();
        this.getGradingCategories();
    },
    methods: {
        getGradingPoint() {
            axios
              .get('/api/gradingpoints/' + this.gradingPointId)
                .then(response => {
                    this.gradingPoint = response.data;
                })
                .catch(errors => console.log(errors));
        },
        getGradingCategories() {
            axios
              .get('/api/gradingcategories/forselect')
                .then(response => {
                    // console.log(response.data);
                    this.gradingCategories = response.data;
                })
                .catch(errors => console.log(errors));
        },
        updateGradingPoint() {
            axios
              .patch('/api/gradingpoints/' + this.gradingPointId, this.gradingPoint)
                .then(response => {
                    this.gradingPoint = response.data;
                })
                .catch(errors => console.log(errors));
        },
        deleteGradingPoint() {
          if(!confirm("Are you sure you want to delete this?")) { return;}
            axios
              .delete('/api/gradingpoints/' + this.gradingPointId)
                .then(response => {
                    alert('deleted successfully');
                    this.gradingPoint = {};
                })
                .catch(errors => {
                    alert('unable to delete');
                    this.getGradingPoint();
                });
        }
    }
});