const app = new Vue({
    el: "#app",
    data: {
        reportId: document.getElementById('report_id').value,
        inspectionId: document.getElementById('inspection_id').value,
        report: {},
        critical: [],
        major: [],
        other: [],
        pageLoaded: false,
        isFollowUpRequired: '',
        isFined: '',
        payEnabled: false,
        enableHandover: false,
        statusChangeStatus: null,
        statusChangeColor: 'is-success',
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
            verifiedByDate: "",
        }),
        inspectionForm: new Form({
            date: new Date(),
            time: new Date(),
            datetimeString: '',
            dateString: '',
            timeString: '',
            inspection_id: null,
            type: null
        }),
        fineForm: new Form({
            amount: null,
            fined_on: new Date(),
            is_paid: false,
            paid_on: new Date(),
        })
    },
    watch: {
    },
    mounted() {
        this.getReport();
        this.datePickerInput();
        this.timePickerInput();
    },
    methods: {
        sendForProcessing() {
            axios
              .patch('/english/reports/'+ this.reportId +'/status/pending')
            .then(response => {
                this.statusChangeColor = 'is-success';
                this.statusChangeStatus = 'status changed successfully.'
                this.goToReport();
            }).catch(error => {
                this.statusChangeStatus = 'error changing status: ' + error.response.data.message;
                this.statusChangeColor = 'is-danger';
                this.getReport();
            });
        },
        goToReport() {
            window.location.href='/english/reports/' + this.reportId;
        },
        datePickerInput(date) {
            var date = (date) ? date: this.inspectionForm.date;
            // YYYY-MM-DD HH:MI:SS
            this.inspectionForm.dateString = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
            console.log(this.inspectionForm.dateString);
        },
        timePickerInput() {
            if (this.inspectionForm.time) {
                var date = this.inspectionForm.time;
                this.inspectionForm.timeString = date.getHours() + ':' + this.pad(date.getMinutes()) + ':' + '00';
                console.log(this.inspectionForm.timeString);
            }
        },
        pad(value) {
            if(value < 10) {
                return '0' + value;
            } else {
                return value;
            }
        },
        buildDateTimeString() {
            return this.inspectionForm.datetimeString = this.inspectionForm.dateString + ' ' + this.inspectionForm.timeString;
        },
        changedisFined() {
            if(this.pageLoaded) {
                axios
                  .patch('/api/inspections/' + this.report.inspection.id + '/updatefined', {
                      fined: this.isFined
                  })
                .then(response => {
                    // console.log(response.data);
                    // this.setFromModel(response.data);
                }).catch(erros => {
                    this.getReport();
                });
            }
        },
        changedisFollowUpRequired() {
            if(this.pageLoaded) {
                axios
                  .patch('/api/inspections/' + this.report.inspection.id + '/updatefollowup', {
                      followup: this.isFollowUpRequired
                  })
                .then(response => {
                    // console.log(response.data);
                    // this.setFromModel(response.data);
                }).catch(erros => {
                    this.getReport();
                });
            }
        },
        saveFine() {
            axios
            .post('/inspections/' + this.report.inspection.id + '/fines', {
                amount: this.fineForm.amount,
                fined_on: this.formatDate(this.fineForm.fined_on),
                paid_on: this.paid(this.fineForm.paid_on),
                is_paid: this.fineForm.is_paid,
            })
            .then(response => {
                this.getReport();
            })
            .catch(errors => console.log(errors));
        },
        paid(date) {
            if(this.payEnabled) {
                return this.formatDate(date);
            }

            return null;
        },
        formatDate(date) {
            return date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate() + ' 00:00:00';
        },
        deleteFine() {
            axios
              .delete('/inspections/' + this.report.inspection.id + '/fines')
            .then(response => {
                this.getReport();
            })
            .catch(errors => console.log(errors));
        },
        deleteReportsHandedOver() {
            axios.patch('/api/inspections/' + this.report.inspection.id + '/handoverreports', {
                'report_handed_over_at': null
            }).then(response => {
                this.getReport();
            })
            .catch(errors => console.log(errors));
        },
        saveReportsHandedOver() {
            axios.patch('/api/inspections/' + this.report.inspection.id + '/handoverreports', {
                'report_handed_over_at': this.buildDateTimeString()
            }).then(response => {
                this.getReport();
            })
            .catch(errors => console.log(errors));
        },
        getReport() {
            axios
              .get('/api/english/reports/' + this.reportId)
            .then(response => {
                console.log(response.data);
                this.setFromModel(response.data);
            })
            .catch(errors => console.log(errors));
        },
        setFromModel(data) {
            this.report = data;
            this.inspection = data.inspection;
            this.business = this.inspection.business;
            this.isFollowUpRequired = this.inspection.is_followup_required;
            this.isFined = this.inspection.is_fined;

            this.enableHandover = (this.inspection.report_handed_over_at) ? true : false;

            if(this.inspection.fine) {
                this.fineForm.amount = this.inspection.fine.amount;
                this.fineForm.fined_on = new Date(this.inspection.fine.fined_on);
                this.fineForm.paid_on = new Date(this.inspection.fine.paid_on);
                this.fineForm.is_paid = this.inspection.fine.is_paid;
            } else {
                this.fineForm.amount = null;
                this.fineForm.fined_on = new Date();
                this.fineForm.paid_on = new Date();
                this.fineForm.is_paid = false;
            }

            this.critical = (data.critical) ? JSON.parse(data.critical) : [];
            this.major = (data.major) ? JSON.parse(data.major) : [];
            this.other = (data.observations) ? JSON.parse(data.observations) : [];
            this.form.establishmentName = this.business.name;
            this.form.dateOfInspection = this.inspection.inspection_at;
            this.form.scopeOfInspection = data.scope;
            this.form.areasInspected = data.areas;
            this.form.criticalViolation = '';//data.criticalViolation;
            this.form.criticalCorrectiveAction = '';//data.criticalCorrectiveAction;
            this.form.majorViolation = '';//data.majorViolation;
            this.form.majorCorrectiveAction = '';//data.majorCorrectiveAction;
            this.form.otherObservationsViolation = '';//data.otherObservationsViolation;
            this.form.otherObservationsCorrectiveAction = '';//data.otherObservationsCorrectiveAction;
            this.form.comments = data.comments;
            this.form.inspectionMember1Name = data.inspectionMember1Name;
            this.form.inspectionMember1Designation = data.inspectionMember1Designation;
            this.form.inspectionMember1Date = data.inspectionMember1Date;
            this.form.inspectionMember2Name = data.inspectionMember2Name;
            this.form.inspectionMember2Designation = data.inspectionMember2Designation;
            this.form.inspectionMember2Date = data.inspectionMember2Date;
            this.form.verifiedByName = data.verifiedByName;
            this.form.verifiedByDesignation = data.verifiedByDesignation;
            this.form.verifiedByDate = data.verifiedByDate;

            this.pageLoaded = true;
        },
        onSubmit() {
            axios.patch('/english/reports/' + this.reportId, {
                scope: this.form.scopeOfInspection,
                areas: this.form.areasInspected,
                comments: this.form.comments,
                inspectionMember1Name: this.form.inspectionMember1Name,
                inspectionMember1Designation: this.form.inspectionMember1Designation,
                inspectionMember1Date: this.form.inspectionMember1Date,
                inspectionMember2Name: this.form.inspectionMember2Name,
                inspectionMember2Designation: this.form.inspectionMember2Designation,
                inspectionMember2Date: this.form.inspectionMember2Date,
                verifiedByName: this.form.verifiedByName,
                verifiedByDesignation: this.form.verifiedByDesignation,
                verifiedByDate: this.form.verifiedByDate
            })
            .then(response => {
                this.setFromModel(response.data);
                console.log(response);
            })
            .catch(errors => console.log(errors));
        },
        addItem(type) {
              switch(type) {
                    case "criticalFactors":
                        this.critical.push({
                            v: this.form.criticalViolation,
                            r: this.form.criticalCorrectiveAction
                        });
                        this.updateCriticalFactors();
                        break;
                    case "majorFactors":
                        this.major.push({
                            v: this.form.majorViolation,
                            r: this.form.majorCorrectiveAction
                        });
                        this.updateMajorFactors();
                        break;
                    case "otherObservations":
                        this.other.push({
                            v: this.form.otherObservationsViolation,
                            r: this.form.otherObservationsCorrectiveAction
                        });
                        this.updateOtherObservations();
                        break;
                    default:
              }
        },
        removeItem(type, item, key) {
              switch(type) {
                    case "criticalFactors":
                        this.critical.splice(key, 1);
                        this.updateCriticalFactors();
                        break;
                    case "majorFactors":
                        this.major.splice(key, 1);
                        this.updateMajorFactors();
                        break;
                    case "otherObservations":
                        this.other.splice(key, 1);
                        this.updateOtherObservations();
                        break;
                    default:
              }
        },
        // editItem(type, item, key) {
        //     switch(type) {
        //         case "criticalFactors":
        //             this.updateCriticalFactors();
        //             break;
        //         case "majorFactors":
        //             this.updateMajorFactors();
        //             break;
        //         case "otherObservations":
        //             this.updateOtherObservations();
        //             break;
        //         default:
        //       }
        // },
        updateCriticalFactors() {
            console.log('updateCriticalFactors');
            axios.patch('/english/reports/' + this.reportId + '/critical', {
                data: this.critical
            }).then(response => {
                this.critical = response.data;
                console.log(response.data);
            }).catch(errors => {console.log(erros);})
        },
        updateMajorFactors() {
            console.log('updateMajorFactors');
            axios.patch('/english/reports/' + this.reportId + '/major', {
                data: this.major
            }).then(response => {
                this.major = response.data;
                console.log(response.data);
            }).catch(errors => {console.log(erros);})
        },
        updateOtherObservations() {
            console.log('updateOtherObservations');
            axios.patch('/english/reports/' + this.reportId + '/other', {
                data: this.other
            }).then(response => {
                this.other = response.data;
                console.log(response.data);
            }).catch(errors => {console.log(erros);})
        },
    }
});