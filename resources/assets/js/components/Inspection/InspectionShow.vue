<template>
<div v-can="'api.inspections.show'">
  <div class="columns">
    <div class="column is-fullwidth">
        <h1 class="title">
          Inspection
        </h1>
    </div>
  </div>
  
  <!-- Summary -->
  <div class="columns">
    <div class="column">
      <table class="table">
        <tr>
          <td class="is-primary">Summary</td>
          <td class="is-primary">
            <div class="is-pulled-right">
              <edit-inspection-modal :inspection="inspection" @refresh="getInspection()"></edit-inspection-modal>
              <a class="button is-dark is-small" v-can="'api.inspections.destroy'" @click="deleteInspection()">
                <b-icon type="is-danger" size="is-small" pack="fas" icon="close"></b-icon>
                <span>Delete</span>
              </a>
            </div>
          </td>
        </tr>
        <tr>
          <td><div class="label">Establishment:</div>
            <span>{{establishmentText}}</span>
            <a class="button is-small" v-can="'api.businesses.show'" @click="goToBusinessProfile()">
              <b-icon type="is-success" size="is-small" pack="fas" icon="eye"></b-icon>
            </a>
          </td>
          <td><div class="label">At:</div> {{inspection.inspection_at}}</td>
        </tr>
        <tr>
          <td><div class="label">Type/Reason:</div> {{inspection.inspection_type_reason}}{{inspection.is_graded ? ' (graded)' : null}}</td>
          <td><div class="label">Status:</div> {{inspection.state}} / {{inspection.inspector ? 'assignee: ' + inspection.inspector.name + '(' + inspection.inspector.id + ')' : 'not assigned'}}</td>
        </tr>
      </table>
    </div>
  </div>
  
  <!-- Related Documents -->
  <div class="columns">
    <div class="column">
      <table class="table">
        <tr>
          <td colspan="2" class="is-primary">Related Documents</td>
          <!-- <td></td> -->
        </tr>
        <tr v-if="inspection.application_id && can('api.applications.show')">
          <td>Application</td>
          <td>
            <div class="is-pulled-right">
              <router-link class="button is-small" v-can="'api.applications.show'" :to="{ name: 'applications.show', params: { applicationId: application.id }}">
                <b-icon type="is-success" size="is-small" pack="fas" icon="eye"></b-icon>
              </router-link>
              <router-link class="button is-small" v-can="'api.applications.process'" :to="{ name: 'applications.process', params: { applicationId: application.id }}"
                v-if="application.status == 'pending'"
              >
                <b-icon type="is-warning" size="is-small" pack="fas" icon="gear"></b-icon>
              </router-link>
              <router-link class="button is-small" :to="{ name: 'applications.edit', params: { applicationId: application.id }}"
                v-if="application.status == 'draft' && can('api.applications.update')"
              >
                <b-icon type="is-warning" size="is-small" pack="fas" icon="edit"></b-icon>
              </router-link>
              <a class="button is-small" v-if="application.status == 'draft' && can('api.applications.destroy')" @click="deleteApplication()">
                <b-icon type="is-danger" size="is-small" pack="fas" icon="close"></b-icon>
              </a>
            </div>
          </td>
        </tr>
        <tr v-if="inspection.complaint_id && complaint">
          <td>Complaint</td>
          <td>
            <div class="is-pulled-right">
              <complaint-view-modal :complaint="complaint"></complaint-view-modal>
            </div>
          </td>
        </tr>
        <tr>
          <td>Checklist</td>
          <td>
            <div class="is-pulled-right">
              <a class="button is-small" v-if="inspection.normal_form_id && can('api.normal-inspections.normalforms.show')" @click="goToChecklistView()">
                <b-icon type="is-success" size="is-small" pack="fas" icon="eye"></b-icon>
              </a>
              <a class="button is-small" v-if="isUser(inspection.inspector_id) && inspection.state=='scheduled' && can('api.inspections.changedStatusToOngoing')" @click="startFillingChecklist()">
                <b-icon type="is-success" size="is-small" pack="fas" icon="play"></b-icon>
                <span>Start Filling</span>
              </a>
              <a 
              class="button is-small" 
              v-if="isUser(inspection.inspector_id) && inspection.normal_form_id && ~['started', 'ongoing'].indexOf(inspection.state) && can('api.normal-forms.update')" 
              @click="goToChecklistEditView()"
              >
                <b-icon type="is-warning" size="is-small" pack="fas" icon="edit"></b-icon>
              </a>
              <a 
              class="button is-small"
              v-if="inspection.normal_form_id && inspection.state=='completed' && checklist.status=='pending' && can('api.normal-forms.sendBackToEditing')" 
              @click="sendChecklistBackToEditing()"
              >
                <b-icon type="is-warning" size="is-small" pack="fas" icon="undo"></b-icon>
                <span>Send Back to Editing</span>
              </a>
<!--               <a class="button is-small" v-can="'api.normal-forms.destroy'" v-if="" @click="deleteChecklist()">
                <b-icon type="is-danger" size="is-small" pack="fas" icon="close"></b-icon>
              </a> -->
            </div>
          </td>
        </tr>
        <tr>
          <td>Dhivehi Report</td>
          <td>
            <div class="is-pulled-right" v-if="checklist &&  ~['pending','processed','completed'].indexOf(checklist.status)">
              <a 
              class="button is-small" 
              v-if="inspection.dhivehi_report_id && can('api.inspections.dhivehi-reports.show')"
              @click="goToDhivehiReportView()"
              >
                <b-icon type="is-success" size="is-small" pack="fas" icon="eye"></b-icon>
              </a>
              <a 
              class="button is-small" 
              v-if="isUser(inspection.inspector_id) && !inspection.dhivehi_report_id && checklist.status == 'pending' && can('api.dhivehi-reports.update')"
              @click="generateDhivehiReport()"
              >
                <b-icon type="is-success" size="is-small" pack="fas" icon="play"></b-icon>
                <span>Generate Report</span>
              </a>
              <a 
              class="button is-small" 
              v-if="isUser(inspection.inspector_id) && inspection.dhivehi_report && inspection.dhivehi_report.status == 'draft' && can('api.dhivehi-reports.update')"
              @click="goToDhivehiReportEditView()"
              >
                <b-icon type="is-warning" size="is-small" pack="fas" icon="edit"></b-icon>
              </a>
              <a 
              class="button is-small" 
              v-if="isUser(inspection.inspector_id) && inspection.dhivehi_report && inspection.dhivehi_report.status == 'draft' && can('api.dhivehi-reports.sendForProcessing')"
              @click="sendDhivehiReportForApproval()"
              >
                <b-icon type="is-success" size="is-small" pack="fas" icon="play"></b-icon>
                <span>Send For Approval</span>
              </a>
              <a 
              class="button is-small" 
              v-if="inspection.dhivehi_report && inspection.dhivehi_report.status == 'pending' && can('api.dhivehi-reports.changedStatusToProcessed')"
              @click="approveDhivehiReport()"
              >
                <b-icon type="is-success" size="is-small" pack="fas" icon="file-signature"></b-icon>
                <span>Approve</span>
              </a>
              <a 
              class="button is-small" 
              v-if="inspection.dhivehi_report && inspection.dhivehi_report.status == 'pending' && can('api.dhivehi-reports.sendBackToEditing')"
              @click="sendDhivehiReportBackToEditing()"
              >
                <b-icon type="is-warning" size="is-small" pack="fas" icon="undo"></b-icon>
                <span>Send Back to Editing</span>
              </a>
              <a 
              class="button is-small" 
              v-if="inspection.dhivehi_report && inspection.dhivehi_report.status == 'processed' && can('api.dhivehi-reports.issueReport')"
              @click="handoverDhivehiReport()"
              >
                <b-icon type="is-success" size="is-small" pack="fas" icon="file-invoice"></b-icon>
                <span>Handover</span>
              </a>
<!--               <a 
              class="button is-small" 
              v-if="inspection.dhivehi_report && inspection.dhivehi_report.status == 'draft'"
              @click="deleteDhivehiReport()"
              >
                <b-icon type="is-danger" size="is-small" pack="fas" icon="close"></b-icon>
              </a> -->
            </div>
          </td>
        </tr>
        <tr>
          <td>English Report</td>
          <td>
            <div class="is-pulled-right" v-if="checklist &&  ~['pending','processed','completed'].indexOf(checklist.status)">
              <a 
              class="button is-small"
              v-if="inspection.english_report_id && can('api.english-reports.show')"
              @click="goToEnglishReportView()">
                <b-icon type="is-success" size="is-small" pack="fas" icon="eye"></b-icon>
              </a>
              <a 
              class="button is-small" 
              v-if="isUser(inspection.inspector_id) && !inspection.english_report_id && checklist.status == 'pending' && can('api.english-reports.update')"
              @click="generateEnglishReport()">
                <b-icon type="is-success" size="is-small" pack="fas" icon="play"></b-icon>
                <span>Generate Report</span>
              </a>
              <a 
              class="button is-small" 
              v-if="isUser(inspection.inspector_id) && inspection.english_report && inspection.english_report.status == 'draft' && can('api.english-reports.update')"
              @click="goToEnglishReportEditView()">
                <b-icon type="is-warning" size="is-small" pack="fas" icon="edit"></b-icon>
              </a>
              <a 
              class="button is-small" 
              v-if="isUser(inspection.inspector_id) &&  inspection.english_report && inspection.english_report.status == 'draft' && can('api.english-reports.sendForProcessing')"
              @click="sendEnglishReportForApproval()"
              >
                <b-icon type="is-success" size="is-small" pack="fas" icon="play"></b-icon>
                <span>Send For Approval</span>
              </a>
              <a 
              class="button is-small" 
              v-if="inspection.english_report && inspection.english_report.status == 'pending' && can('api.english-reports.changedStatusToProcessed')"
              @click="approveEnglishReport()"
              >
                <b-icon type="is-success" size="is-small" pack="fas" icon="file-signature"></b-icon>
                <span>Approve</span>
              </a>
              <a 
              class="button is-small" 
              v-if="inspection.english_report && inspection.english_report.status == 'pending' && can('api.english-reports.sendBackToEditing')"
              @click="sendEnglishReportBackToEditing()"
              >
                <b-icon type="is-warning" size="is-small" pack="fas" icon="undo"></b-icon>
                <span>Send Back to Editing</span>
              </a>
              <a 
              class="button is-small" 
              v-if="inspection.english_report && inspection.english_report.status == 'processed' && can('api.english-reports.issueReport')"
              @click="handoverEnglishReport()"
              >
                <b-icon type="is-success" size="is-small" pack="fas" icon="file-invoice"></b-icon>
                <span>Handover</span>
              </a>
<!--               <a 
              class="button is-small" 
              v-if="inspection.english_report && inspection.english_report.status == 'draft'"
              @click="deleteEnglishReport()"
              >
                <b-icon type="is-danger" size="is-small" pack="fas" icon="close"></b-icon>
              </a> -->
            </div>
          </td>
        </tr>
      </table>
    </div>
  </div>

  <!-- Actions -->
  <div class="columns"
    v-if="(license || followupInspection || fines.length>0 || termination) || (
          inspection && inspection.state == 'completed' &&
           (
            (inspection.english_report) ? inspection.english_report.status != 'processed' : 
              (
                (inspection.dhivehi_report) ? inspection.dhivehi_report.status != 'processed' : true
              )
           )
          )
        "
  >
    <div class="column">
      <table class="table">
        <tr v-show="modals.isScheduleNewInspectionFormOpened">
          <td colspan="2">
            <inspection-form-inline @formPosted="getInspection" :parentInspectionId="inspectionId"></inspection-form-inline>
          </td>
        <tr>
        <tr v-show="modals.isAddNewFineFormOpened">
          <td colspan="2">
            <fine-form-inline @formPosted="getInspection" :inspectionId="inspectionId"></fine-form-inline>
          </td>
        <tr>
          <td class="is-primary">Actions</td>
          <td class="is-primary" v-if="inspection && inspection.state == 'completed' && checklist.status == 'pending' &&
           (!inspection.dhivehi_report_id && !inspection.english_report_id)
           ">
            <div class="is-pulled-right" v-if="isUser(inspection.inspector_id)">
              <issue-license-modal 
                v-if="!inspection.is_graded && inspection.application_id && can('api.applications.licenses.store')"
                :inspection="inspection" 
                @refresh="getInspection"
                >
              </issue-license-modal>
              <a class="button is-dark is-small" @click="openScheduleFollowupModal()" v-if="!inspection.is_graded && can('api.inspections.followupinspections.store')">
                <b-icon type="is-warning" size="is-small" pack="fas" icon="clock"></b-icon>
                <span>Schedule Followup</span>
              </a>
              <a class="button is-dark is-small" @click="openNewFineModal()" v-if="!inspection.is_graded && can('api.inspections.fines.store')">
                <b-icon type="is-warning" size="is-small" pack="fas" icon="ban"></b-icon>
                <span>Fine</span>
              </a>
              <close-establishment-modal :business="business" :inspection="inspection" @refresh="getInspection"></close-establishment-modal>
            </div>
          </td>
        </tr>
        <!-- Geading -->
        <tr 
          v-if="inspection.is_graded &&
            inspection.normal_form_id &&
            can('api.normal-forms.gradings') &&
             ~['pending','processed','completed'].indexOf(checklist.status)
          ">
          <td colspan="2" class="is-dark">
            <div class="columns">
              <div class="column">
                <table class="table">
                  <tr>
                    <td colspan="2" v-bind:class="[getGradngColor(gradingCalculated.grade)]">Grading</td>
                    <td v-bind:class="[getGradngColor(gradingCalculated.grade)]">
                      <div class="is-pulled-right">
                        <upload-file-modal 
                          :title="'Upload Grading Certificate'"
                          :is_type_required="false"
                          :permission="'uploads.inspections.grading-certificate'"
                          :uri="gradingCertificateUploadUrl()"
                          @refresh="getInspection()"></upload-file-modal>
                        <a v-if="inspection.grading_certificate_path && can('inspections.grading-certificate.show')" class="button is-success is-small" target="_blank" 
                          :href="'/inspections/'+inspection.id+'/grading/certificate'"><b-icon icon="eye"></b-icon></a>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="3">
                      <grading-table :gradingCalculated="gradingCalculated"></grading-table>
                    </td>
                  </tr>

                </table>
              </div>
            </div>
          </td>
        </tr>
        <!-- License -->
        <tr v-if="license && license.id && can('licenses.receipt.show')">
          <td colspan="2" class="is-dark">
            <div class="columns">
              <div class="column">
                <table class="table">
                  <tr>
                    <td class="is-success">License</td>
                    <td class="is-success"></td>
                    <td class="is-success">
                      <div class="is-pulled-right">
                        <a v-if="license.hard_copy_path && can('licenses.hardcopy.show')" class="button is-dark is-small" target="_blank" 
                          :href="'/licenses/' + license.id + '/hardcopy'">
                          <b-icon type="is-success" size="is-small" pack="fas" icon="eye"></b-icon>
                          <span> Hardcopy</span>
                        </a>
                        <upload-file-modal 
                          :title="'Upload License Hardcopy'"
                          :is_type_required="false"
                          :permission="'uploads.licenses.hardcopy'"
                          :uri="'/uploads/licenses/' + license.id + '/hardcopy'"
                          @refresh="getInspection()"></upload-file-modal>
                        <pay-license-modal :license="license" v-if="!license.is_paid" @refresh="getInspection()"></pay-license-modal>
                        <a class="button is-small" @click="deleteLicense()" v-if="!license.is_paid && can('api.licenses.destroy')">
                          <b-icon type="is-danger" size="is-small" pack="fas" icon="close"></b-icon>
                        </a>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><b>number:</b> {{license.license_no}}</td>
                    <td><b>issued date:</b> {{dateOnly(license.issued_at)}}</td>
                    <td v-if="license.is_paid"><b>paid on:</b> {{license.paid_on}}(
                      <a  target="_blank" :href="'/licenses/'+license.id +'/receipt'">
                        {{license.receipt_no}}
                      </a>)
                    </td>
                    <td v-if="!license.is_paid"><b>paid on:</b> NA</td>
                  </tr>
                  <tr>
                    <td><b>type:</b> {{license.license_application_type}}</td>
                    <td><b>expiry date:</b> {{dateOnly(license.expire_at)}}</td>
                    <td><b>amount(mvr):</b> {{license.amount}}</td>
                  </tr>
                </table>
              </div>
            </div>
          </td>
        </tr>
        <!-- Followup Inspection -->
        <tr v-if="followupInspection && followupInspection.id && can('api.inspections.show')">
          <td colspan="2" class="is-dark">
            <div class="columns">
              <div class="column">
                <table class="table">
                  <tr>
                    <td class="is-warning">Followup Inspection</td>
                    <td class="is-warning">
                      <div class="is-pulled-right">
                        <a class="button is-small" v-can="'api.followupinspections.destroy'" @click="deleteFollowup()">
                          <b-icon type="is-danger" size="is-small" pack="fas" icon="close"></b-icon>
                        </a>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><b>inspection at:</b> {{followupInspection.inspection_at}}</td>
                    <td><b>state:</b> {{followupInspection.state}}</td>
                  </tr>
                </table>
              </div>
            </div>
          </td>
        </tr>
        <!-- Fines -->
        <tr v-if="fines.length>0 && can('fines.receipt.show')">
          <td colspan="2" class="is-dark">
            <div class="columns">
              <div class="column">
                <table class="table">
                  <tr>
                    <td colspan="5" class="is-warning">Fines</td>
                  </tr>
                  <template  v-for="fine in fines">
                    <tr>
                      <td colspan="5" class="dhivehi">
                        <span class="pull-right is-fullwidth">{{fine.fine_type.description}} {{(fine.remarks) ? '('+fine.remarks+')' : null}}</span>
                      </td>
                    </tr>
                    <tr>
                      <td><b>slip:</b><a  target="_blank" :href="'/fines/'+fine.id +'/slip'">
                          {{fine.fine_slip_no}}
                        </a>
                      </td>
                      <td><b>amount(mvr):</b> {{fine.amount}}</td>
                      <td><b>fined on:</b> {{fine.fined_on}}</td>
                      <td v-if="fine.is_paid"><b>paid on:</b> {{fine.paid_on}}(
                        <a  target="_blank" :href="'/fines/'+fine.id +'/receipt'">
                          {{fine.receipt_no}}
                        </a>)
                      </td>
                      <td v-if="!fine.is_paid"></td>
                      <td>
                        <div class="is-pulled-right">
                          <pay-fine-modal :fine="fine" v-if="!fine.is_paid" @refresh="getInspection()"></pay-fine-modal>
                          <a class="button is-small" v-if="!fine.is_paid && can('api.fines.destroy')" @click="deleteFine(fine)">
                            <b-icon type="is-danger" size="is-small" pack="fas" icon="close"></b-icon>
                          </a>
                        </div>
                      </td>
                    </tr>
                  </template>
                </table>
              </div>
            </div>
          </td>
        </tr>
        <!-- Termination -->
        <tr v-if="termination && termination.id && can('api.businesses.show')">
          <td colspan="2" class="is-dark">
            <div class="columns">
              <div class="column">
                <table class="table">
                  <tr>
                    <td class="is-danger">Termination</td>
                    <td class="is-danger">
                      <div class="is-pulled-right">
                        <a class="button is-small" @click="deleteTermination()" v-can="'api.terminations.destroy'">
                          <b-icon type="is-danger" size="is-small" pack="fas" icon="close"></b-icon>
                        </a>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2"><b>on:</b> {{ termination.terminated_on }}</td>
                  </tr>
                  <tr>
                    <td><b>reason:</b> {{ termination.reason }}
                      {{termination.remarks ? ' (' + termination.remarks + ')' : null}}
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>
</template>


<script>
import InspectionFormInline from '../Common/InspectionFormInline';
import IssueLicenseModal from '../Common/IssueLicenseModal';
import FineFormInline from '../Common/FineFormInline';
import PayLicenseModal from '../Common/PayLicenseModal';
import PayFineModal from '../Common/PayFineModal';
import EditInspectionModal from '../Common/EditInspectionModal';
import ComplaintViewModal from '../Common/ComplaintViewModal';
import UploadFileModal from '../Common/UploadFileModal';
import CloseEstablishmentModal from '../Common/CloseEstablishmentModal';
import GradingTable from '../Common/GradingTable';

export default {
  props: ['inspectionId'],
  components: {
    'issue-license-modal': IssueLicenseModal,
    'inspection-form-inline': InspectionFormInline,
    'fine-form-inline': FineFormInline,
    'close-establishment-modal': CloseEstablishmentModal,
    'pay-license-modal': PayLicenseModal,
    'pay-fine-modal': PayFineModal,
    'edit-inspection-modal': EditInspectionModal,
    'complaint-view-modal': ComplaintViewModal,
    'upload-file-modal': UploadFileModal,
    'grading-table': GradingTable,
  },
  data() {
    return {
      inspection: {
        application:{
          license:{}
        },
        complaint:{},
        business: {},
        dhivehi_report: {},
        english_report: {},
      },
      application: {},
      complaint: {},
      checklist: {},
      business: {},
      license: {},
      followupInspection: {},
      fines:[],
      termination: {},
      modals: {
        isIssueLicenseFormOpened: false,
        isScheduleNewInspectionFormOpened: false,
        isAddNewFineFormOpened: false,
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
  computed: {
    establishmentText: function () {
      return (this.business) ? this.business.name + '(' + this.business.registration_no + ')' : null;
    }
  },
  mounted() {
    this.getInspection();
  },
  methods: {
    getInspection() {
      if (this.hasPermission('api.inspections.show')) {
          axios
          .get('/api/inspections/' + this.inspectionId)
          .then(response => {
              this.setData(response.data);
          })
          .catch(errors => console.log(errors));
      }
    },
    setData(data) {
      this.inspection = data;
      this.business = this.inspection.business;
      if (this.inspection.application) {
        this.application = this.inspection.application;
        this.license = this.inspection.application.license;
      }
      if (this.inspection.complaint) {
        this.complaint = this.inspection.complaint;
      }
      this.fines = this.inspection.fines;
      this.followupInspection = this.inspection.follow_up_inspection;
      this.termination = this.inspection.termination;
      if (this.inspection.normal_form_id) {
        this.checklist = this.inspection.normal_form;
        this.getGradingsCalculated();
      }
    },
    /**Summary**/
    deleteInspection() {
      this.showMessage('to do');
    },

    goToBusinessProfile() {
      if (this.hasPermission('api.businesses.show')) {
        this.$router.push({name: 'businesses.show', params: {businessId: this.business.id}});
      }
    },
    /**Related Documents**/
    deleteApplication() {
      //v-can="'api.applications.destroy'" 
      //v-if="application.status == 'draft'"
      axios
      .delete('/api/applications/' + this.inspection.application_id)
        .then(response => {
          this.getInspection();
        })
        .catch(errors => {
          this.showMessage('Error deleting application!');
        });
    },
    /**Application**/
    //TODO
    /**Complaint**/
    //TODO
    /**Checklist**/
    goToChecklistView() {
      //v-can="'api.normal-inspections.normalforms.show'"
      this.$router.push({name: 'normal-inspections.normalforms.show', params: {inspectionId: this.inspectionId}})
    },
    startFillingChecklist() {
      //v-can="'api.inspections.changedStatusToOngoing'" 
      //v-if="inspection.state=='scheduled"
      axios
      .patch('/api/inspections/' + this.inspectionId + '/status/ongoing')
        .then(response => {
          this.goToChecklistEditView();
        })
        .catch(errors => {
          this.showMessage('unable to change status to ongoing!');
        });
    },
    goToChecklistEditView() {
      //v-can="'api.normal-forms.update'"
      //v-if="inspection.normal_form_id && inspection.state=='ongoing"
      this.$router.push({ name: 'normal-inspections.normalforms.edit', params: { inspectionId: this.inspectionId } });
    },
    sendChecklistBackToEditing() {
      if (confirm("sending checklist to edit mode will delete any report attached to it. are you sure?")) {
        //v-can="'api.normal-forms.sendBackToEditing'"  
        //v-if="inspection.normal_form_id && inspection.state=='completed'"
        //TODO when sent back to edit mode change inspection state to ongoing.
        axios
        .patch("/api/normalforms/" + this.inspection.normal_form_id  + "/status/draft")
        .then(response => {
          this.showMessage('checklist sent back to edit mode successfully. inspection state changed to ongoing.')
          this.getInspection();
        })
        .catch(error => {
          this.showMessage('error sending checklist back to edit mode.')
        });
      }
    },
    deleteChecklist() {
      this.showMessage();
      //checklist can be deleted when the inspection status is at scheduled/ongoing
      //checklist can be deleted when the checklist status is at draft
      //when a checklist is deleted change the inspection status back to scheduled
    },
    /**Dhivehi Report**/
    goToDhivehiReportView() {
      //v-can="'api.dhivehi-reports.show'"  
      this.$router.push({ name: 'inspections.dhivehi-reports.show', params: { inspectionId: this.inspectionId } })
      // this.$router.push({ name: 'inspections.dhivehi-reports.edit', params: { inspectionId: this.inspectionId } })
    },
    generateDhivehiReport() {
      if (confirm("reports should be generated after taking the actions, as information from actions are used in report. Are you sure you want to continue?")) {
        //v-can="'api.dhivehi-reports.update'"
        //v-if="inspection.dhivehi_report_id == null && ~['decision_made','finished'].indexOf(inspection.state)"
        this.$router.push({ name: 'inspections.dhivehi-reports.edit', params: { inspectionId: this.inspectionId } })
      }
    },
    goToDhivehiReportEditView() {
      //v-can="'api.dhivehi-reports.update'"  
      //v-if="inspection.dhivehi_report_id != null && ~['decision_made','finished'].indexOf(inspection.state)"
      this.$router.push({ name: 'inspections.dhivehi-reports.edit', params: { inspectionId: this.inspectionId } })
    },
    sendDhivehiReportForApproval() {
      //v-can="'api.dhivehi-reports.sendForProcessing'" 
      //v-if="inspection.dhivehi_report_id && inspection.dhivehi_report.status == 'draft'"
      axios
        .patch('/api/dhivehi/reports/'+ this.inspection.dhivehi_report_id +'/status/pending')
      .then(response => {
        this.showMessage('dhivehi report successfully sent for approval.')
        this.getInspection();
      }).catch(error => {
        this.showMessage('error sending dhivehi report for approval.')
      });
    },
    approveDhivehiReport() {
      //v-if="inspection.dhivehi_report_id && inspection.dhivehi_report.status == 'pending'" 
      //v-can="'api.dhivehi-reports.changedStatusToProcessed'"
      axios
      .patch("/api/dhivehi/reports/" + this.inspection.dhivehi_report_id  + "/status/processed")
      .then(response => {
        this.showMessage('dhivehi report approved successfully.')
        this.getInspection();
      })
      .catch(error => {
        this.showMessage('error approving dhivehi report.')
      });
    },
    handoverDhivehiReport() {
      //v-if="inspection.dhivehi_report_id && inspection.dhivehi_report.status == 'processed'" 
      //v-can="'api.dhivehi-reports.issueReport'"
      this.$router.push({name: 'dhivehi-reports.handover', params: { reportId: this.inspection.dhivehi_report_id }});
    },
    sendDhivehiReportBackToEditing() {
      //v-if="inspection.dhivehi_report_id && inspection.dhivehi_report.status == 'pending'  && ~['decision_made','finished'].indexOf(inspection.state)" 
      //v-can="'api.dhivehi-reports.sendBackToEditing'"
      axios
      .patch("/api/dhivehi/reports/" + this.inspection.dhivehi_report_id  + "/status/draft")
      .then(response => {
        this.showMessage('dhivehi report sent back to edit mode successfully.')
        this.getInspection();
      })
      .catch(error => {
        this.showMessage('error sending dhivehi report back to edit mode.')
      });
    },
    deleteDhivehiReport() {
      this.showMessage();
    },
    /**English Report**/
    goToEnglishReportView() {
      //v-can="'api.english-reports.show'"  
      this.$router.push({ name: 'english-reports.show', params: { reportId: this.inspection.english_report_id } })
    },
    generateEnglishReport() {
      if (confirm("reports should be generated after taking the actions, as information from actions are used in report. Are you sure you want to continue?")) {
        //v-can="'api.english-reports.update'"
        //v-if="inspection.english_report_id == null && ~['decision_made','finished'].indexOf(inspection.state)"
        this.$router.push({ name: 'inspections.english-reports.edit', params: { inspectionId: this.inspectionId } })
      }
    },
    goToEnglishReportEditView() {
      //v-can="'api.english-reports.update'"  
      //v-if="inspection.english_report_id != null && ~['decision_made','finished'].indexOf(inspection.state)"
      this.$router.push({ name: 'inspections.english-reports.edit', params: { inspectionId: this.inspectionId } })
    },
    sendEnglishReportForApproval() {
      //v-can="'api.english-reports.sendForProcessing'" 
      //v-if="inspection.english_report_id && inspection.english_report.status == 'draft'"
      axios
        .patch('/api/english/reports/'+ this.inspection.english_report_id +'/status/pending')
      .then(response => {
        this.showMessage('english report successfully sent for approval.')
        this.getInspection();
      }).catch(error => {
        this.showMessage('error sending english report for approval.')
      });
    },
    approveEnglishReport() {
      //v-if="inspection.english_report_id && inspection.english_report.status == 'pending'" 
      //v-can="'api.english-reports.changedStatusToProcessed'"
      axios
      .patch("/api/english/reports/" + this.inspection.english_report_id  + "/status/processed")
      .then(response => {
        this.showMessage('english report approved successfully.')
        this.getInspection();
      })
      .catch(error => {
        this.showMessage('error approving english report.')
      });
    },
    handoverEnglishReport() {
      //v-if="inspection.english_report_id && inspection.english_report.status == 'processed'" 
      //v-can="'api.english-reports.issueReport'"
      this.$router.push({name: 'english-reports.handover', params: { reportId: this.inspection.english_report_id }});
    },
    sendEnglishReportBackToEditing() {
      //v-if="inspection.english_report_id && inspection.english_report.status == 'pending'  && ~['decision_made','finished'].indexOf(inspection.state)" 
      //v-can="'api.english-reports.sendBackToEditing'"
      axios
      .patch("/api/english/reports/" + this.inspection.english_report_id  + "/status/draft")
      .then(response => {
        this.showMessage('english report sent back to edit mode successfully.')
        this.getInspection();
      })
      .catch(error => {
        this.showMessage('error sending english report back to edit mode.')
      });
    },
    deleteEnglishReport() {
      this.showMessage();
    },
    /**Actions**/
    openScheduleFollowupModal() {
      this.modals.isScheduleNewInspectionFormOpened = !this.modals.isScheduleNewInspectionFormOpened;
      this.closeOthers('isScheduleNewInspectionFormOpened');
    },
    openNewFineModal() {
      this.modals.isAddNewFineFormOpened = !this.modals.isAddNewFineFormOpened;
      this.closeOthers('isAddNewFineFormOpened');
    },
    closeOthers(opened) {
      Object.keys(this.modals).forEach(key => {
        if (key != opened) {
          this.modals[key] = false;
        }
      });
    },
    /**Grading**/
    gradingCertificateUploadUrl() {
      if (this.inspection.is_graded) {
        return '/uploads/inspections/' +this.inspection.id+ '/grading/certificate';
      }

      return null;
    },
    getGradngColor(grade) {
      switch(grade) {
        case 'A':
          return 'has-background-success has-text-dark';
        case 'B':
          return 'is-purple has-text-dark';
        case 'C':
          return 'is-warning has-text-dark';
        case 'FAIL':
          return 'is-orange has-text-dark';
        default:
          return 'is-orange has-text-dark';
      }
    },
    getGradingsCalculated() {
      if (this.inspection.is_graded && this.hasPermission('api.normal-forms.gradings') && this.inspection.normal_form_id) {
         axios
          .get('/api/normalforms/' + this.inspection.normal_form_id + '/gradings')
            .then(response => {
                this.gradingCalculated = response.data;
            })
            .catch(errors => console.log(errors));
        }
    },
    /**License**/
    deleteLicense() {
      //v-can="'api.licenses.destroy'"
      axios
      .delete('/api/licenses/' + this.license.id)
      .then(response => {
          this.getInspection();
      })
      .catch(errors => {
          alert('Error deleting license:' + errors.response.data.message);
      }); 
    },
    /**Followup Inspection**/
    deleteFollowup() {
      //v-can="'api.followupinspections.destroy'"
      axios
      .delete('/api/followupinspections/' + this.inspectionId)
      .then(response => {
          this.getInspection();
      })
      .catch(errors => {
          alert('Error deleting follow up inspection: ' + errors.response.data.message);
      }); 
    },
    /**Fines**/
    openPayFineModal() {
      this.showMessage();
    },
    deleteFine(fine) {
      //v-can="'api.fines.destroy'"
      axios
      .delete('/api/fines/' + fine.id)
      .then(response => {
          this.getInspection();
      })
      .catch(errors => {
          alert('Error deleting fine:' + errors.response.data.message);
      }); 
    },
    /**Termination**/
    deleteTermination() {
      //v-can="'api.terminations.destroy'"
      axios
      .delete('/api/terminations/' + this.termination.id)
      .then(response => {
          this.getInspection();
      })
      .catch(errors => {
          alert('Error deleting termination:' + errors.response.data.message);
      }); 
    },
    //ETC
    showMessage(message = 'TODO') {
      alert(message);
    }
  }
}
</script>

<style scoped>
  table.dhivehi td:not([align]), table.dhivehi th:not([align]) {
  text-align: right;
  }
</style>