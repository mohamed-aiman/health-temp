const app = new Vue({
    el: "#app",
    data: {
        normalFormId: document.getElementById('form_id').value,
        normalForm: {},
        categorizedFormPoints: [],
        statusChangeStatus: null,
        statusChangeColor: 'is-success',
        remarksEditingId: null,
        remarksForm: {
            remarks: ''
        },
        remarksResponse: {},
        isRemarksModalActive: false
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
        getNormalFormPoints() {
            axios
            .get('/api/normalforms/' + this.normalFormId + '/points')
                .then(response => {
                    this.categorizedFormPoints = response.data;
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
        changedValue(point) {
            axios
            .patch('/api/normalforms/' + this.normalFormId + '/formpoints/' + point.id + '/value/changed', {
                value: point.value
            })
                .then(response => {
                    point = response.data;
                })
                .catch(errors => alert('unable to mark or unmark(value)!'));    
        },
        changedNotApplicable(point) {
            axios
            .patch('/api/normalforms/' + this.normalFormId + '/formpoints/' + point.id + '/notapplicable/changed', {
                not_applicable: point.not_applicable
            })
                .then(response => {
                    point = response.data;
                })
                .catch(errors => alert('unable to mark or unmark(not_applicable)!'));   
        },
        updatePointRemarks(point, remarks) {
            axios
            .patch('/api/normalforms/' + this.normalFormId + '/formpoints/' + point.id + '/remarks/changed', {
                remarks: point.remarks
            })
                .then(response => {
                    point = response.data;
                })
                .catch(errors => alert('unable to change remarks!'));   
        },
        savePlaceInfoReason() {
            axios
            .patch('/api/normalforms/' + this.normalFormId, this.normalForm)
                .then(response => {
                    this.normalForm = response.data;
                })
                .catch(errors => alert('unable to update the normal form!'));   
        },
        goToShow() {
            if (this.normalForm.normal_inspection_id != null) {
                window.location.href = '/normalinspections/' + this.normalForm.normal_inspection_id + '/normalforms'
            }
        },
        sendForProcessing() {
            axios
            .patch('/api/normalforms/' + this.normalFormId + '/status/pending')
            .then(response => {
                this.normalForm = response.data;
                this.statusChangeColor = 'is-success';
                this.statusChangeStatus = 'status changed successfully.'
                this.goToShow();
            })
            .catch(error => {
                this.statusChangeStatus = 'Error changing status: '  + error.response.data.message;
                this.statusChangeColor = 'is-danger';
            });
        },
        openRemarksForm(item) {
            this.remarksResponse = {};
            this.remarksEditingId = item.id;
            this.remarksForm = item;
            this.isRemarksModalActive = true;
            console.log('openedd remarks form'+item.id);
        },
        saveRemarks() {
            axios
            .patch('/api/normalforms/' + this.normalFormId + '/formpoints/' + this.remarksEditingId + '/remarks/changed', this.remarksForm)
            .then(response => {
                this.remarksResponse = response; 
                setTimeout(function() {
                    this.remarksResponse = {};
                    this.$emit('update:remarksResponse', {});
                    this.isRemarksModalActive = false;
                }.bind(this), 1000);
            })
            .catch(errors => {
                this.remarksResponse = errors.response;
            });   
        }
    }
});
