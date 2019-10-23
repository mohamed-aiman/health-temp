const app = new Vue({
    el: "#app",
    data: {
        normalFormId: document.getElementById('form_id').value,
        normalForm: {},
        categorizedFormPoints: [],
        statusChangeStatus: null,
        statusChangeColor: 'is-success',
    },
    mounted() {
        this.getNormalForm();
        this.getNormalFormPoints();
    },
    methods: {
        getNormalForm() {
            axios
              .get('/api/normalforms/' + this.normalFormId)
                .then(response => {
                    this.normalForm = response.data;
                })
                .catch(errors => console.log(errors));
        },
        rowColor(point) {
            switch(point.code) {
              case 'CR':
                    return '#f29696';
                break;
              case 'MJ':
                    return '#f2c196';
                break;
              case 'MN':
                    return '#95f1ca';
                break;
              default:
                    return '#95d0f0';
            }
        },
        getNormalFormPoints() {
            axios
              .get('/api/normalforms/' + this.normalFormId + '/points')
                .then(response => {
                    this.categorizedFormPoints = response.data;
                })
                .catch(errors => console.log(errors));
        },
        isReason(reason) {
            return (this.normalForm.reason == reason) ? true : false;
        },
        isAppliedFor(appliedFor) {
            return (this.normalForm.applied_for == appliedFor) ? true : false;
        },
        launchPrint() {
            window.print();
        },
        sendForEditing() {
            axios
            .patch("/api/normalforms/" + this.normalFormId  + "/status/draft")
            .then(response => {
                this.statusChangeColor = 'is-success';
                this.statusChangeStatus = 'status changed successfully.'
                this.goToForm();
            })
            .catch(error => {
                this.statusChangeStatus = 'error changing status: ' + error.response.data.message;
                this.statusChangeColor = 'is-danger';
            });
        },
        processed() {
            axios
            .patch("/api/normalforms/" + this.normalFormId  + "/status/processed")
            .then(response => {
                this.statusChangeColor = 'is-success';
                this.statusChangeStatus = 'status changed successfully.'
                this.goToForm();
            })
            .catch(error => {
                this.statusChangeStatus = 'error changing status: ' + error.response.data.message;
                this.statusChangeColor = 'is-danger';
            });
        },
        goToForm() {
            window.location.href = '/normalforms/' +  this.normalFormId;
        }
    }
});