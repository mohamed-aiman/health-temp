<template>
<div v-can="'api.grading-inspections.show'">
    <div class="columns">
      <div class="column is-fullwidth">
          <h1 class="title">
            Closing Grading Inspection
            <!-- 'Closing Inspection of ' . $inspection->business->name . ' (id:' . $inspection->id . ')' -->
          </h1>
      </div>
    </div>

    <template id="business_details" v-if="inspection.business != null">
        <div class="box">
            <business-details :business="inspection.business">
                <template>
                    <tr>
                        <td colspan="2" class="center">
                            <div>
                                <button class="button is-warning" v-can="'api.inspections.fines.store'" @click="openNewFineForm()">Fine</button>
                                <button class="button is-danger" v-can="'api.businesses.terminate'" @click="openTerminateForm()">Terminate</button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="isNewFineFormOpened">
                        <td colspan="2">
                            <div class="columns">
                        <div class="column"><div class="field">Amount: <input type="number" name="amount" v-model="fineForm.amount" class="input"></div></div>
                        <div class="column"><div class="field">Fined On: <b-datepicker placeholder="Click to select..." icon="calendar-today" editable v-model="fineForm.fined_on"></b-datepicker></div></div>
                        <div class="column"><div class="field">Remarks: <input type="text" name="remarks" v-model="fineForm.remarks" class="input"></div></div>
                          <div class="column">
                                <br>
                                <p class="buttons">
                                  <a class="button is-success"  @click="addFine()">
                                    <span class="icon is-small">
                                      <i class="fa fa-plus"></i>
                                    </span>
                                  </a>
                                </p>
                            </div>
                        </div>
                        </td>
                    </tr>
                    <tr v-if="isTerminateFormOpened">
                        <td colspan="2">
                            <div class="columns">
                        <div class="column"><div class="field">Reason: <input type="text" name="reason" v-model="terminateForm.reason" class="input"></div></div>
                        <div class="column"><div class="field">Terminated On: <b-datepicker placeholder="Click to select..." icon="calendar-today" editable v-model="terminateForm.terminated_on"></b-datepicker></div></div>
                      <div class="column">
                            <br>
                            <p class="buttons">
                              <a class="button is-danger"  @click="saveTermination()">
                                <span class="icon is-small">
                                  <i class="fa fa-save"></i>
                                </span>
                              </a>
                            </p>
                        </div>
                        </div>
                        </td>
                    </tr>
                </template>
            </business-details>

            <div class="columns">
                <div class="column">
                    <table v-if="fines.length>0" class="table is-narrow is-bordered is-fullwidth">
                        <tr>
                            <th colspan="5">Fines</th>
                        </tr>
                        <tr v-if="isUpdateFineFormOpened">
                            <td colspan="5">
                                <div class="columns">
                            <div class="column"><div class="field">Amount: <input type="number" name="amount" v-model="fineForm2.amount" class="input"></div></div>
                            <div class="column"><div class="field">Fined On: <b-datepicker placeholder="Click to select..." icon="calendar-today" editable v-model="fineForm2.fined_on"></b-datepicker></div></div>
                            <div class="column"><div class="field">Remarks: <input type="text" name="remarks" v-model="fineForm2.remarks" class="input"></div></div>
                              <div class="column">
                                <br>
                                <p class="buttons">
                                      <a class="button is-warning"  @click="updateFine()">
                                        <span class="icon is-small">
                                          <i class="fa fa-save"></i>
                                        </span>
                                      </a>
                                    </p>
                            </div>
                        </div>
                        </td>
                    </tr>
                        <tr>
                            <td>Id</td>
                            <td>Fined On</td>
                            <td>Amount (MVR)</td>
                            <td>Remarks</td>
                            <td>Options</td>
                        </tr>
                        <tr v-for="item in fines">
                            <td>{{item.id}}</td>
                            <td>{{item.fined_on}}</td>
                            <td>{{item.amount}}</td>
                            <td>{{item.remarks}}</td>
                            <td>
                                <a v-if="!item.is_paid" v-can="'api.fines.update'" class="button is-warning"  @click="loadFineForm(item)">
                                    <span class="icon is-small">
                                  <i class="fa fa-edit"></i>
                                </span>
                              </a>
                                <a v-if="!item.is_paid" v-can="'api.fines.destroy'" class="button is-danger" @click="deleteFine(item)">
                                    <span class="icon is-small">
                                      <i class="fa fa-close"></i>
                                    </span>
                                  </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </template>


    <template id="inspection-details"  v-if="inspection != null">
        <div class="box">
            <div class="columns">
                <div class="column">
                    <table class="table is-narrow is-bordered is-fullwidth">
                        <thead>
                            <tr>
                                <th colspan="7">
                                    <router-link  class="is-link" v-can="'api.inspections.show'" :to="{ name: 'inspections.show', params: { inspectionId: inspection.id }}">
                                        Inspection Details
                                    </router-link>
                                </th>
                            </tr>
                            <tr>
                                <th>Id</th>
                                <th>Status</th>
                                <th>Type</th>
                                <th>Inspection At</th>
                                <th>Follow Up</th>
                                <th v-if="inspection.is_followup_required || inspection.is_fined">Tags</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{inspection.id}}</td>
                                <td>{{inspection.status}}</td>
                                <td v-if="!inspection.register_or_renew">{{inspection.reason}}</td>
                                <td v-if="inspection.register_or_renew">{{inspection.register_or_renew}}
                                    <router-link v-can="'api.applications.show'" :to="{ name: 'applications.show', params: { applicationId: inspection.application_id }}">
                                        ({{inspection.application_id}})
                                    </router-link>
                                <td>{{inspection.inspection_at}}</td>
                                <td>
                                    <router-link v-can="'api.grading-inspections.show'" :to="{ name: 'grading-inspections.show', params: { inspectionId: inspection.follow_up_id }}">
                                        {{inspection.follow_up_id }}
                                    </router-link>
                                </td>
                                <td v-if="inspection.is_followup_required || inspection.is_fined">
                                    <div class="tags">
                                        <div class="tag is-warning" v-if="inspection.is_followup_required">followup required</div>
                                        <div class="tag is-danger" v-if="inspection.is_fined">fined</div>
                                    </div>
                                </td>
                                <td>
                                    <p class="buttons">
                                        <router-link class="button is-info" v-can="'api.grading-inspections.gradingforms.show'" :to="{ name: 'grading-inspections.gradingforms.show', params: { inspectionId: inspection.id }}">
                                            <span class="icon is-small">
                                              <i class="fa fa-list"></i>
                                            </span>
                                        </router-link>
                                        <a v-can="'api.inspections.followupinspections.store'" class="button is-warning is-success"
                                            @click="isScheduleNewInspectionFormOpended = true">
                                            Schedule a new Inspection
                                        </a>
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <template>
                        <section>
                         <b-modal :active.sync="isScheduleNewInspectionFormOpended" has-modal-card>
                            <div class="container">
                                    <div class="columns modal-card" style="width: auto;">
                                        <div class="column box">
                                            <div class="columns">
                                                <div class="column">
                                                  <div class="label is-normal">
                                                    <label class="label">Schedule an Inspection</label>
                                                  </div>
                                                </div>
                                            </div>
                                            <div class="columns">
                                                <div class="column">
                                                    <div class="field">
                                                        <template>
                                                            <b-field label="Date">
                                                                <b-datepicker
                                                                    placeholder="Click to select..."
                                                                    inline 
                                                                    icon="calendar-today"
                                                          @input="datePickerInput"
                                                                    v-model="inspectionForm.date">
                                                                </b-datepicker>
                                                            </b-field>
                                                        </template>
                                                    </div>
                                                </div>
                                                <div class="column">
                                                    <div class="field">
                                                      <template>
                                                            <b-field label="Time">
                                                                <b-timepicker
                                                                    placeholder="Type or select a date..."
                                                                    inline 
                                                                    icon="clock"
                                                                    editable
                                                                    v-model="inspectionForm.time">
                                                                </b-timepicker>
                                                            </b-field>
                                                        </template>
                                                    </div>
                                                </div>
                                                <div class="column">
                                                    <div class="field">
                                                      <label class="label">Reason</label>
                                                        <div class="select control">
                                                            <select v-model="inspectionForm.reason">
                                                                <option value="followup" selected>Followup</option>
                                                                <option value="complaint">Complaint</option>
                                                                <option value="routine">Routine</option>
                                                                <option value="unspecified">Unspecified </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="column">
                                                    <div class="field">
                                                      <label class="label">Remarks</label>
                                                        <div class="control">
                                                            <input type="text" placeholder="remarks" class="input" v-model="inspectionForm.remarks">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="column">
                                                    <div class="field">
                                                      <label class="label">&nbsp</label>
                                                      <div class="control">
                                                        <button class="button is-link" @click="saveInspection">Save Inspection</button>
                                                      </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </b-modal>
                        </section>
                    </template>
                </div>
            </div>
            
            <template>
                <div class="columns dhivehi">
                    <div class="column">
                        <table class="table is-bordered">
                            <tr>
                                <td colspan="5"><b>ދަރަޖަކުރުން</b></td>
                            </tr>
                            <tr>
                                <td>ކެޓަގަރީ</td>
                                <td>ޖުމްލަ އަދަދު</td>
                                <td>ރަނގަޅު ކޮށްފައިވާ އަދަދު</td>
                                <td>ރަނގަޅު ކުރަންޖެހޭ އަދަދު</td>
                                <td>އަދަދު NA</td>
                            </tr>
                            <tr>
                                <td >ކްރިޓިކަލް ގެ މުޅި ޖުމްލަ </td>
                                <td>{{(gradingCalculated.counts.total.CR) ? gradingCalculated.counts.total.CR : 0 }}</td>
                                <td>{{(gradingCalculated.counts.satisfied.CR) ? gradingCalculated.counts.satisfied.CR : 0 }}</td>
                                <td>{{(gradingCalculated.counts.not_satisfied.CR) ? gradingCalculated.counts.not_satisfied.CR : 0 }}</td>
                                <td>{{(gradingCalculated.counts.not_applicable.CR) ? gradingCalculated.counts.not_applicable.CR : 0 }}</td>
                            </tr>
                            <tr>
                                <td>މޭޖަރ ގެ މުޅި ޖުމްލަ </td>
                                <td>{{(gradingCalculated.counts.total.MJ) ? gradingCalculated.counts.total.MJ : 0 }}</td>
                                <td>{{(gradingCalculated.counts.satisfied.MJ) ? gradingCalculated.counts.satisfied.MJ : 0 }}</td>
                                <td>{{(gradingCalculated.counts.not_satisfied.MJ) ? gradingCalculated.counts.not_satisfied.MJ : 0 }}</td>
                                <td>{{(gradingCalculated.counts.not_applicable.MJ) ? gradingCalculated.counts.not_applicable.MJ : 0 }}</td>
                            </tr>
                            <tr>
                                <td>މައިނަރ ގެ މުޅި ޖުމްލަ</td>
                                <td>{{(gradingCalculated.counts.total.MN) ? gradingCalculated.counts.total.MN : 0 }}</td>
                                <td>{{(gradingCalculated.counts.satisfied.MN) ? gradingCalculated.counts.satisfied.MN : 0 }}</td>
                                <td>{{(gradingCalculated.counts.not_satisfied.MN) ? gradingCalculated.counts.not_satisfied.MN : 0 }}</td>
                                <td>{{(gradingCalculated.counts.not_applicable.MN) ? gradingCalculated.counts.not_applicable.MN : 0 }}</td>
                            </tr>
                            <tr>
                                <td>ދަރަޖަ</td>
                                <td colspan="5" v-if="gradingCalculated.grade == 'A'" style="background-color: green;">A</td>
                                <td colspan="5" v-if="gradingCalculated.grade == 'B'" style="background-color: purple;">B</td>
                                <td colspan="5" v-if="gradingCalculated.grade == 'C'" style="background-color: yellow;">C</td>
                                <td colspan="5" v-if="gradingCalculated.grade == 'FAIL'" style="background-color: orange;">ގްރޭޑަށް ނުފެތޭ</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </template>
            
            <template id="followup-inspection" v-if="inspection.follow_up_inspection">
                <div class="columns">
                        <div class="column">
                            <table class="table is-narrow is-bordered is-fullwidth">
                                <thead>
                                    <tr>
                                        <th colspan="7">
                                            <router-link class="is-link"  v-can="'api.inspections.show'" :to="{ name: 'inspections.show', params: { inspectionId: inspection.follow_up_inspection.id }}">
                                                Followup Inspection
                                            </router-link>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Id</th>
                                        <th>Status</th>
                                        <th>Type</th>
                                        <th>Inspection At</th>
                                        <th v-if="inspection.follow_up_inspection.dhivehi_report_id || inspection.follow_up_inspection.english_report_id || inspection.follow_up_inspection.normal_form_id">Related</th>
                                        <th v-if="inspection.follow_up_inspection.is_followup_required || inspection.follow_up_inspection.is_fined">Tags</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{inspection.follow_up_inspection.id}}</td>
                                        <td>{{inspection.follow_up_inspection.status}}</td>
                                        <td v-if="!inspection.follow_up_inspection.register_or_renew">{{inspection.follow_up_inspection.reason}}</td>
                                        <td v-if="inspection.follow_up_inspection.register_or_renew">{{inspection.follow_up_inspection.register_or_renew}}
                                            <router-link v-can="'api.applications.show'" class="is-link" :to="{ name: 'applications.show', params: { applicationId: inspection.follow_up_inspection.application_id }}">
                                                ({{inspection.follow_up_inspection.application_id}})
                                            </router-link>
                                        </td>
                                        <td>{{inspection.follow_up_inspection.inspection_at}}</td>
                                        <td>
                                            <router-link class="is-link"  v-can="'api.inspections.show'" :to="{ name: 'inspections.show', params: { inspectionId: inspection.follow_up_inspection.follow_up_id }}">
                                                {{inspection.follow_up_inspection.follow_up_id}}
                                            </router-link>
                                        </td>
                                        <td v-if="inspection.follow_up_inspection.is_followup_required || inspection.follow_up_inspection.is_fined">
                                            <div class="tags">
                                                <div class="tag is-warning" v-if="inspection.follow_up_inspection.is_followup_required">followup required</div>
                                                <div class="tag is-danger" v-if="inspection.follow_up_inspection.is_fined">fined</div>
                                            </div>
                                        </td>
                                        <td>
                                     <p class="buttons">
                                                  <a class="button" v-can="'api.dhivehi-reports.show'" v-if="inspection.follow_up_inspection.dhivehi_report_id" v-bind:class="[(inspection.follow_up_inspection.dhivehi_report_id == null) ? isWarning : isSuccess]" alt="dhivehi report" @click="gotToReport(inspection, 'dv')">
                                                    <span class="icon is-small">
                                                      <i class="fa fa-book"></i>
                                                    </span>
                                                <span>Dv</span>
                                                  </a>
                                                  <a class="button" v-can="'api.english-reports.show'" v-if="inspection.follow_up_inspection.english_report_id" v-bind:class="[(inspection.follow_up_inspection.english_report_id == null) ? isWarning : isSuccess]" alt="english report" @click="gotToReport(inspection,'en')">
                                                    <span class="icon is-small">
                                                      <i class="fa fa-book"></i>
                                                    </span>
                                                <span>En</span>
                                                  </a>
                                                <router-link class="button is-info" v-if="inspection.follow_up_inspection.normal_form_id" v-can="'api.normal-forms.show'" :to="{ name: 'normal-forms.show', params: { normalFormId: inspection.follow_up_inspection.normal_form_id }}">
                                                    <span class="icon is-small">
                                                      <i class="fa fa-list"></i>
                                                    </span>
                                                </router-link>
                                              <a class="button is-danger" v-can="'api.followupinspections.destroy'" @click="deleteFollowUpInspection()">
                                                <span class="icon is-small">
                                                  <i class="fa fa-close"></i>
                                                </span>
                                                <span>Delete</span>
                                              </a>
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                </div>
            </template>
        </div>
    </template>


    <div class="columns no-print">
        <div class="column center">
            <button v-if="inspection.status == 'finished'" class="button is-success is-large">CLOSED</button>
            <button v-if="inspection.status != 'finished'" v-can="'api.inspections.close'" class="button is-warning is-large" @click="closeAll()">CLOSE</button>
        </div>
    </div>

</div>
</template>

<script>
	
export default {
    props: ['inspectionId'],
    data() {
        return {
            isSuccess: 'is-success',
            isWarning: 'is-warning',
            isDanger: 'is-danger',
            inspection: {
                fines:[]
            },
            fines: [],
            inspection: {
            },
            pageLoaded: false,
            isFollowUpRequired: '',
            isIssueLicenseFormOpen: false,
            isRenewLicenseFormOpen: false,
            isNewFineFormOpened: false,
            isTerminateFormOpened: false,
            isUpdateFineFormOpened: false,
            isScheduleNewInspectionFormOpended: false,
            isFined: '',
            payEnabled: false,
            enableHandover: false,
            // inspectionForm: new Form({
            //  date: new Date(),
            //  time: new Date(),
            //  datetimeString: '',
            //  dateString: '',
            //  timeString: '',
            //  inspection_id: null,
            //  type: null
            // }),
            terminateForm: {
                reason: null,
                terminated_on:new Date(),
            },
            inspectionForm: new Form({
                date:new Date(),
                time: new Date(),
                datetimeString: '',
                dateString: '',
                timeString: '',
                reason: null,
                remarks: null
            }),
            fineForm: new Form({
                amount: null,
                fined_on: new Date(),
                remarks: null,
                is_paid: false,
                paid_on: new Date(),
            }),
            fineForm2: new Form({
                id: null,
                amount: null,
                fined_on: new Date(),
                remarks: null,
                is_paid: false,
                paid_on: new Date(),
            }),
            editMode: false,
            inspectionForm2: new Form({
                date:new Date(),
                time: new Date(),
                datetimeString: '',
                dateString: '',
                timeString: '',
                inspection_id: null,
                type: null
            }),
            issueLicenseForm: {
                issued_date: new Date(),
                expiry_date: new Date(),
                license_no: null
            },
            gradingCalculated: {
                counts: {
                    total: {},
                    not_satisfied:{},
                    satisfied: {},
                    not_applicable: {}
                },
                grade: {}
            }
        }
    },
    watch: {
        inspection: function() {
            this.getGradingsCalculated();
        }
    },
    mounted() {
        this.getInspection();
        this.getInspectionFines();
        this.datePickerInput();
        this.timePickerInput();
        this.datePickerInput2();
        this.timePickerInput2();
    },
    methods: {
        getGradingsCalculated() {
            axios
              .get('/api/gradingforms/' + this.inspection.grading_form_id + '/gradings')
                .then(response => {
                    this.gradingCalculated = response.data;
                })
                .catch(errors => console.log(errors));
        },
        closeAll() {
            axios
            .patch('/api/gradinginspections/'+this.inspection.id +'/close')
            .then(response => {
                this.getInspection();
            })
            .catch(errors => {
                alert('Error closing inspection: ' + errors.response.data.message);
            }); 
        },
        backendAcceptedDate(date) {
            var date = (date) ? date: this.inspectionForm2.date;
            return date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
        },
        issueLicense() {
            if (this.hasPermission('api.applications.licenses.store')) {
                axios
                .post('/api/applications/'+this.inspection.application_id+'/licenses', {
                    issued_date: this.backendAcceptedDate(this.issueLicenseForm.issued_date),
                    expiry_date: this.backendAcceptedDate(this.issueLicenseForm.expiry_date),
                    license_no: this.issueLicenseForm.license_no
                })
                .then(response => {
                    this.getInspection();
                })
                .catch(errors => {
                    alert('Error issueing license: ' + errors.response.data.message);
                });
            }
        },
        saveInspection() {
            this.submitSaveInspection('/api/gradinginspections/' + this.inspection.id + '/followupinspections', {
                'inspection_at': this.buildDateTimeString(),
                'reason':this.inspectionForm.reason,
                'remarks':this.inspectionForm.remarks,
            });
        },
        submitSaveInspection(url, data) {
            axios
            .post(url, data)
            .then(response => {
                this.getInspection();
            })
            .catch(errors => {
                alert('Error creating new follow up inspection: ' + errors.response.data.message);
            }); 
        },
        deleteFollowUpInspection() {
            axios
            .delete('/api/followupgradinginspections/' + this.inspection.id)
            .then(response => {
                this.getInspection();
            })
            .catch(errors => {
                alert('Error deleting follow up grading inspection: ' + errors.response.data.message);
            }); 
        },
        deleteFine(item) {
            axios
            .delete('/api/fines/' + item.id)
            .then(response => {
                this.getInspectionFines();
            })
            .catch(errors => {
                alert('Error deleting fine:' + errors.response.data.message);
            }); 
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
        datePickerInput2(date) {
            var date = (date) ? date: this.inspectionForm2.date;
            // YYYY-MM-DD HH:MI:SS
            this.inspectionForm2.dateString = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
        },
        timePickerInput2() {
            if (this.inspectionForm2.time) {
                var date = this.inspectionForm2.time;
                this.inspectionForm2.timeString = date.getHours() + ':' + this.pad(date.getMinutes()) + ':' + '00';
            }
        },
        buildDateTimeString2() {
            return this.inspectionForm2.datetimeString = this.inspectionForm2.dateString + ' ' + this.inspectionForm2.timeString;
        },
        gotToReport(item, lang) {
            switch(lang) {
                case "dv":
                        this.$router.push({ name: 'dhivehi-reports.show', params: { reportId: item.dhivehi_report_id } })
                    break;
                case "en":
                        this.$router.push({ name: 'english-reports.show', params: { reportId: item.english_report_id } })
                    break;
                default:
            }
        },
        openTerminateForm() {
            this.isTerminateFormOpened = !this.isTerminateFormOpened;
        },
        openNewFineForm() {
            this.isNewFineFormOpened = !this.isNewFineFormOpened;
        },
        changedisFined() {
            if(this.pageLoaded) {
                axios
                .patch('/api/gradinginspections/' + this.inspectionId + '/updatefined', {
                    fined: this.isFined
                })
                .then(response => {
                }).catch(erros => {
                    this.getInspection();
                });
            }
        },
        changedisFollowUpRequired() {
            if(this.pageLoaded) {
                axios
                .patch('/api/gradinginspections/' + this.inspectionId + '/updatefollowup', {
                    followup: this.isFollowUpRequired
                })
                .then(response => {
                }).catch(erros => {
                    this.getInspection();
                });
            }
        },
        updateFine() {
            axios
            .patch('/api/fines/' + this.fineForm2.id, {
                amount: this.fineForm2.amount,
                fined_on: this.formatDate(this.fineForm2.fined_on),
                remarks: this.fineForm2.remarks,
            })
            .then(response => {
                this.getInspectionFines();
                this.isUpdateFineFormOpened = false;
            })
            .catch(errors => console.log(errors));
        },
        openUpdateForm() {
            this.isUpdateFineFormOpened = !this.isUpdateFineFormOpened;
        },
        loadFineForm(item) {
                this.fineForm2.id = item.id;
                this.fineForm2.amount = item.amount;
                this.fineForm2.fined_on = new Date(item.fined_on);
                this.fineForm2.remarks = item.remarks;

                this.isUpdateFineFormOpened = true;
        },
        addFine() {
            axios
            .post('/api/gradinginspections/' + this.inspectionId + '/fines', {
                amount: this.fineForm.amount,
                fined_on: this.formatDate(this.fineForm.fined_on),
                paid_on: this.paid(this.fineForm.paid_on),
                remarks: this.fineForm.remarks,
            })
            .then(response => {
                this.getInspectionFines();
            })
            .catch(errors => console.log(errors));
        },
        getInspectionFines() {
            if (this.hasPermission('api.inspections.fines.index')) {
                axios
                .get('/api/gradinginspections/' + this.inspectionId + '/fines')
                .then(response => {
                    this.fines = response.data;
                })
                .catch(errors => console.log(errors));
            }
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
        saveTermination() {
            if (!confirm('Are you sure you want to terminate this business?')) {
                return;
            }
            axios
            .post('/api/businesses/' + this.inspection.business_id + '/terminate', {
                reason: this.terminateForm.reason,
                terminated_on: this.formatDate(this.terminateForm.terminated_on),
            })
            .then(response => {
                alert('business terminated successfully.');
            })
            .catch(errors => console.log(errors));
        },
        getInspection() {
            if (this.hasPermission('api.inspections.index')) {
                axios
                .get('/api/gradinginspections/' + this.inspectionId)
                .then(response => {
                    this.setFromModel(response.data);
                })
                .catch(errors => console.log(errors));
            }
        },
        setFromModel(data) {
            this.inspection = data;
            this.item = this.inspection.follow_up_inspection
            this.business = this.inspection.business;
            this.isFollowUpRequired = this.inspection.is_followup_required;
            this.isFined = this.inspection.is_fined;

            this.enableHandover = (this.inspection.report_handed_over_at) ? true : false;

            if(this.inspection.fine) {
                this.fineForm.amount = this.inspection.fine.amount;
                this.fineForm.fined_on = new Date(this.inspection.fine.fined_on);
                this.fineForm.paid_on = new Date(this.inspection.fine.paid_on);
                this.fineForm.is_paid = this.inspection.fine.is_paid;
                this.fineForm.receipt_no = this.inspection.fine.receipt_no;
            } else {
                this.fineForm.amount = null;
                this.fineForm.fined_on = new Date();
                this.fineForm.paid_on = new Date();
                this.fineForm.is_paid = false;
                this.fineForm.receipt_no = null;
            }

            this.pageLoaded = true;
        },
        toggleEditItemMode(item) {
            this.editMode = !this.editMode;
            if (item.id != this.inspectionForm2.inspection_id) {
                this.editMode = true;
            }
            if (this.editMode) {
                var date = new Date(item.inspection_at);
                this.inspectionForm2.date = date;
                this.inspectionForm2.time =  date;
                this.inspectionForm2.type =  item.type;
                this.inspectionForm2.reason =  item.reason;
                this.inspectionForm2.remarks =  item.remarks;
                this.inspectionForm2.status =  item.status;
                this.inspectionForm2.inspection_id = item.id;
            }
        },
        updateInspection() {
            axios.patch('/api/gradinginspections/' + this.inspectionForm2.inspection_id, {
                'inspection_at': this.buildDateTimeString(),
                'status': this.inspectionForm2.status,
                'reason': this.inspectionForm2.reason,
                'remarks': this.inspectionForm2.remarks
                // 'is_followup': this.inspectionForm2.is_followup,
            }).then(response => {
                this.getInspection();
            })
            .catch(errors => console.log(errors));
        }
    }
}
</script>