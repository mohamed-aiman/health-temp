<template>
<div class="container" v-can="'api.grading-inspections.show'">
    <div class="columns">
      <div class="column is-fullwidth">
          <h1 class="title">
            Inspection Details
            <!-- 'Inspection of ' . inspection.business.name . ' (id:' . $inspection->id . ')' -->
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
                                <button class="button is-warning" @click="openNewFineForm()">Fine</button>
                                <button class="button is-danger" @click="openTerminateForm()">Terminate</button>
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
                                <a v-if="!item.is_paid" class="button is-warning"  @click="loadFineForm(item)">
                                    <span class="icon is-small">
                                  <i class="fa fa-edit"></i>
                                </span>
                              </a>
                                <a v-if="!item.is_paid" class="button is-danger" @click="deleteFine(item)">
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


            <div class="columns" v-if="editMode">
                <div class="column box">
                    <div class="columns">
                        <div class="column">
                          <div class="label is-normal">
                            <label class="label">Updating Inspection id: {{inspectionForm2.inspection_id}}</label>
                          </div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column">
                            <div class="field">
                              <label class="label">Status</label>
                                <div class="select">
                                  <select v-model="inspectionForm2.status">
                                    <option value="scheduled">Scheduled</option>
                                    <option value="finished">Finished</option>
                                    <option value="cancelled">Cancelled</option>
                                  </select>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field">
                                <template>
                                    <b-field label="Select a date">
                                        <b-datepicker
                                            placeholder="Click to select..."
                                            icon="calendar-today"
                                            @input="datePickerInput2"
                                            v-model="inspectionForm2.date">
                                        </b-datepicker>
                                    </b-field>
                                </template>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field">
                              <template>
                                    <b-field label="Select timepicker">
                                        <b-timepicker
                                            placeholder="Type or select a date..."
                                            icon="clock"
                                            editable
                                            @input="timePickerInput2"
                                            v-model="inspectionForm2.time">
                                        </b-timepicker>
                                    </b-field>
                                </template>
                            </div>
                        </div>
                        <div class="column" v-if="inspectionForm2.type">
                            <div class="field">
                              <label class="label">Type</label>
                                <div class="select">
                                  <select disabled v-model="inspectionForm2.type">
                                    <option value="1">New Registration</option>
                                    <option value="2">License Renewal</option>
                                  </select>
                                </div>
                            </div>
                        </div>
                        <div class="column" v-if="!inspectionForm2.type">
                            <div class="field">
                              <label class="label">Type</label>
                                <div class="select">
                                    <select v-model="inspectionForm2.reason">
                                        <option value="complaint" selected>Complaint</option>
                                        <option value="routine">Routine</option>
                                        <option value="unspecified">Unspecified </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field">
                              <label class="label">Remarks</label>
                                <div class="input control">
                                    <input type="text" placeholder="remarks" class="input" v-model="inspectionForm2.remarks">
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field">
                              <label class="label">&nbsp</label>
                              <div class="control">
                                <button class="button is-link" @click="updateInspection">Update Inspection</button>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <div class="columns">
                <div class="column">
                    <table class="table is-narrow is-bordered is-fullwidth">
                        <thead>
                            <tr>
                                <th colspan="7">
                                    <router-link  class="is-link" v-can="'api.grading-inspections.show'" :to="{ name: 'inspections.show', params: { inspectionId: inspection.id }}">
                                        Inspection Details
                                    </router-link>
                                </th>
                            </tr>
                            <tr>
                                <th>Id</th>
                                <th>Status</th>
                                <th>Type</th>
                                <th>Inspection At</th>
                                <th v-if="(inspection.follow_up_inspection) || (inspection.fines.length>0)">Tags</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{inspection.id}}</td>
                                <td>{{inspection.status}}</td>
                                <td v-if="!inspection.register_or_renew">{{inspection.reason}}</td>
                                <td v-if="inspection.register_or_renew">{{inspection.register_or_renew}}(<a target='_blank' :href="'/applications/' + inspection.application_id + '/process'">{{inspection.application_id}}</a>)</td>
                                <td>{{inspection.inspection_at}}</td>
                                <td v-if="(inspection.follow_up_inspection) || (inspection.fines.length>0)">
                                    <div class="tags">
                                        <div class="tag is-warning" v-if="inspection.follow_up_inspection">followup required({{inspection.follow_up_id}})</div>
                                        <div class="tag is-danger" v-if="inspection.fines.length>0">fined</div>
                                    </div>
                                </td>
                                <td>
                                  <p class="buttons">
                                    <router-link class="button is-info" v-can="'api.normal-forms.show'" :to="{ name: 'normal-forms.show', params: { normalFormId: inspection.normal_form_id }}">
                                      <span class="icon is-small">
                                        <i class="fa fa-eye"></i>
                                      </span>
                                      <span>Check List</span>
                                    </router-link>
                                    <button class="button is-warning is-success"
                                        @click="isComponentModalActive = true">
                                        Schedule a new Inspection
                                    </button>
                                    <a class="button is-warning" alt="dhivehi report" @click="toggleEditItemMode(inspection)">
                                        <span class="icon is-small">
                                          <i class="fa fa-edit"></i>
                                        </span>
                                    </a>
                                  </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <template>
                        <section>
                         <b-modal :active.sync="isComponentModalActive" has-modal-card>
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
                                                                <option value="complaint" selected>Complaint</option>
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

            <div class="columns">
                <div class="column">
                    <table class="table is-narrow is-bordered is-fullwidth">
                        <tr>
                            <th><div class="pull-left">Reports</div></th>
                        </tr>
                        <tr>
                            <td><div class="pull-left">Dhivehi Report</div>
                                <p class="buttons pull-right">
                                    <a class="button" v-bind:class="[(inspection.dhivehi_report_id == null) ? isWarning : isSuccess]" alt="dhivehi report" @click="gotToReport(inspection, 'dv')">
                                        <span class="icon is-small">
                                          <i class="fa fa-eye"></i>
                                        </span>
                                    </a>
                                    <router-link class="button is-warning" v-can="'api.dhivehi-reports.issueReport'" :to="{ name: 'dhivehi-reports.handover', params: { reportId: inspection.dhivehi_report_id }}">
                                        <span class="icon is-small">
                                          <i class="fa fa-handshake"></i>
                                        </span>
                                        <span>Handover</span>
                                    </router-link>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td><div class="pull-left">English Report</div>
                                <p class="buttons pull-right">
                                    <a class="button" v-bind:class="[(inspection.english_report_id == null) ? isWarning : isSuccess]" alt="english report" @click="gotToReport(inspection,'en')">
                                        <span class="icon is-small">
                                          <i class="fa fa-eye"></i>
                                        </span>
                                    </a>
                                    <router-link class="button is-warning" v-can="'api.english-reports.issueReport'" :to="{ name: 'english-reports.handover', params: { reportId: inspection.english_report_id }}">
                                        <span class="icon is-small">
                                          <i class="fa fa-handshake"></i>
                                        </span>
                                        <span>Handover</span>
                                    </router-link>
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <template id="followup-inspection" v-if="inspection.follow_up_inspection">
                <div class="columns">
                        <div class="column">
                            <table class="table is-narrow is-bordered is-fullwidth">
                                <thead>
                                    <tr>
                                        <th colspan="7">
                                            <router-link class="is-link" v-can="'api.grading-inspections.show'" :to="{ name: 'inspections.show', params: { inspectionId: inspection.follow_up_inspection }}">
                                                Followup Inspection
                                            </router-link>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Id</th>
                                        <th>Status</th>
                                        <th>Type</th>
                                        <th>Inspection At</th>
                                        <th v-if="inspection.follow_up_inspection.follow_up_id">Follow Up</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <router-link v-can="'api.grading-inspections.show'" :to="{ name: 'inspections.show', params: { inspectionId: item.follow_up_id }}">
                                                {{inspection.follow_up_inspection.id}}
                                            </router-link>
                                        </td>
                                        <td>{{inspection.follow_up_inspection.status}}</td>
                                        <td v-if="!inspection.follow_up_inspection.register_or_renew">{{inspection.follow_up_inspection.reason}}</td>
                                        <td v-if="inspection.follow_up_inspection.register_or_renew">{{inspection.follow_up_inspection.register_or_renew}}(<a target='_blank' :href="'/applications/' + inspection.follow_up_inspection.application_id + '/process'">{{inspection.follow_up_inspection.application_id}}</a>)</td>
                                        <td>{{inspection.follow_up_inspection.inspection_at}}</td>
                                        <td v-if="inspection.follow_up_inspection.follow_up_id">
                                            <router-link v-can="'api.grading-inspections.show'" :to="{ name: 'inspections.show', params: { inspectionId: inspection.follow_up_inspection.follow_up_id }}">
                                                {{inspection.follow_up_inspection.follow_up_id}}
                                            </router-link>
                                        </td>
                                        <td>
                                            <p class="buttons pull-right">
                                              <a class="button" v-bind:class="[(inspection.follow_up_inspection.dhivehi_report_id == null) ? isWarning : isSuccess]" alt="dhivehi report" @click="gotToReport(inspection, 'dv')">
                                                <span class="icon is-small">
                                                  <i class="fa fa-book"></i>
                                                </span>
                                                <span>Dv</span>
                                              </a>
                                              <a class="button" v-bind:class="[(inspection.follow_up_inspection.english_report_id == null) ? isWarning : isSuccess]" alt="english report" @click="gotToReport(inspection,'en')">
                                                <span class="icon is-small">
                                                  <i class="fa fa-book"></i>
                                                </span>
                                                <span>En</span>
                                              </a>
                                              <router-link class="button is-info" v-can="'api.normal-forms.show'" :to="{ name: 'normal-forms.show', params: { normalFormId: item.follow_up_inspection.normal_form_id }}">
                                                <span class="icon is-small">
                                                  <i class="fa fa-eye"></i>
                                                </span>
                                                <span>Check List</span>
                                              </router-link>
                                              <a class="button is-danger" @click="deleteFollowUpInspection()">
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

    <template id="applications" v-if="inspection.application != null">
        <div class="box">
            <div class="columns">
                <div class="column">
                    <table class="table is-narrow is-bordered is-fullwidth">
                        <thead>
                            <tr>
                                <th colspan="6">
                                    <router-link v-can="'api.applications.show'" class="is-link" :to="{ name: 'applications.show', params: { applicationId: inspection.application_id }}">
                                        Application Details
                                    </router-link>
                                </th>

                            </tr>
                            <tr>
                                <th>Id</th>
                                <th>Permit Type</th>
                                <th>Status</th>
                                <th>Register/Renew</th>
                                <th>Added On</th>
                                <th>Updated On</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{inspection.application_id}}</td>
                                <td>{{inspection.application.permit_type}}</td>
                                <td>{{inspection.application.status}}</td>
                                <td>{{inspection.application.register_or_renew}}</td>
                                <td>{{inspection.application.created_at}}</td>
                                <td>{{inspection.application.updated_at}}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6" class="center">
                                    <template v-if="inspection.application.register_or_renew != null">
                                        <button class="button is-warning" v-if="inspection.application._1toRegisterPlace" @click="isIssueLicenseFormOpen = !isIssueLicenseFormOpen">Edit/Issue a New License</button>
                                        <button class="button is-warning" v-if="inspection.application._1toRenewLicense" @click="isIssueLicenseFormOpen = !isIssueLicenseFormOpen">Edit/Renew License</button>
                                    </template>
                                </td>
                            </tr>
                            <tr v-if="isIssueLicenseFormOpen">
                                <td colspan="6">
                                    <div class="columns">
                                <div class="column"><div class="field">Issued Date: <b-datepicker placeholder="Click to select..." icon="calendar-today" editable v-model="issueLicenseForm.issued_date"></b-datepicker></div></div>
                                <div class="column"><div class="field">Expiry Date: <b-datepicker placeholder="Click to select..." icon="calendar-today" editable v-model="issueLicenseForm.expiry_date"></b-datepicker></div></div>
                                <div class="column">
                                    <div class="field">License No:
                                                <div class="control">
                                                    <input type="text" placeholder="license_no" class="input" v-model="issueLicenseForm.license_no">
                                                </div>
                                            </div>
                                </div>
                                  <div class="column">
                                        <br>
                                        <p class="buttons">
                                                  <a class="button is-success"  @click="issueLicense()">
                                                    <span class="icon is-small">
                                                      <i class="fa fa-plus"></i>
                                                    </span>
                                                  </a>
                                                </p>
                                </div>
                              </div>
                            </td>
                        </tr>
                      </tfoot>
                    </table>
                    <table v-if="inspection.application.license" class="table is-narrow is-bordered is-fullwidth">
                        <tr>
                            <th colspan="4">Issued License</th>
                        </tr>
                        <tr>
                            <td>License No</td>
                            <td>Issued Date</td>
                            <td>Expiry Date</td>
                            <td>Type</td>
                        </tr>
                        <tr>
                            <td>{{inspection.application.license.license_no}}</td>
                            <td>{{inspection.application.license.issued_at}}</td>
                            <td>{{inspection.application.license.expire_at}}</td>
                            <td>{{inspection.application.license.register_or_renew}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </template>
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
            item: {},
            pageLoaded: false,
            isFollowUpRequired: '',
            isIssueLicenseFormOpen: false,
            isRenewLicenseFormOpen: false,
            isNewFineFormOpened: false,
            isTerminateFormOpened: false,
            isUpdateFineFormOpened: false,
            isComponentModalActive: false,
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
            }
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
        closeAll() {
            axios
            .patch('/api/inspections/'+gradingthis.inspection.id +'/close')
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
            .delete('/followupinspections/' + this.inspection.id)
            .then(response => {
                this.getInspection();
            })
            .catch(errors => {
                alert('Error deleting follow up inspection: ' + errors.response.data.message);
            }); 
        },
        deleteFine(item) {
            axios
            .delete('/fines/' + item.id)
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
            .patch('/fines/' + this.fineForm2.id, {
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
            .post('/inspections/' + this.inspectionId + '/fines', {
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
            axios
        .get('/api/gradinginspections/' + this.inspectionId + '/fines')
            .then(response => {
                this.fines = response.data;
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
        saveTermination() {
            if (!confirm('Are you sure you want to terminate this business?')) {
                return;
            }
            axios
            .post('/businesses/' + this.inspection.business_id + '/terminate', {
                reason: this.terminateForm.reason,
                terminated_on: this.formatDate(this.terminateForm.terminated_on),
            })
            .then(response => {
                alert('business terminated successfully.');
            })
            .catch(errors => console.log(errors));
        },
        getInspection() {
            axios
            .get('/api/gradinginspections/' + this.inspectionId)
            .then(response => {
                this.setFromModel(response.data);
            })
            .catch(errors => console.log(errors));
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
            axios.patch('/inspections/' + this.inspectionForm2.inspection_id, {
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