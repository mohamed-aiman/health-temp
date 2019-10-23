const app = new Vue({
    el: "#app",
    data: {
        gradingFormId: document.getElementById('form_id').value,
        gradingForm: {},
        categorizedFormPoints: []
    },
    mounted() {
        this.getGradingForm();
        this.getGradingFormPoints();
    },
    methods: {
        getGradingForm() {
            axios
              .get('/api/gradingforms/' + this.gradingFormId)
                .then(response => {
                    this.gradingForm = response.data;
                })
                .catch(errors => console.log(errors));
        },
        getGradingFormPoints() {
            axios
              .get('/api/gradingforms/' + this.gradingFormId + '/points')
                .then(response => {
                    this.categorizedFormPoints = response.data;
                })
                .catch(errors => console.log(errors));
        },
        changedValue(point) {
            axios
              .patch('/api/gradingforms/' + this.gradingFormId + '/formpoints/' + point.id + '/value/changed', {
                  value: point.value
              })
                .then(response => {
                    point = response.data;
                })
                .catch(errors => alert('unable to mark or unmark(value)!'));
        },
        changedNotApplicable(point) {
            axios
              .patch('/api/gradingforms/' + this.gradingFormId + '/formpoints/' + point.id + '/notapplicable/changed', {
                  not_applicable: point.not_applicable
              })
                .then(response => {
                    point = response.data;
                })
                .catch(errors => alert('unable to mark or unmark(not_applicable)!'));
        },
        savePlaceInfoReason() {
            axios
              .patch('/api/gradingforms/' + this.gradingFormId, this.gradingForm)
                .then(response => {
                    this.gradingForm = response.data;
                })
                .catch(errors => alert('unable to update the grading form!'));
        },
        goToShow() {
            if (this.gradingForm.grading_inspection_id != null) {
                window.location.href = '/gradinginspections/' + this.gradingForm.grading_inspection_id + '/gradingforms'
            }
        }
    }
});