<template>
  <div v-can="'api.english-reports.update'">
    <div class="columns no-print" v-if="statusChangeStatus">
        <div class="column">
            <div class="notification" :class="statusChangeColor">{{statusChangeStatus}}</div>
        </div>
    </div>
    <div class="columns no-print">
        <div class="column dhivehi">
            <table class="table">
                <tr>
                    <td class="right">
                        <a class="button is-warning" v-can="'api.english-reports.update'" @click="saveEnglishReportForm()">ރައްކާކުރޭ</a>
                        <a class="button is-warning" v-can="'api.english-reports.sendForProcessing'" @click="sendForProcessing()">ޕްރޮސެސިން އަށް ފޮނުވާ</a>
                        <router-link class="button is-info" v-can="'api.inspections.english-reports.show'" :to="{ name: 'english-reports.show', params: { reportId: reportId }}">ޕްރިންޓް ވިއު</router-link>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div>
        <div class="columns">
            <div class="column is-fullwidth">
              <h1 class="title">
                INSPECTION REPORT OF FOOD ESTABLISHMENT
              </h1>
            </div>
        </div>
        <div>
            <div class="columns box">
                <table class="table is-narrow">
                    <tr>
                        <td>Establishment Name</td>
                        <td>
                            <div class="field">
                              <div class="control">
                                    <input class="input" type="text" disabled v-model="form.establishmentName">
                              </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Date of Inspection</td>
                        <td>
                            <div class="field">
                              <div class="control">
                                    <input class="input" type="text" disabled v-model="form.dateOfInspection">
                              </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <br>
            <div class="columns box">
                <div class="column">
                    <div class="field">
                      <label class="label">SCOPE OF INSPECTION:</label>
                      <div class="control">
                            <textarea class="textarea" v-model="form.scopeOfInspection"></textarea>
                      </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="columns box">
                <div class="column">
                    <div class="field">
                      <label class="label">AREAS INSPECTED:</label>
                      <div class="control">
                            <textarea class="textarea" v-model="form.areasInspected"></textarea>
                      </div>
                    </div>
                </div>
            </div>


            <div class="columns">
                <div class="column">
                    <label class="label">1. CRITICAL FACTORS / VIOLATIONS that require immediate corrective action</label>
                </div>
            </div>

            <div class="columns box">
                <div class="column">
                    <table class="table is-narrowed">
                        <tr>
                            <th>VIOLATIONS</th>
                            <th>CORRECTIVE ACTION</th>
                            <th>action</th>
                        </tr>
                        <tr>
                            <td>
                                <div class="field">
                                  <div class="control">
                                        <input class="input" type="text" v-model="form.criticalViolation">
                                  </div>
                                </div>
                            </td>
                            <td>
                                <div class="field">
                                  <div class="control">
                                        <input class="input" type="text" v-model="form.criticalCorrectiveAction">
                                  </div>
                                </div>
                            </td>
                            <td>
                              <p class="buttons">
                                  <a class="button is-success"  @click="addItem('criticalFactors')">
                                    <span class="icon is-small">
                                      <i class="fa fa-plus"></i>
                                    </span>
                                  </a>
                                  <!-- <a class="button is-warning" @click="cancel('criticalFactors')">
                                    <span class="icon is-small">
                                      <i class="fa fa-times"></i>
                                    </span>
                                  </a> -->
                              </p>
                            </td>
                        </tr>
                        <tr v-for="item,key in critical">
                            <td>{{item.v}}</td>
                            <td>{{item.r}}</td>
                            <td>
                                <p class="buttons">
                                  <!-- <a class="button is-warning" @click="editItem('criticalFactors',item, key)">
                                    <span class="icon is-small">
                                      <i class="fa fa-edit"></i>
                                    </span>
                                  </a> -->
                                  <a class="button is-danger" @click="removeItem('criticalFactors', item, key)">
                                    <span class="icon is-small">
                                      <i class="fa fa-times"></i>
                                    </span>
                                  </a>
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>


            <div class="columns">
                <div class="column">
                    <label class="label">2. MAJOR FACTORS / VIOLATIONS that require corrective actions in a given time</label>
                </div>
            </div>

            <div class="columns box">
                <div class="column">
                    <table class="table is-narrowed">
                        <tr>
                            <th>VIOLATIONS</th>
                            <th>CORRECTIVE ACTIONS</th>
                            <th>action</th>
                        </tr>
                        <tr>
                            <td>
                                <div class="field">
                                  <div class="control">
                                        <input class="input" type="text" v-model="form.majorViolation">
                                  </div>
                                </div>
                            </td>
                            <td>
                                <div class="field">
                                  <div class="control">
                                        <input class="input" type="text" v-model="form.majorCorrectiveAction">
                                  </div>
                                </div>
                            </td>
                            <td>
                              <p class="buttons">
                                  <a class="button is-success"  @click="addItem('majorFactors')">
                                    <span class="icon is-small">
                                      <i class="fa fa-plus"></i>
                                    </span>
                                  </a>
                                  <!-- <a class="button is-warning" @click="cancel('majorFactors')">
                                    <span class="icon is-small">
                                      <i class="fa fa-times"></i>
                                    </span>
                                  </a> -->
                              </p>
                            </td>
                        </tr>
                        <tr v-for="item,key in major">
                            <td>{{item.v}}</td>
                            <td>{{item.r}}</td>
                            <td>
                                <p class="buttons">
                                  <!-- <a class="button is-warning" @click="editItem('majorFactors',item, key)">
                                    <span class="icon is-small">
                                      <i class="fa fa-edit"></i>
                                    </span>
                                  </a> -->
                                  <a class="button is-danger" @click="removeItem('majorFactors', item, key)">
                                    <span class="icon is-small">
                                      <i class="fa fa-times"></i>
                                    </span>
                                  </a>
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="columns">
                <div class="column">
                    <label class="label">3. OTHER OBSERVATIONS (Requires corrective actions)</label>
                </div>
            </div>

            <div class="columns box">
                <div class="column">
                    <table class="table is-narrowed">
                        <tr>
                            <th>OBSERVATIONS</th>
                            <th>RECOMMENDED CORRECTIVE ACTIONS</th>
                            <th>action</th>
                        </tr>
                        <tr>
                            <td>
                                <div class="field">
                                  <div class="control">
                                        <input class="input" type="text" v-model="form.otherObservationsViolation">
                                  </div>
                                </div>
                            </td>
                            <td>
                                <div class="field">
                                  <div class="control">
                                        <input class="input" type="text" v-model="form.otherObservationsCorrectiveAction">
                                  </div>
                                </div>
                            </td>
                            <td>
                              <p class="buttons">
                                  <a class="button is-success"  @click="addItem('otherObservations')">
                                    <span class="icon is-small">
                                      <i class="fa fa-plus"></i>
                                    </span>
                                  </a>
                                  <!-- <a class="button is-warning" @click="cancel('otherObservations')">
                                    <span class="icon is-small">
                                      <i class="fa fa-times"></i>
                                    </span>
                                  </a> -->
                              </p>
                            </td>
                        </tr>
                        <tr v-for="item,key in other">
                            <td>{{item.v}}</td>
                            <td>{{item.r}}</td>
                            <td>
                                <p class="buttons">
                                  <!-- <a class="button is-warning" @click="editItem('otherObservations',item, key)">
                                    <span class="icon is-small">
                                      <i class="fa fa-edit"></i>
                                    </span>
                                  </a> -->
                                  <a class="button is-danger" @click="removeItem('otherObservations', item, key)">
                                    <span class="icon is-small">
                                      <i class="fa fa-times"></i>
                                    </span>
                                  </a>
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <br>
            <div class="columns box">
                <div class="column">
                    <div class="field">
                      <label class="label">Comments:</label>
                      <div class="control">
                            <textarea class="textarea" v-model="form.comments"></textarea>
                      </div>
                    </div>
                </div>
            </div>
            <br>

            <div class="columns box">
                <div class="column">
                    <table class="table">
                        <tr>
                            <td colspan="6">
                              <label class="label">Inspection team:</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>
                                <div class="field">
                                  <div class="control">
                                        <input class="input" type="text" v-model="form.inspectionMember1Name">
                                  </div>
                                </div>
                            </td>
                            <td>Designation</td>
                            <td>
                                <div class="field">
                                  <div class="control">
                                        <input class="input" type="text" v-model="form.inspectionMember1Designation">
                                  </div>
                                </div>
                            </td>
                            <td>Date</td>
                            <td>
                                <div class="field">
                                  <div class="control">
                                        <input class="input" type="text" v-model="form.inspectionMember1Date">
                                  </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>
                                <div class="field">
                                  <div class="control">
                                        <input class="input" type="text" v-model="form.inspectionMember2Name">
                                  </div>
                                </div>
                            </td>
                            <td>Designation</td>
                            <td>
                                <div class="field">
                                  <div class="control">
                                        <input class="input" type="text" v-model="form.inspectionMember2Designation">
                                  </div>
                                </div>
                            </td>
                            <td>Date</td>
                            <td>
                                <div class="field">
                                  <div class="control">
                                        <input class="input" type="text" v-model="form.inspectionMember2Date">
                                  </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <br>

            <div class="columns box">
                <div class="column">
                    <table class="table">
                        <tr>
                            <td colspan="6">
                              <label class="label">Report verified by:</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>
                                <div class="field">
                                  <div class="control">
                                        <input class="input" type="text" v-model="form.verifiedByName">
                                  </div>
                                </div>
                            </td>
                            <td>Designation</td>
                            <td>
                                <div class="field">
                                  <div class="control">
                                        <input class="input" type="text" v-model="form.verifiedByDesignation">
                                  </div>
                                </div>
                            </td>
                            <td>Date</td>
                            <td>
                                <div class="field">
                                  <div class="control">
                                        <input class="input" type="text" v-model="form.verifiedByDate">
                                  </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
export default {
    props: ['inspectionId'],
    data() {
        return {
            reportId: null,
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
        }
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
          if (this.hasPermission('api.english-reports.sendForProcessing')) {
            axios
              .patch('/api/english/reports/'+ this.reportId +'/status/pending')
            .then(response => {
                this.statusChangeColor = 'is-success';
                this.statusChangeStatus = 'status changed successfully.'
                if (this.hasPermission('api.inspections.show')) {
                  this.goToInspection();
                } else {
                  this.goToReport();
                }
            }).catch(error => {
                this.statusChangeStatus = 'error changing status: ' + error.response.data.message;
                this.statusChangeColor = 'is-danger';
                this.getReport();
            });
          }
        },
        goToInspection() {
          this.$router.push({ name: 'inspections.show', params: { inspectionId: this.report.inspection.id } })
        },
        goToReport() {
          if (this.hasPermission('api.inspections.english-reports.show')) {
            this.$router.push({ name: 'english-reports.show', params: { reportId: this.reportId } })
          }
        },
        getReport() {
          if (this.hasPermission('api.inspections.english-reports.show')) {
            axios.get('/api/inspections/' + this.inspectionId + '/english/reports/')
            .then(response => {
                this.setFromModel(response.data);
            })
            .catch(errors => {
                console.log('errors', errors);
            }); 
          }
        },
        datePickerInput(date) {
            var date = (date) ? date: this.inspectionForm.date;
            // YYYY-MM-DD HH:MI:SS
            this.inspectionForm.dateString = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
        },
        timePickerInput() {
            if (this.inspectionForm.time) {
                var date = this.inspectionForm.time;
                this.inspectionForm.timeString = date.getHours() + ':' + this.pad(date.getMinutes()) + ':' + '00';
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
        paid(date) {
            if(this.payEnabled) {
                return this.formatDate(date);
            }

            return null;
        },
        formatDate(date) {
            return date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate() + ' 00:00:00';
        },
        setFromModel(data) {
            this.reportId = data.id;
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
        saveEnglishReportForm() {
          if (this.hasPermission('api.english-reports.update')) {
            axios.patch('/api/english/reports/' + this.reportId, {
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
                this.statusChangeColor = 'is-success';
                this.statusChangeStatus = 'saved successfully.'
            })
            .catch(error => {
                this.statusChangeStatus = 'unable to save: ' + error.response.data.message;
                this.statusChangeColor = 'is-danger';
            });
          }
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
          if (this.hasPermission('api.english-reports.critical.update')) {
            axios.patch('/api/english/reports/' + this.reportId + '/critical', {
                data: this.critical
            }).then(response => {
                this.critical = response.data;
            }).catch(errors => {console.log(erros);})
          }
        },
        updateMajorFactors() {
          if (this.hasPermission('api.english-reports.major.update')) {
            axios.patch('/api/english/reports/' + this.reportId + '/major', {
                data: this.major
            }).then(response => {
                this.major = response.data;
            }).catch(errors => {console.log(erros);})
          }
        },
        updateOtherObservations() {
          if (this.hasPermission('api.english-reports.other.update')) {
            axios.patch('/api/english/reports/' + this.reportId + '/other', {
                data: this.other
            }).then(response => {
                this.other = response.data;
            }).catch(errors => {console.log(erros);})
          }
        },
    }
}
</script>