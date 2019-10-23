<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class SubRolesPermissionsTableSeeder extends Seeder
{
    protected $roleSubRoles = [
            'front_desk' => [ //level 1
                'create_application',
                'edit_application',
                'send_for_processing_application', //finish and send for scheduling inspection
                'see_all_applications',
                'see_application',
                'upload_application_documents',
                'delete_application_documents',
            ],
            'inspector' => [ //level 2
                'front_desk', //all permissions given to front_desk role included
                'see_assigned_inspections',
                'see_upcoming_inspections',
                'delete_inspection',
                'see_business',
                'see_application',
                'see_inspection_form',
                'start_inspection_form_filling',
                'edit_inspection_form',
                'send_inspection_form_back_for_editing',
                'see_reports',
                'generate_reports',
                'edit_reports',
                'send_reports_for_approval',
                'send_reports_back_for_editing',
                'hand_over_reports',
                'issue_update_license',
                'create_followup_inspection',
                'add_inspection_fine',
                'add_business_fine',
                'add_termination',
                'reopen_establishment',
                'see_license',
                'pay_license',
                'delete_license',
                'see_followup_inspection',
                'delete_followup_inspection',
                'see_fine',
                'pay_fine',
                'delete_fine',
                'delete_termination',
                'see_termination',
                'edit_business',
                'create_manual_inspections',
                'add_complaint',
                'see_complaints',
                'see_fines',
                'see_licenses',
                'see_terminations',
                'finish_filling_inspection_form',
                'see_all_inspections',
                'upload_grading_certificate',
                'see_grading_certificate',
                'pay_fee',
                'see_fee',
                'add_business_fee',
            ],
            'supervisor' => [ //level 3
                'inspector',
                'edit_inspection',
                'schedule_inspection', //schedule inspection, send back for editing
                'approve_reports',
            ],
            'head' => [ //level 4
                'supervisor',
            ],
        ];

    protected $subRolePermissions = [
            'create_application' => [
                'api.applications.store', //ApplicationCreate page access
                'api.applications.show',
                'api.applications.update', //optional
            ],
            'edit_application' => [
                'api.applications.update',//ApplicationEdit page access
                'api.applications.show',
                'api.businesses.show',
                'api.businesses.search',
                'api.applications.businesses.store', //optional
                'api.applications.businesses.attach', //optional
                'api.applications.businesses.detach', //optional
                'api.applications.draft',
            ],
            'upload_application_documents' => [
                'applications.documents.store',
            ],
            'delete_application_documents' => [
                'api.applications.documents.destroy',
            ],
            'send_for_processing_application' => [
                'api.applications.show',
                'api.applications.sendForProcessing'
            ],
            'delete_application' => [
                'api.applications.show',
                'api.applications.destroy',
            ],
            'schedule_inspection' => [ //inspection scheduling
                'api.applications.process', //ApplicationProcess page access
                'api.applications.show',
                'api.businesses.show',
                'api.applications.pending', //PendingApplications page access
                'api.applications.sendBackToEditing',
                'api.applications.inspections.store',
                'api.inspectors.index',
                // 'api.inspections.destroy', //optional
            ],
            'see_all_applications' => [
                'api.applications.index', //AllApplications page access
            ],
            'see_assigned_inspections' => [
                'api.inspections.my'
            ],
            'see_upcoming_inspections' => [
                'api.inspections.show',
                'api.inspections.upcoming', //UpcomingInspection page access
                'api.businesses.show',
            ],
            //InspectionShow page start
            'see_application' => [
                'api.applications.show',
                'api.applications.documents.index',
                'api.applications.documents.show',
            ],
            'edit_inspection' => [ //for supervisors, as it updates inspection_at and inspector_id
                'api.inspections.update',
                'api.inspectors.index',
            ],
            'delete_inspection' => [
                'api.inspections.destroy',
            ],
            'see_business' => [
                'api.businesses.show',
            ],
            'see_inspection_form' => [
                'api.normal-inspections.normalforms.show',
                'api.normal-forms.points',
                'api.normal-forms.gradings',
            ],
            'start_inspection_form_filling' => [
                'api.inspections.changedStatusToOngoing',
            ],
            'edit_inspection_form' => [
                'api.normal-forms.update',
                'api.normal-forms.form-points.valueChanged',
                'api.normal-forms.form-points.notApplicableChanged',
                'api.normal-forms.form-points.remarksChanged',
            ],
            'send_inspection_form_back_for_editing' => [
                'api.normal-forms.sendBackToEditing',
            ],
            'see_reports' => [
                'api.english-reports.show',
                'api.dhivehi-reports.show',
                'api.inspections.dhivehi-reports.show',
                'api.inspections.english-reports.show',
            ],
            'generate_reports' => [
                'api.english-reports.update',
                'api.dhivehi-reports.update',
            ],
            'edit_reports' => [
                'api.english-reports.update',
                'api.dhivehi-reports.update',
            ],
            'send_reports_for_approval' => [
                'api.english-reports.sendForProcessing',
                'api.dhivehi-reports.sendForProcessing',
            ],
            'approve_reports' => [
                'api.english-reports.changedStatusToProcessed',
                'api.dhivehi-reports.changedStatusToProcessed',
            ],
            'send_reports_back_for_editing' => [
                'api.english-reports.sendBackToEditing',
                'api.dhivehi-reports.sendBackToEditing',
            ],
            'hand_over_reports' => [
                'api.english-reports.issueReport',
                'api.dhivehi-reports.issueReport',
            ],
            'issue_update_license' => [
                'api.applications.licenses.store',
                'api.businesses.licenses.autofill',
                'uploads.licenses.hardcopy',
            ],
            'create_followup_inspection' => [
                'api.inspections.followupinspections.store',
            ],
            'add_inspection_fine' => [
                'api.fine-types.index',
                'api.inspections.fines.store',
            ],
            'add_business_fine' => [
                'api.fine-types.index',
                'api.businesses.fines.store',
            ],
            'add_termination' => [
                'api.businesses.terminate',
            ],
            'reopen_establishment' => [
                'api.businesses.reopen',
            ],
            'see_license' => [
                'licenses.receipt.show',
                'licenses.hardcopy.show',
            ],
            'pay_license' => [
                'api.licenses.pay',
                'licenses.receipt.show',
                'uploads.licenses.receipt',
            ],
            'delete_license' => [
                'api.licenses.destroy',
            ],
            'see_followup_inspection' => [
                'api.inspections.show',
            ],
            'delete_followup_inspection' => [
                'api.followupinspections.destroy',
            ],
            'see_fine' => [
                'fines.receipt.show',
                'fines.slip.show',
            ],
            'pay_fine' => [
                'api.fines.pay',
                'fines.receipt.show',
                'uploads.fines.receipt',
            ],
            'delete_fine' => [
                'api.fines.destroy',
            ],
            'delete_termination' => [
                'api.terminations.destroy'
            ],
            'see_termination' => [
                'api.businesses.show'
            ],
            //InspectionShow page end
            //BusinessShow page start
            'edit_business' => [
                'api.businesses.update',
            ],
            'create_manual_inspections' => [
                'api.businesses.inspections.store',
            ],
            'add_complaint' => [
                'api.businesses.complaints.store',
            ],
            'see_complaints' => [
                // 'api.complaints.index', //no route yet
            ],
            'see_fines' => [
                'api.fines.index',
            ],
            'see_licenses' => [
                'api.licenses.index',
            ],
            'see_terminations' => [
                // 'api.terminations.index', //no route yet
            ],
            //BusinessShow page end
            'finish_filling_inspection_form' => [ //mark checklist finished
                'api.normal-forms.sendForProcessing',
            ],
            'see_all_inspections' => [
                'api.inspections.index'
            ],
            'upload_grading_certificate' => [
                'uploads.inspections.grading-certificate',
            ],
            'see_grading_certificate' => [
                'inspections.grading-certificate.show',
            ],
            'pay_fee' => [
                'uploads.fees.receipt',
                'api.fees.pay',
            ],
            'see_fee' => [
                'fees.receipt.show',
                'fees.slip.show',
            ],
            'add_business_fee' => [
                'api.businesses.fees.store',
                'api.fee-types.index',
            ]
        ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->roleSubRoleLevel($this->roleSubRoles);
    }

    protected function roleSubRoleLevel($roleSubRoles)
    {
        foreach ($roleSubRoles as $roleSlug => $subRoles) {
            $this->role = Role::where('slug', $roleSlug)->first();
            $this->subRoleLevel($subRoles);
        }
    }

    protected function subRoleLevel($subRoles)
    {
        foreach ($subRoles as $slug) {
            if ($this->isRole($slug)) {
                $this->subRoleLevel($this->roleSubRoles[$slug]);
            } else {
                $this->attachSubrolePermissions($slug);
            }
        }
    }

    protected function isRole($slug)
    {
        return (in_array($slug, array_keys($this->roleSubRoles)));
    }

    protected function attachSubrolePermissions($subRoleSlug)
    {
        $permissionInstance = new Permission;
        foreach($this->subRolePermissions[$subRoleSlug] as $permissionSlug) {
            if ($permissionInstance->where('slug', $permissionSlug)->first()) {
                $this->command->getOutput()->writeln("<info>attaching {$this->role->slug}($subRoleSlug) to $permissionSlug</info>");
                $this->role->permissions()->attach($permissionSlug);
            } else {
                $this->command->getOutput()->writeln("<info>Permission does not exist:</info> $permissionSlug");
            }
        }
    }
}
