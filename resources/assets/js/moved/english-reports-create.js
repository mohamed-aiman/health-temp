const app = new Vue({
    el: "#app",
    data: {
        form: new Form({
            establishmentName: "",
            dateOfInspection: "",
            scopeOfInspection: "",
            areasInspected: "",
            criticalViolation: "",
            criticalCorrectiveAction: "",
            majorViolation: "",
            majorCorrectiveAction: "",
            otherObservationsViolation: "",
            otherObservationsCorrectiveAction: "",
            comments: "",
            inspectionMember1Name: "",
            inspectionMember1Designation: "",
            inspectionMember1Date: "",
            inspectionMember2Name: "",
            inspectionMember2Designation: "",
            inspectionMember2Date: "",
            verifiedByName: "",
            verifiedByDesignation: "",
            verifiedByDate: ""
        })
    },
  watch: {
    },
    mounted() {
    },
    methods: {
        onSubmit() {
            this.form.post('/applications')
                .then(data => {
                    console.log(data);
                    window.location.href= '/applications/' + data.id;
                })
                .catch(errors => console.log(errors));
        },
        saveItem(type) {
          switch(type) {
                case "criticalFactors":
                    this.saveCriticalFactors();
                    break;
                case "majorFactors":
                    this.saveMajorFactors();
                    break;
                case "otherObservations":
                    this.saveOtherObservations();
                    break;
                default:
                    this.form._1toRegisterPlace = true
          }
        },
        saveCriticalFactors() {
            console.log('saveCriticalFactors');
        },
        saveMajorFactors() {
            console.log('saveMajorFactors');
        },
        saveOtherObservations() {
            console.log('saveOtherObservations');
        },
        removeItem(type, item, key) {

        },
        editItem(type, item) {

        }
    }
});