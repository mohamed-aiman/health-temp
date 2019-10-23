import Home from './components/Home';

/*** application*/
/**LISTS**/
import DraftApplications   from './components/Application/DraftApplications';
import PendingApplications     from './components/Application/PendingApplications';
import AllApplications         from './components/Application/AllApplications';

import ApplicationCreate   from './components/Application/ApplicationCreate';
import ApplicationEdit     from './components/Application/ApplicationEdit';
import ApplicationProcess from './components/Application/ApplicationProcess';
import ApplicationShow     from './components/Application/ApplicationShow';

/** inspection */
/**LISTS**/
import AllInspections from './components/Inspection/AllInspections';
import UpcomingInspections from './components/Inspection/UpcomingInspections';
import MyInspections from './components/Inspection/MyInspections';

// import PendingNormalForms   from './components/NormalForm/PendingNormalForms';
// import ProcessedNormalForms from './components/NormalForm/ProcessedNormalForms';

/**reports**/
import InspectionPendingReports from './components/InspectionReport/InspectionReportPendingReports';
import InspectionProcessedReports from './components/InspectionReport/InspectionReportProcessedReports';

/**Business Related**/
import AllLicenses from './components/License/AllLicenses';
import AllFines from './components/Fine/AllFines';
import AllTerminations from './components/Termination/AllTerminations';

/**Manage**/
// import FineTypesManage from './components/FineType/FineTypesManage';
import NormalPointsManage from './components/NormalPoint/NormalPointsManage';
import NormalCategoriesManage from './components/NormalCategory/NormalCategoriesManage';
import GradingPointsManage from './components/GradingPoint/GradingPointsManage';
import GradingCategoriesManage from './components/GradingCategory/GradingCategoriesManage';
import AclDashboard from './components/ACL/AclDashboard';
import MyActivities from './components/ActivityLog/MyActivities';
// import PasswordChange from './components/Auth/PasswordChange';

/**Business**/
import BusinessCreate from './components/Business/BusinessCreate';
import BusinessApplicationCreate from './components/Business/BusinessApplicationCreate';
import BusinessShow from './components/Business/BusinessShow';
import ExpiringSoonBusinesses from './components/Business/ExpiringSoonBusinesses';

import DhivehiReportProcess from './components/DhivehiReport/DhivehiReportProcess';
import DhivehiReportHandover from './components/DhivehiReport/DhivehiReportHandover';
import DhivehiReportShow from './components/DhivehiReport/DhivehiReportShow';

// import EnglishReportCreate from './components/EnglishReport/EnglishReportCreate';
import EnglishReportProcess from './components/EnglishReport/EnglishReportProcess';
import EnglishReportHandover from './components/EnglishReport/EnglishReportHandover';
import EnglishReportShow from './components/EnglishReport/EnglishReportShow';

import InspectionCreate from './components/Inspection/InspectionCreate';
import InspectionFinish from './components/Inspection/InspectionFinish';
import InspectionShow from './components/Inspection/InspectionShow';

import InspectionDhivehiReportShow from './components/InspectionDhivehiReport/InspectionDhivehiReportShow';
import InspectionDhivehiReportEdit from './components/InspectionDhivehiReport/InspectionDhivehiReportEdit';

import InspectionEnglishReportEdit from './components/InspectionEnglishReport/InspectionEnglishReportEdit';

import NormalFormShow from './components/NormalForm/NormalFormShow';
import NormalFormProcess from './components/NormalForm/NormalFormProcess';


import NormalInspectionNormalFormShow from './components/NormalInspectionNormalForm/NormalInspectionNormalFormShow';
import NormalInspectionNormalFormEdit from './components/NormalInspectionNormalForm/NormalInspectionNormalFormEdit';

import RoleEdit from './components/ACL/RoleEdit';
import UserEdit from './components/ACL/UserEdit';

import NormalCategoryEdit from './components/NormalCategory/NormalCategoryEdit';

import GradingCategoryEdit from './components/GradingCategory/GradingCategoryEdit';
import GradingPointEdit from './components/GradingPoint/GradingPointEdit';

import NormalPointEdit from './components/NormalPoint/NormalPointEdit';

// import EnglishReportEdit from './components/EnglishReport/EnglishReportEdit';
/**common**/
import NotFound from './components/Common/NotFound';

export default {
    mode: 'history',

    routes: [
        { path: '/', name: 'home', component: Home },
        /**
         * application
         */
            /**LISTS**/
        { path: '/applications/draft', name: 'applications.draft', component: DraftApplications },
        { path: '/applications/pending', name: 'applications.pending', component: PendingApplications },
        { path: '/applications', name: 'applications.index', component: AllApplications },

        { path: '/applications/create', name: 'applications.create', component: ApplicationCreate },
        { path: '/applications/:applicationId/edit', name: 'applications.edit', component: ApplicationEdit, props: true },
        { path: '/applications/:applicationId/process', name: 'applications.process', component: ApplicationProcess, props: true },
        { path: '/applications/:applicationId', name: 'applications.show', component: ApplicationShow, props: true },
        /**
         * inspection
         */
            /**LISTS**/
        { path: '/inspections/my',  name: 'inspections.my',   component: MyInspections },
        { path: '/inspections/upcoming',  name: 'inspections.upcoming',   component: UpcomingInspections },
        { path: '/inspections',  name: 'inspections.index',   component: AllInspections },

        // { path: '/normalforms/pending',   name: 'normal-forms.pending',   component: PendingNormalForms },
        // { path: '/normalforms/processed', name: 'normal-forms.processed', component: ProcessedNormalForms },
        /**

        /*Reports**/
        { path: '/inspections/reports/pending',    name: 'inspections.pending-reports' , component: InspectionPendingReports},
        { path: '/inspections/reports/processed',    name: 'inspections.processed-reports', component: InspectionProcessedReports},

        /**Business Related**/
        { path: '/licenses',     name: 'licenses.index', component: AllLicenses},
        { path: '/fines',     name: 'fines.index', component: AllFines},
        { path: '/terminations',     name: 'terminations.index', component: AllTerminations},

        /**Manage**/
        // { path: '/finetypes/manage',    name: 'fine-types.manage', component: FineTypesManage},
        { path: '/normalpoints/manage',    name: 'normal-points.manage', component: NormalPointsManage},
        { path: '/normalcategories/manage',    name: 'normal-categories.manage', component: NormalCategoriesManage},
        { path: '/acl/dashboard',     name: 'acl.dashboard', component: AclDashboard},
        { path: '/my/activities',     name: 'my.activities', component: MyActivities},
        // { path: '',     name: 'password.change', component: PasswordChange},

        /* Other */

        { path: '/businesses/create', name: 'businesses.create', component: BusinessCreate, props: true },
        { path: '/businesses/:businessId/applications/create', name: 'businesses.applications.create', component: BusinessApplicationCreate, props: true },
        { path: '/businesses/:businessId',                   name: 'businesses.show',                component: BusinessShow,              props: true },

        { path: '/dhivehi/reports/:reportId/process',     name: 'dhivehi-reports.process',  component: DhivehiReportProcess, props: true },
        { path: '/dhivehi/reports/:reportId/handover',    name: 'dhivehi-reports.handover', component: DhivehiReportHandover, props: true },
        { path: '/dhivehi/reports/:reportId',             name: 'dhivehi-reports.show',     component: DhivehiReportShow,     props: true },


        // // { path: '/english/reports/:reportId/create',      name: 'english-reports.create',   component: EnglishReportCreate,   props: true },
        { path: '/english/reports/:reportId/process',     name: 'english-reports.process',  component: EnglishReportProcess,  props: true },
        { path: '/english/reports/:reportId/handover',    name: 'english-reports.handover', component: EnglishReportHandover, props: true },
        { path: '/english/reports/:reportId',             name: 'english-reports.show',     component: EnglishReportShow,     props: true },


        { path: '/inspections/create',                  name: 'inspections.create',   component: InspectionCreate              },
        { path: '/inspections/:inspectionId',           name: 'inspections.show',     component: InspectionShow,   props: true },
        { path: '/inspections/:inspectionId/finish',    name: 'inspections.finish',   component: InspectionFinish, props: true },


        { path: '/inspections/:inspectionId/dhivehi/reports',         name: 'inspections.dhivehi-reports.show',     component: InspectionDhivehiReportShow,     props: true },
        { path: '/inspections/:inspectionId/dhivehi/reports/edit',    name: 'inspections.dhivehi-reports.edit',     component: InspectionDhivehiReportEdit,     props: true },

        { path: '/inspections/:inspectionId/english/reports/edit',    name: 'inspections.english-reports.edit',     component: InspectionEnglishReportEdit,     props: true },

        { path: '/normalforms/:normalFormId/process',   name: 'normal-forms.process',  component: NormalFormProcess,  props: true },
        { path: '/normalforms/:normalFormId',           name: 'normal-forms.show',     component: NormalFormShow,     props: true },

        { path: '/normalinspections/:inspectionId/normalforms/edit',        name: 'normal-inspections.normalforms.edit',     component: NormalInspectionNormalFormEdit, props: true },
        { path: '/normalinspections/:inspectionId/normalforms',             name: 'normal-inspections.normalforms.show',     component: NormalInspectionNormalFormShow,     props: true },

        { path: '/roles/:roleId/edit',        name: 'roles.edit',     component: RoleEdit, props: true },
        { path: '/users/:userId/edit',        name: 'users.edit',     component: UserEdit, props: true },

        { path: '/normalcategories/:normalCategoryId/edit',        name: 'normal-categories.edit',     component: NormalCategoryEdit, props: true },
        { path: '/normalpoints/:normalPointId/edit',  name: 'normalpoints.edit',     component: NormalPointEdit, props: true },

        // { path: '/english/reports/:reportId/edit',             name: 'english-reports.edit',     component: EnglishReportEdit,     props: true },
        /**
         * Common
         */
        { path: '*', redirect: '/' },
        // { path: '/404', component: NotFound },
        // { path: '*', redirect: '/404' },
    ]
}