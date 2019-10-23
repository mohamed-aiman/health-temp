let mix = require('laravel-mix');


/**
 * for vue router
 */
mix.js(['resources/assets/js/app-spa.js'], 'public/js/app-spa.js');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

/**
 * for laravel routes
 */
mix.js([
	'resources/assets/js/app.js',
    'resources/assets/js/acl.js',
], 'public/js/app-compiled.js');

// /**
//  * components
//  */
// mix.js(['resources/assets/js/components/business-details.vue'], 'public/js/components/business-details.js');
// mix.js(['resources/assets/js/components/business-inspections.vue'], 'public/js/components/business-inspections.js');
// mix.js(['resources/assets/js/components/business-grading-inspections.vue'], 'public/js/components/business-grading-inspections.js');
// mix.js(['resources/assets/js/components/business-licenses.vue'], 'public/js/components/business-licenses.js');
// mix.js(['resources/assets/js/components/business-fines.vue'], 'public/js/components/business-fines.js');

// mix.js(['resources/assets/js/components/acl-roles.vue'], 'public/js/components/acl-roles.js');
// mix.js(['resources/assets/js/components/acl-users.vue'], 'public/js/components/acl-users.js');

// mix.js(['resources/assets/js/components/error-messages.vue'], 'public/js/components/error-messages.js');
// mix.js(['resources/assets/js/components/response-messages.vue'], 'public/js/components/response-messages.js');

// //page scripts here
// mix.js(['resources/assets/js/home.js'], 'public/js/home.js');
// mix.js(['resources/assets/js/moved/dashboard-search-list.js'], 'public/js/dashboard-search-list.js');

// mix.js(['resources/assets/js/applications-show.js'], 'public/js/applications-show.js');
// mix.js(['resources/assets/js/applications-create.js'], 'public/js/applications-create.js');
// mix.js(['resources/assets/js/applications-draft.js'], 'public/js/applications-draft.js');
// mix.js(['resources/assets/js/applications-pending.js'], 'public/js/applications-pending.js');
// mix.js(['resources/assets/js/applications-edit.js'], 'public/js/applications-edit.js');
// mix.js(['resources/assets/js/applications-index.js'], 'public/js/applications-index.js');
// mix.js(['resources/assets/js/applications-process.js'], 'public/js/applications-process.js');

// mix.js(['resources/assets/js/business-applications-create.js'], 'public/js/business-applications-create.js');
// mix.js(['resources/assets/js/business-show-page.js'], 'public/js/business-show-page.js');
// mix.js(['resources/assets/js/expiring-soon-businesses.js'], 'public/js/expiring-soon-businesses.js');

// mix.js(['resources/assets/js/fines-index.js'], 'public/js/fines-index.js');
// mix.js(['resources/assets/js/licenses-index.js'], 'public/js/licenses-index.js');
// mix.js(['resources/assets/js/terminations-index.js'], 'public/js/terminations-index.js');

// mix.js(['resources/assets/js/Grid.js', 'resources/assets/js/dhivehi-reports-edit.js'], 'public/js/dhivehi-reports-edit.js');
// mix.js(['resources/assets/js/Grid.js', 'resources/assets/js/dhivehi-reports-show.js'], 'public/js/dhivehi-reports-show.js');
// mix.js(['resources/assets/js/Grid.js', 'resources/assets/js/dhivehi-reports-handover.js'], 'public/js/dhivehi-reports-handover.js');
// mix.js(['resources/assets/js/Grid.js', 'resources/assets/js/dhivehi-reports-process.js'], 'public/js/dhivehi-reports-process.js');

// mix.js(['resources/assets/js/english-reports-show.js'], 'public/js/english-reports-show.js');
// mix.js(['resources/assets/js/english-reports-handover.js'], 'public/js/english-reports-handover.js');
// mix.js(['resources/assets/js/english-reports-create.js'], 'public/js/english-reports-create.js');
// mix.js(['resources/assets/js/english-reports-edit.js'], 'public/js/english-reports-edit.js');
// mix.js(['resources/assets/js/english-reports-process.js'], 'public/js/english-reports-process.js');

// mix.js(['resources/assets/js/inspections-create.js'], 'public/js/inspections-create.js');
// mix.js(['resources/assets/js/inspections-show.js'], 'public/js/inspections-show.js');
// mix.js(['resources/assets/js/inspections-index.js'], 'public/js/inspections-index.js');
// mix.js(['resources/assets/js/inspections-finish-page.js'], 'public/js/inspections-finish-page.js');
// mix.js(['resources/assets/js/upcomming-inspections-index.js'], 'public/js/upcomming-inspections-index.js');
// mix.js(['resources/assets/js/inspections-pending-reports.js'], 'public/js/inspections-pending-reports.js');
// mix.js(['resources/assets/js/inspections-processed-reports.js'], 'public/js/inspections-processed-reports.js');

// mix.js(['resources/assets/js/normal-form-process.js'], 'public/js/normal-form-process.js');
// mix.js(['resources/assets/js/normal-form-show.js'], 'public/js/normal-form-show.js');
// mix.js(['resources/assets/js/normal-forms-pending.js'], 'public/js/normal-forms-pending.js');
// mix.js(['resources/assets/js/normal-form-edit.js'], 'public/js/normal-form-edit.js');
// mix.js(['resources/assets/js/normal-forms-processed.js'], 'public/js/normal-forms-processed.js');
// mix.js(['resources/assets/js/edit-normal-point.js'], 'public/js/edit-normal-point.js');
// mix.js(['resources/assets/js/manage-normal-points.js'], 'public/js/manage-normal-points.js');
// mix.js(['resources/assets/js/manage-normal-categories.js'], 'public/js/manage-normal-categories.js');

// mix.js(['resources/assets/js/upcomming-grading-inspections.js'], 'public/js/upcomming-grading-inspections.js');
// mix.js(['resources/assets/js/edit-grading-inspection.js'], 'public/js/edit-grading-inspection.js');

// mix.js(['resources/assets/js/grading-form-edit.js'], 'public/js/grading-form-edit.js');
// mix.js(['resources/assets/js/grading-form-show.js'], 'public/js/grading-form-show.js');
// mix.js(['resources/assets/js/edit-grading-point.js'], 'public/js/edit-grading-point.js');
// mix.js(['resources/assets/js/manage-grading-points.js'], 'public/js/manage-grading-points.js');
// mix.js(['resources/assets/js/edit-grading-category.js'], 'public/js/edit-grading-category.js');
// mix.js(['resources/assets/js/manage-grading-categories.js'], 'public/js/manage-grading-categories.js');

// mix.js(['resources/assets/js/acl-dashboard.js'], 'public/js/acl-dashboard.js');
// mix.js(['resources/assets/js/edit-role.js'], 'public/js/edit-role.js');
// mix.js(['resources/assets/js/edit-user.js'], 'public/js/edit-user.js');






mix.sass('resources/assets/sass/app.scss', 'public/sass/app-compiled.css');

mix.sass('resources/assets/sass/bulma.scss', 'public/sass/bulma-css-compiled.css');



// mix.js(['resources/assets/js/inspections-show-page.js'], 'public/js/inspections-show-page.js');
// mix.js(['resources/assets/js/activities-index.js'], 'public/js/activities-index.js');
