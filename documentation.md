#App Workflows

####Inspection Workflow
- Inspection is scheduled 
- Inspecting
	- checklist filled
- Decision making regarding inspection
	- terminate/fine/schdule followup inspection
- Generate reports
- Send documents for approval
- Approve/send documents back to editing(with rejected reason)
- Receiving payments
	- fines
	- registration fees
- Handover reports
- Handover license
	



#State Management of Entities

##Entities
- Application
- Inspection
- Checklist
- Dhivehi Report
- English Report

####Application

- Draft
- Pending
- Processed
- ~~Cancelled~~

####Inspection
- Scheduled
- Ongoing
- Cancelled
- Finished

####Checklist
- Draft
- Pending
- Processed
- ~~Cancelled~~

##Procedure

#####Scheduled
- when a new inspection is scheduled 

#####Cancelled
- if the inspection is cancelled

#####Finish
- when inspection and all related work is finsihed .  this is the last step 


####Inspection Workflow and related states
- Inspection is scheduled 
- Inspecting
	- filling checklist
- Decision making regarding inspection
	- terminate/fine/schdule followup inspection
- Generate reports
- Send documents for approval
- Approve/send documents back to editing(with rejected reason)
- Receiving payments
	- fines
	- registration fees
- Handover reports
- Handover license

#####Summary
- when a new inspection is scheduled
	-- create  an inspection with scheduled status 
- when the user starts inspection
	-- create a checklist with draft status
	-- change inspection status to filling_form
- when user finishes marking checklist(ie, inspection is finished)
	-- change checklist status to pending
	-- change inspection status to decision_made
- when user makes decisions regarding the inspection
       -- change inspection status to decision_made
- when user generates reports
      -- create a new dhivehi report with draft status
      -- create a new english report with draft status(if has application and if requested for english)
      -- change inspection status to reports_generated
- when inspection (reports, checklist, actions - all at once), sent for approval
      -- change checklist status to pending
      -- change dhivehi report to pending
      -- change english report to pending(if there is any)
      -- change inspection status to pending_approval
- when(if) the inspection (reports, checklist, actions - all at once) is approved
      -- change checklist status to processed
      -- change dhivehi report to processed
      -- change english report to processedif there is any)
      -- change inspection status to approved
- when(if) the inspection (reports, checklist, actions - all at once) is send back for editing
      -- change checklist status to draft
      -- change dhivehi report to draft
      -- change english report to draft (if there is any)
      -- change inspection status to back_to_editing
      
#####Corresponding Requests

- when a new inspection is scheduled [POST]/api/applications/{applicationId}/inspections
	-- create  an inspection with created state
- when the open the checklist link of inspection [GET] /api/normalinspections/{inspectionId}/normalforms
	-- create a checklist with draft status
- when the user starts filling form(ie. when clicked to fill checklist 
	-- change inspection state to filling_form [PATCH]/api/inspections/{inspection}/status/fillingform
	   (after this take user to edit route [GET] /normalinspections/{inspectionId}/normalforms/edit)
- when user finishes marking checklist(ie, inspection is finished)
	-- change checklist status to pending [PATCH] /api/normalforms/{normalFormId}/status/pending
	-- change inspection status to form_filled (fullfilled with the above request )
- (optional) when user goes to the decision making page
       -- change inspection state to decision_making
- when user makes decisions regarding the inspection
       -- change inspection status to decision_made
- when user generates reports
      -- create a new dhivehi report with draft status
      -- create a new english report with draft status(if has application and if requested for english)
      -- change inspection status to report_prepared
- when inspection (reports, checklist, actions - all at once), sent for approval
      -- change checklist status to pending
      -- change dhivehi report to pending
      -- change english report to pending(if there is any)
      -- change inspection status to pending_approval
- when(if) the inspection (reports, checklist, actions - all at once) is approved
      -- change checklist status to processed
      -- change dhivehi report to processed
      -- change english report to processedif there is any)
      -- change inspection status to approved
- when(if) the inspection (reports, checklist, actions - all at once) is send back for editing
      -- change checklist status to draft
      -- change dhivehi report to draft
      -- change english report to draft (if there is any)
      -- change inspection status to back_to_editing
      
   WIP
- when inspection reports are handed over
     -- change inspection state to reports_handed_over
- when inspection is finished
    -- change inspection state and status to finish (
- when payments and everyting is cleared
    -- change inspection state to cleared (licenses can be issued when cleared)
- when (license is issued/fines are paid/shutdown etc) inspection is closed
    -- change inspection state to closed (from here you wont be able to bring any changes)

- Regenerate reports from checklist



WIP next step is dhivehi report generate kurun..and normal form approve kurumah fonuvaa(normalforms/10/process)
















































....................

