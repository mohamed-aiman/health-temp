const app = new Vue({
    el: "#app",
    data: {
        normalFormId: document.getElementById('form_id').value,
        normalForm: {},
        categorizedFormPoints: []
    },
    mounted() {
        this.getNormalForm();
        this.getNormalFormPoints();
    },
    methods: {
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
        getNormalForm() {
            axios
              .get('/api/normalforms/' + this.normalFormId)
                .then(response => {
                    this.normalForm = response.data;
                })
                .catch(errors => console.log(errors));
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
        }
    }
});