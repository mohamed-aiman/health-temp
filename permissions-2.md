#Application
##Create Applications
###ApplicationCreate (applications.create)
api.applications.store //save application
api.applications.update or api.applications.show //redirect after creating

##Update Applications
###DraftApplications (applications.draft)
api.applications.draft //list data
api.applications.show  //link to view application (optional, cannot also used)
api.applications.update //edit application button (optional)
###ApplicationEdit (applications.edit)
api.applications.update 
api.applications.show
api.applications.destroy
api.businesses.search
api.businesses.show
api.applications.businesses.store
api.applications.sendForProcessing
api.applications.businesses.store
api.applications.businesses.attach
api.applications.businesses.detach

##Approve Applications
###PendingApplications
api.applications.pending
api.applications.process
api.applications.show
api.businesses.show
###ApplicationProcess
api.applications.process
api.applications.show
api.applications.sendBackToEditing
api.applications.inspections.store
api.inspections.destroy
<!-- api.inspections.update -->
api.businesses.show

##View All Applications
###AllApplications
api.applications.index
<!-- api.applications.updateStatus -->
api.applications.show
api.applications.update
api.applications.process

#Inspection
##UpcomingInspections
###UpcomingInspections
api.inspections.upcoming
api.inspections.update
api.businesses.show
api.inspections.show
api.normal-inspections.normalforms.show
api.applications.process

#Process Forms / Generate Reports
##Process Normal Forms
###PendingNormalForms
api.normal-forms.pending
api.normal-forms.changedStatusToProcessed

##Process Normal Form
###NormalFormProcess
api.normal-forms.changedStatusToProcessed
api.normal-forms.show
api.normal-forms.points
api.normal-forms.sendBackToEditing
api.inspections.close
api.dhivehi-reports.update
api.english-reports.update

##Process Grading Forms
###PendingGradingForms
api.grading-forms.pending
api.grading-forms.changedStatusToProcessed

##Process Grading Form
###GradingFormProcess
api.grading-forms.changedStatusToProcessed
api.grading-forms.show
api.grading-forms.points
api.grading-forms.sendBackToEditing
api.grading-inspections.close

###InspectionDhivehiReportEdit
api.dhivehi-reports.update
api.dhivehi-reports.sendForProcessing
api.dhivehi-reports.show
api.inspections.dhivehi-reports.show
api.dhivehi-reports.update
api.dhivehi-reports.form-points.store
api.dhivehi-reports.form-points.update
api.dhivehi-reports.form-points.destroy
api.dhivehi-reports.form-points.index

###DhivehiReportEdit
DONT THINK ITS USED ANYWHERE

###DhivehiReportShow
api.dhivehi-reports.show

###InspectionDhivehiReportShow
api.inspections.dhivehi-reports.show
api.dhivehi-reports.form-points.index

###InspectionEnglishReportEdit
api.english-reports.update
api.english-reports.sendForProcessing
api.inspections.english-reports.show
api.english-reports.critical.update
api.english-reports.major.update
api.english-reports.other.update

###EnglishReportShow
api.english-reports.show

###InspectionEnglishReportShow
DOES NOT EXIST


#Approve Normal Forms / Approve Reports
##Process Reports //Might have to skip this step and go directly to approving
###InspectionPendingReports
api.inspections.pending-reports
api.applications.show
api.normal-inspections.normalforms.show
api.dhivehi-reports.changedStatusToProcessed
api.english-reports.changedStatusToProcessed
api.inspections.show

###NormalInspectionNormalFormShow
api.normal-inspections.normalforms.show
api.normal-forms.update //optional menu button
api.normal-forms.points
api.inspections.changedStatusToOngoing

###NormalInspectionNormalFormEdit
api.normal-inspections.normalforms.show
api.normal-forms.points
api.normal-forms.form-points.valueChanged
api.normal-forms.form-points.notApplicableChanged
api.normal-forms.form-points.remarksChanged
api.normal-forms.update
api.normal-forms.sendForProcessing

###GradingInspectionFinish
	api.grading-inspections.show
	api.businesses.show
	api.inspections.fines.store
	api.businesses.terminate
	api.fines.update
	api.fines.destroy
	api.inspections.show
	api.applications.show
	api.normal-forms.show
	api.inspections.followupinspections.store
	api.dhivehi-reports.show
	api.english-reports.show
	api.followupinspections.destroy
	api.inspections.fines.index
	api.inspections.index

###DhivehiReportProcess
api.dhivehi-reports.changedStatusToProcessed
api.dhivehi-reports.show
api.dhivehi-reports.sendBackToEditing
api.dhivehi-reports.changedStatusToProcessed

###EnglishReportProcess
api.english-reports.show
api.english-reports.sendBackToEditing
api.english-reports.changedStatusToProcessed

#Handover Reports / Close Inspection

##Handover Reports Listing
###InspectionReportProcessedReports
api.inspections.processed-reports
api.dhivehi-reports.issueReport
api.english-reports.issueReport
api.inspections.close
api.applications.show //optional
api.normal-forms.show //optional

#FROM HERE JS PERMISSION IF NECESSARY
##Take Actions / Close Inspection
###InspectionFinish
api.inspections.close
api.inspections.show
api.businesses.show
api.inspections.fines.store
api.businesses.terminate
api.fine-types.index
api.fines.update
api.fines.destroy
api.inspections.show
api.applications.show
api.normal-forms.show
api.inspections.followupinspections.store
api.dhivehi-reports.show
api.english-reports.show
api.followupinspections.destroy
api.inspections.fines.index
api.inspections.index
api.inspections.decisionMade
####dhivehi-report-handover
api.dhivehi-reports.issueReport
uploads.dhivehi-reports.hardcopy
dhivehi-reports.hardcopy.show
####english-report-handover
api.english-reports.issueReport
uploads.english-reports.hardcopy
english-reports.hardcopy.show

###DhivehiReportHandover
api.dhivehi-reports.issueReport
api.dhivehi-reports.show
uploads.dhivehi-reports.hardcopy
dhivehi-reports.hardcopy.show

###EnglishReportHandover
api.english-reports.issueReport
api.english-reports.show
uploads.english-reports.hardcopy
english-reports.hardcopy.show

###BusinessApplicationCreate
api.applications.store
api.businesses.show
###BusinessCreate
NOT USED
###BusinessShow
api.businesses.show
api.businesses.update //optional
api.applications.store //optional
api.businesses.inspections.store //optional
api.businesses.complaints.store //optional
####business-inspections
api.businesses.show
api.inspections.destroy
applications.show
api.dhivehi-reports.update
api.english-reports.update
api.inspections.show
api.normal-inspections.normalforms.show
api.inspections.destroy
####business-details
api.businesses.show
TODO (other child components) WIP


##Dashboard
###ExpiringSoonBusinesses
api.businesses.expiringsoon


###EnglishReportCreate
NOT USED

###EnglishReportEdit
NOT USED

###AllFines
api.fines.index'

###GradingCategoriesManage
api.grading-categories.store
api.grading-categories.index
api.grading-categories.update

###GradingCategoryEdit
api.grading-categories.update
api.grading-categories.store
api.grading-categories.show
api.grading-categories.destroy
api.grading-categories.index

###UpcomingGradingInspections
api.grading-inspections.upcoming
api.grading-inspections.update
api.grading-inspections.gradingforms.show


###GradingInspectionGradingFormEdit
api.grading-forms.update
api.grading-forms.sendForProcessing
api.grading-forms.points
api.grading-inspections.gradingforms.show
api.grading-forms.form-points.valueChanged
api.grading-forms.form-points.notApplicableChanged

###GradingInspectionGradingFormShow
api.grading-inspections.gradingforms.show
api.grading-forms.points
api.grading-forms.gradings

###GradingPointEdit
api.grading-points.index
api.grading-points.update
api.grading-points.show
api.grading-points.destroy
api.grading-categories.select-options

###GradingPointsManage
api.grading-points.store
api.grading-categories.select-options
api.grading-points.update
api.grading-points.index

###AllInspections
api.inspections.index
api.inspections.show
api.applications.show
api.businesses.show
api.normal-inspections.normalforms.show
api.normal-forms.changedStatusToProcessed

###InspectionCreate
NOT USED

###InspectionShow
api.inspections.show
api.businesses.show
api.inspections.fines.store
api.businesses.terminate
api.fines.update
api.fines.destroy
uploads.fines.receipt
api.fines.pay
api.inspections.show
api.applications.show
api.normal-forms.show
api.inspections.followupinspections.store
api.dhivehi-reports.show
api.english-reports.show
api.followupinspections.destroy
api.inspections.fines.index
api.inspections.index
api.applications.licenses.store
api.licenses.pay
uploads.licenses.receipt
####dhivehi-report-handover
api.dhivehi-reports.issueReport
uploads.dhivehi-reports.hardcopy
dhivehi-reports.hardcopy.show
####english-report-handover
api.english-reports.issueReport
uploads.english-reports.hardcopy
english-reports.hardcopy.show

###AllLicenses
api.licenses.index
api.applications.show
api.businesses.show
licenses.receipt.show

###NormalCategoryEdit
api.normal-categories.show
api.normal-categories.update
api.normal-categories.destroy
api.normal-categories.index

###NormalCategoriesManage
api.normal-categories.store
api.normal-categories.index

###NormalFormShow
api.normalforms.show
api.normal-forms.points
api.normal-forms.update //optional

###ProcessedNormalForms
api.normal-forms.processed
api.normal-forms.show
api.dhivehi-reports.update
api.english-reports.update
api.inspections.show

###NormalPointEdit
api.normal-points.index
api.normal-categories.select-options
api.normal-points.update
api.normal-points.show
api.normal-points.destroy

###NormalPointsManage
api.normal-points.store
api.normal-points.index
api.normal-categories.select-options

###AllTerminations
api.terminations.index
api.businesses.show

###AclDashboard
api.roles.store
api.roles.index
api.permissions.index
api.users.store
api.users.index
api.roles.update
api.roles.destroy

###UserEdit
api.users.show
api.users.update
api.users.roles.detach
api.users.roles.attach
api.users.roles.forcheckbox

###RoleEdit
api.roles.show
api.roles.update
api.roles.permissions.detach
api.roles.permissions.attach
api.roles.permissions.forcheckbox


###FineTypeManage
api.fine-types.store

REMEMBER TO SEE CHILD COMPONENTS