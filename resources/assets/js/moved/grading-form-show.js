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
        isReason(reason) {
            return (this.gradingForm.reason == reason) ? true : false;
        },
        launchPrint() {
            window.print();
        }
    }
});