<?php

use App\User;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

// Auth::routes();
// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login')->name('login.post');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('register', 'Auth\RegisterController@register')->name('register.post');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset.post');


Route::middleware(['auth'])->group(function () {
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/api/my/activities', function(Request $request) {
	return Activity::where('causer_id', $request->user()->id)
		->where('causer_type', User::class)
		->orderBy('created_at','desc')->paginate();
})->name('api.my.activities');

// moved Route::get('/activities', function() { return view('pages.activities-index'); })->name('activities.index');

//enter application
//process application


// Route::get('/tasks', 'HomeController@tasks')->name('tasks');
// // Route::get('permissions', 'PermissionController@index')->name('permissions.index');

// //organised
// Route::middleware(['auth'])->group(function () {
// Route::get('user/permissions', 'UserController@permissions')->name('user-permissions');
	Route::get('/api/user/permissions', 'UserController@permissions')->name('api.user-permissions');
// 	//APPLICATION RELATED/SOME INSPECTION RELATED TOO
// 	//draft applications LEVEL 1
//moved	Route::get('/applications/draft', 'ApplicationController@draft')->name('applications.draft');
	Route::get('/api/applications/draft', 'ApplicationController@draftApi')->name('api.applications.draft'); //applications.draftApi changed
	Route::post('/applications/{application}/documents', 'ApplicationDocumentController@store')->name('applications.documents.store');
	Route::get('/api/applications/{application}/documents', 'ApplicationDocumentController@index')->name('api.applications.documents.index');
	Route::get('/applications/{application}/documents/{documentId}', 'ApplicationDocumentController@viewDocument')->name('api.applications.documents.show');
	Route::delete('/api/applications/{application}/documents/{documentId}', 'ApplicationDocumentController@destroy')->name('api.applications.documents.destroy');
	Route::patch('/api/applications/{application}/status/pending', 'ApplicationController@sendForProcessing')->name('api.applications.sendForProcessing');
// 	//pending applications LEVEL 2
//moved 	Route::get('/applications/pending', 'ApplicationController@pending')->name('applications.pending');
	Route::get('/api/applications/pending', 'ApplicationController@pendingApi')->name('api.applications.pending'); //applications.pendingApi changed
// 	//process application LEVEL 2
	Route::patch('api/applications/{application}/status/draft', 'ApplicationController@sendBackToEditing')->name('api.applications.sendBackToEditing'); //applications.sendBackToEditing changed
// 	Route::get('applications/{application}/process', 'ApplicationController@process')->name('applications.process');
	Route::post('api/applications/{application}/inspections', 'ApplicationInspectionController@store')->name('api.applications.inspections.store');
	Route::patch('/api/applications/{application}/status/processed', 'ApplicationController@processed')->name('api.applications.process'); //applications.processed
	Route::patch('/api/inspections/{inspection}', 'InspectionController@update')->name('api.inspections.update'); //added api part fahun
	Route::delete('/api/inspections/{inspection}', 'InspectionController@destroy')->name('api.inspections.destroy'); //added api part fahun
// 	//create new appllication LEVEL 1
//moved 	Route::get('applications/create', 'ApplicationController@create')->name('applications.create'); //view application form
// 	//edit application LEVEL 1
//moved 	Route::get('applications/{application}/edit', 'ApplicationController@edit')->name('applications.edit'); //go to the newly created application form or edit
	Route::patch('/api/applications/{application}', 'ApplicationController@update')->name('api.applications.update');

	Route::delete('/api/applications/{application}', 'ApplicationController@destroy')->name('api.applications.destroy');
//moved Route::get('applications/{application}', 'ApplicationController@show')->name('applications.show');
	Route::get('/api/applications/{application}', 'ApplicationController@showApi')->name('api.applications.show');
// });
// Route::middleware(['auth'])->group(function () {
//moved Route::get('/', 'HomeController@index')->name('home');
//moved Route::get('/', 'HomeController@index')->name('home');
// 	Route::get('/manage', 'HomeController@manage')->name('manage');
// 	// Route::get('/test', function () {
// 	//     return view('test');
// 	// })->name('home');

// 	//uploads
	Route::post('/uploads/licenses/{license}/hardcopy', 'LicenseController@uploadHardCopy')->name('uploads.licenses.hardcopy');
	Route::get('/licenses/{license}/hardcopy', 'LicenseController@viewHardCopy')->name('licenses.hardcopy.show');
	Route::post('/uploads/inspections/{inspection}/grading/certificate', 'InspectionController@uploadGradingCertificate')->name('uploads.inspections.grading-certificate');
	Route::get('/inspections/{inspection}/grading/certificate', 'InspectionController@viewGradingCertificate')->name('inspections.grading-certificate.show');
	Route::post('/uploads/fines/{fine}/receipt', 'FineController@uploadReceipt')->name('uploads.fines.receipt');
	Route::patch('/api/fines/{fine}/pay', 'FineController@pay')->name('api.fines.pay');
	Route::get('/fines/{fine}/receipt', 'FineController@viewReceipt')->name('fines.receipt.show');
	Route::get('/fines/{fine}/slip', 'FineController@viewSlip')->name('fines.slip.show');

	Route::post('/uploads/fees/{fee}/receipt', 'FeeController@uploadReceipt')->name('uploads.fees.receipt');
	Route::patch('/api/fees/{fee}/pay', 'FeeController@pay')->name('api.fees.pay');
	Route::get('/fees/{fee}/receipt', 'FeeController@viewReceipt')->name('fees.receipt.show');
	Route::get('/fees/{fee}/slip', 'FeeController@viewSlip')->name('fees.slip.show');



	Route::post('/uploads/licenses/{license}/receipt', 'LicenseController@uploadReceipt')->name('uploads.licenses.receipt');
	Route::patch('/api/licenses/{license}/pay', 'LicenseController@pay')->name('api.licenses.pay');
	Route::get('/licenses/{license}/receipt', 'LicenseController@viewReceipt')->name('licenses.receipt.show');

	Route::post('/uploads/dhivehi/reports/{dhivehiReport}/hardcopy', 'DhivehiReportController@uploadHardCopy')->name('uploads.dhivehi-reports.hardcopy');
	Route::get('/dhivehi/reports/{dhivehiReport}/hardcopy', 'DhivehiReportController@viewHardCopy')->name('dhivehi-reports.hardcopy.show');

	Route::post('/uploads/english/reports/{englishReport}/hardcopy', 'EnglishReportController@uploadHardCopy')->name('uploads.english-reports.hardcopy');
	Route::get('/english/reports/{englishReport}/hardcopy', 'EnglishReportController@viewHardCopy')->name('english-reports.hardcopy.show');

// 	//inspection new routes
//moved 	Route::get('/inspections/reports/pending', 'InspectionReportController@pendingReports')->name('inspections.pending-reports');
	Route::get('/api/inspections/reports/pending', 'InspectionReportController@pendingReportsApi')->name('api.inspections.pending-reports');
//moved 	Route::get('/inspections/reports/processed', 'InspectionReportController@processedReports')->name('inspections.processed-reports');
	Route::get('/api/inspections/reports/processed', 'InspectionReportController@processedReportsApi')->name('api.inspections.processed-reports');
// 	//Normal Inspection new routes

//moved 	Route::get('/normalforms/processed', 'NormalFormController@processed')->name('normal-forms.processed');
	Route::get('/api/normalforms/{normalForm}/gradings', 'NormalFormController@getGradingsCalculated')->name('api.normal-forms.gradings');
	Route::get('/api/normalforms/processed', 'NormalFormController@processedApi')->name('api.normal-forms.processed'); //normal-forms.processedApi changed
	Route::patch('api/normalforms/{normalForm}/status/pending', 'NormalFormController@sendForProcessing')->name('api.normal-forms.sendForProcessing');
//moved 	Route::get('normalforms/pending', 'NormalFormController@pending')->name('normal-forms.pending');
	Route::get('/api/normalforms/pending', 'NormalFormController@pendingApi')->name('api.normal-forms.pending'); //normal-forms.pendingApi
	Route::get('/api/gradingforms/pending', 'GradingFormController@pendingApi')->name('api.grading-forms.pending'); //normal-forms.pendingApi
	Route::patch('/api/normalforms/{normalForm}/status/draft', 'NormalFormController@sendBackToEditing')->name('api.normal-forms.sendBackToEditing');
	Route::patch('/api/gradingforms/{gradingForm}/status/draft', 'GradingFormController@sendBackToEditing')->name('api.grading-forms.sendBackToEditing');
	// Route::post('/api/normalforms/{normalForm}/reports/generate', 'NormalFormReportController@generateReports')->name('api.normal-forms.generateReports'); //commented NormalFormProcess.vue
	// Route::patch('/api/normalforms/{normalForm}/status/processed', 'NormalFormController@changedStatusToProcessed')->name('api.normal-forms.changedStatusToProcessed');
	Route::patch('/api/gradingforms/{gradingForm}/status/processed', 'GradingFormController@changedStatusToProcessed')->name('api.grading-forms.changedStatusToProcessed');
//moved 	Route::get('normalforms/{normalForm}/process', 'NormalFormController@process')->name('normal-forms.process');
//moved 	Route::get('normalforms/{normalForm}', 'NormalFormController@show')->name('normal-forms.show');

// 	//Normal Inspection
// 	Route::get('normalpoints/create', 'NormalPointController@create')->name('normal-points.create');
// 	Route::get('normalpoints/{normalPoint}/edit', 'NormalPointController@edit')->name('normal-points.edit');
//  Route::get('normalpoints/manage', 'NormalPointController@manageNormalPoints')->name('normal-points.manage');
	Route::get('/api/normalpoints/{normalPoint}', 'NormalPointController@showApi')->name('api.normal-points.show');
	Route::patch('/api/normalpoints/{normalPoint}', 'NormalPointController@updateApi')->name('api.normal-points.update');
	Route::post('/api/normalpoints', 'NormalPointController@storeApi')->name('api.normal-points.store');
// 	Route::get('normalpoints/{normalPoint}/edit', 'NormalPointController@edit')->name('normal-points.edit');
	Route::get('/api/normalpoints', 'NormalPointController@indexApi')->name('api.normal-points.index');
	Route::delete('/api/normalpoints/{normalPoint}', 'NormalPointController@destroyApi')->name('api.normal-points.destroy');

//  Route::get('normalcategories/manage', 'NormalCategoryController@manageNormalCategories')->name('normal-categories.manage');
	Route::get('/api/normalcategories', 'NormalCategoryController@indexApi')->name('api.normal-categories.index');
	Route::post('/api/normalcategories', 'NormalCategoryController@storeApi')->name('api.normal-categories.store');
// 	Route::get('normalcategories/{normalCategory}/edit', 'NormalCategoryController@edit')->name('normal-categories.edit');
	Route::get('/api/normalcategories/forselect', 'NormalCategoryController@selectOptions')->name('api.normal-categories.select-options');
	Route::get('/api/normalcategories/{normalCategory}', 'NormalCategoryController@showApi')->name('api.normal-categories.show');
	Route::patch('/api/normalcategories/{normalCategory}', 'NormalCategoryController@updateApi')->name('api.normal-categories.update');
	Route::delete('/api/normalcategories/{normalCategory}', 'NormalCategoryController@destroyApi')->name('api.normal-categories.destroy');

	Route::patch('/api/normalforms/{normalForm}', 'NormalFormController@updateApi')->name('api.normal-forms.update');
	Route::get('/api/normalforms/{normalForm}/points', 'NormalInspectionNormalFormController@getFormPointsForDisplay')->name('api.normal-forms.points');
	Route::patch('/api/normalforms/{normalForm}/formpoints/{formPoint}/value/changed', 'NormalFormFormPointController@valueChanged')->name('api.normal-forms.form-points.valueChanged');
	Route::patch('/api/normalforms/{normalForm}/formpoints/{formPoint}/notapplicable/changed', 'NormalFormFormPointController@notApplicableChanged')->name('api.normal-forms.form-points.notApplicableChanged');
	Route::patch('/api/normalforms/{normalForm}/formpoints/{formPoint}/remarks/changed', 'NormalFormFormPointController@remarksChanged')->name('api.normal-forms.form-points.remarksChanged');
	Route::get('api/normalforms/{normalForm}', 'NormalFormController@showApi')->name('api.normal-forms.show'); //normal-forms.showApi

// 	Route::get('normalinspections/{inspection}/edit', 'NormalInspectionController@edit')->name('normal-inspections.edit');
// 	Route::get('normalinspections/upcoming', 'NormalInspectionController@upcoming')->name('normal-inspections.upcoming');
// 	Route::get('api/normalinspections/upcoming', 'NormalInspectionController@upcomingApi')->name('api.normal-inspections.upcoming');
// 	// Route::patch('normalinspections/{inspection}', 'NormalInspectionController@update')->name('inspections.update');
//moved 	Route::get('normalinspections/{inspection}/normalforms/edit', 'NormalInspectionNormalFormController@edit')->name('normal-inspections.normalforms.edit');
//moved 	Route::get('normalinspections/{inspection}/normalforms', 'NormalInspectionNormalFormController@show')->name('normal-inspections.normalforms.show');
	Route::get('/api/normalinspections/{inspection}/normalforms', 'NormalInspectionNormalFormController@showApi')->name('api.normal-inspections.normalforms.show');
	Route::patch('/api/inspections/{inspection}/status/ongoing', 'InspectionController@changedStatusToOngoing')->name('api.inspections.changedStatusToOngoing');


// 	//Grading Inspection
// 	Route::get('gradingpoints/create', 'GradingPointController@create')->name('grading-points.create');
//moved 	Route::get('gradingpoints/{gradingPoint}/edit', 'GradingPointController@edit')->name('grading-points.edit');
//  Route::get('gradingpoints/manage', 'GradingPointController@manageGradingPoints')->name('grading-points.manage');
	Route::get('/api/gradingpoints/{gradingPoint}', 'GradingPointController@showApi')->name('api.grading-points.show');
	Route::patch('/api/gradingpoints/{gradingPoint}', 'GradingPointController@updateApi')->name('api.grading-points.update');
	Route::post('/api/gradingpoints', 'GradingPointController@storeApi')->name('api.grading-points.store');
	Route::get('/api/gradingpoints', 'GradingPointController@indexApi')->name('api.grading-points.index');
	Route::delete('/api/gradingpoints/{gradingPoint}', 'GradingPointController@destroyApi')->name('api.grading-points.destroy');


//  Route::get('gradingcategories/manage', 'GradingCategoryController@manageGradingCategories')->name('grading-categories.manage');
	Route::get('/api/gradingcategories', 'GradingCategoryController@indexApi')->name('api.grading-categories.index');
	Route::post('/api/gradingcategories', 'GradingCategoryController@storeApi')->name('api.grading-categories.store');
// 	Route::get('gradingcategories/{gradingCategory}/edit', 'GradingCategoryController@edit')->name('grading-categories.edit');
	Route::get('/api/gradingcategories/forselect', 'GradingCategoryController@selectOptions')->name('api.grading-categories.select-options');
	Route::get('/api/gradingcategories/{gradingCategory}', 'GradingCategoryController@showApi')->name('api.grading-categories.show');
	Route::patch('/api/gradingcategories/{gradingCategory}', 'GradingCategoryController@updateApi')->name('api.grading-categories.update');
	Route::delete('/api/gradingcategories/{gradingCategory}', 'GradingCategoryController@destroyApi')->name('api.grading-categories.destroy');

	Route::patch('/api/gradingforms/{gradingForm}', 'GradingFormController@updateApi')->name('api.grading-forms.update');
	Route::get('/api/gradingforms/{gradingForm}/points', 'GradingInspectionGradingFormController@getFormPointsForDisplay')->name('api.grading-forms.points');
	Route::get('/api/gradingforms/{gradingForm}/gradings', 'GradingFormController@getGradingsCalculated')->name('api.grading-forms.gradings');
	Route::patch('/api/gradingforms/{gradingForm}/formpoints/{formPoint}/value/changed', 'GradingFormFormPointController@valueChanged')->name('grading-forms.form-points.valueChanged');
	Route::patch('/api/gradingforms/{gradingForm}/formpoints/{formPoint}/notapplicable/changed', 'GradingFormFormPointController@notApplicableChanged')->name('grading-forms.form-points.notApplicableChanged');
	Route::patch('/api/gradingforms/{gradingForm}/status/pending', 'GradingFormController@sendForProcessing')->name('api.grading-forms.sendForProcessing');
	Route::get('/api/gradingforms/{gradingForm}', 'GradingFormController@showApi')->name('api.grading-forms.show'); //grading-forms.showApi

// 	Route::get('gradinginspections/{inspection}/edit', 'GradingInspectionController@edit')->name('grading-inspections.edit');
//moved 	Route::get('gradinginspections/upcoming', 'GradingInspectionController@upcoming')->name('grading-inspections.upcoming');
	Route::get('/api/gradinginspections/upcoming', 'GradingInspectionController@upcomingApi')->name('api.grading-inspections.upcoming');
	Route::patch('/api/gradinginspections/{inspection}', 'GradingInspectionController@update')->name('api.grading-inspections.update');
//moved 	Route::get('gradinginspections/{inspection}/gradingforms/edit', 'GradingInspectionGradingFormController@edit')->name('grading-inspections.gradingforms.edit');
	Route::get('/api/gradinginspections/{inspection}/gradingforms', 'GradingInspectionGradingFormController@show')->name('api.grading-inspections.gradingforms.show');

// 	// Route::get('/applications/unprocessed', 'ApplicationController@unprocessed')->name('applications.unprocessed');
// 	// Route::get('/api/applications/unprocessed', 'ApplicationController@unprocessedApi')->name('applications.unprocessedApi');
// 	// Route::get('applications/{application}/process', 'ApplicationController@process')->name('applications.process');
// 	// Route::get('applications/create', 'ApplicationController@create')->name('applications.create');
// 	// Route::get('applications/{application}', 'ApplicationController@show')->name('applications.show');
// 	// Route::patch('applications/{application}', 'ApplicationController@update')->name('applications.update');
Route::post('/api/applications', 'ApplicationController@store')->name('api.applications.store');
//moved	Route::get('applications', 'ApplicationController@index')->name('applications.index');
//moved 	Route::get('/businesses/expiringsoon', 'BusinessController@expiringSoon')->name('businesses.expiringsoon');
//show moved, change create and edit to vue 	Route::resource('businesses', 'BusinessController');


	Route::get('/api/dhivehi-reports/{dhivehiReport}/points', 'DhivehiReportPointController@index')->name('api.dhivehi-reports.form-points.index');
	Route::post('/api/dhivehi-reports/{dhivehiReport}/points', 'DhivehiReportPointController@store')->name('api.dhivehi-reports.form-points.store');
	Route::patch('/api/dhivehi-reports/{dhivehiReport}/points/{formPointId}', 'DhivehiReportPointController@update')->name('api.dhivehi-reports.form-points.update');
	Route::delete('/api/dhivehi-reports/{dhivehiReport}/points/{dhivehiReportNormalFormPoint}', 'DhivehiReportPointController@destroy')->name('api.dhivehi-reports.form-points.destroy');

//moved 	Route::get('inspections/create', 'InspectionController@create')->name('inspections.create');
// 	Route::get('inspections/upcoming', 'InspectionController@upcoming')->name('inspections.upcoming');
Route::get('/api/inspections/{inspection}/dhivehi/reports', 'InspectionDhivehiReportController@showApi')->name('api.inspections.dhivehi-reports.show');
//moved 	Route::get('inspections/{inspection}/dhivehi/reports', 'InspectionDhivehiReportController@show')->name('inspections.dhivehi-reports.show');
//moved 	Route::get('dhivehi/reports/{dhivehiReport}/handover', 'DhivehiReportController@handover')->name('dhivehi-reports.handover');
//moved	Route::get('dhivehi/reports/{dhivehiReport}', 'DhivehiReportController@show')->name('dhivehi-reports.show');
//moved 	Route::get('inspections/{inspection}/dhivehi/reports/edit', 'InspectionDhivehiReportController@edit')->name('inspections.dhivehi-reports.edit');
//moved	Route::get('dhivehi/reports/{dhivehiReport}/process', 'DhivehiReportController@process')->name('dhivehi-reports.process');
	Route::patch('/api/dhivehi/reports/{dhivehiReport}/status/draft', 'DhivehiReportController@sendBackToEditing')->name('api.dhivehi-reports.sendBackToEditing');
	Route::patch('/api/dhivehi/reports/{dhivehiReport}/status/processed', 'DhivehiReportController@changedStatusToProcessed')->name('api.dhivehi-reports.changedStatusToProcessed');
	Route::patch('/api/dhivehi/reports/{dhivehiReport}', 'DhivehiReportController@update')->name('api.dhivehi-reports.update');

	Route::patch('/api/dhivehi/reports/{dhivehiReport}/issuereport', 'DhivehiReportController@issueReport')->name('api.dhivehi-reports.issueReport');

// 	Route::get('inspections/{inspection}/english/reports/edit', 'InspectionEnglishReportController@edit')->name('inspections.english-reports.edit');
//moved 	Route::get('english/reports/{englishReport}/process', 'EnglishReportController@process')->name('english-reports.process');
	Route::get('/api/inspections/{inspection}/english/reports', 'InspectionEnglishReportController@showApi')->name('api.inspections.english-reports.show');
	Route::patch('/api/english/reports/{englishReport}/status/draft', 'EnglishReportController@sendBackToEditing')->name('api.english-reports.sendBackToEditing');
	Route::patch('/api/english/reports/{englishReport}/status/processed', 'EnglishReportController@changedStatusToProcessed')->name('api.english-reports.changedStatusToProcessed');
//moved 	Route::get('english/reports/{englishReport}/handover', 'EnglishReportController@handover')->name('english-reports.handover');
//moved 	Route::get('english/reports/{englishReport}', 'EnglishReportController@show')->name('english-reports.show');

	Route::patch('/api/english/reports/{englishReport}/issuereport', 'EnglishReportController@issueReport')->name('api.english-reports.issueReport');

	Route::get('/api/inspections/{inspection}/fines', 'InspectionFineController@index')->name('api.inspections.fines.index');
	Route::get('/api/gradinginspections/{inspection}/fines', 'GradingInspectionFineController@index')->name('api.grading-inspections.fines.index');
	Route::patch('/api/fines/{fine}', 'FineController@update')->name('api.fines.update');
	Route::delete('/api/fines/{fine}', 'FineController@destroy')->name('api.fines.destroy');
	Route::post('/api/inspections/{inspection}/followupinspections', 'InspectionFollowupInspectionsController@store')->name('api.inspections.followupinspections.store');
	Route::post('/api/gradinginspections/{inspection}/followupinspections', 'GradingInspectionFollowupInspectionsController@store')->name('api.grading-inspections.followupinspections.store');
	Route::post('/api/inspections/{inspection}/fines', 'InspectionFineController@store')->name('api.inspections.fines.store');
	Route::post('/api/gradinginspections/{inspection}/fines', 'GradingInspectionFineController@store')->name('api.grading-inspections.fines.store');
//moved 	Route::get('inspections/{inspection}/finish', 'InspectionController@finish')->name('inspections.finish');
	Route::delete('/api/followupinspections/{inspection}', 'InspectionFollowupInspectionsController@destroy')->name('api.followupinspections.destroy');
	Route::delete('/api/followupgradinginspections/{inspection}', 'GradingInspectionFollowupInspectionsController@destroy')->name('api.followupgrading-inspections.destroy');
//moved 	Route::get('inspections/{inspection}', 'InspectionController@show')->name('inspections.show');
	Route::get('/api/inspections/my', 'InspectionController@my')->name('api.inspections.my');
	Route::patch('/api/inspections/{inspection}', 'InspectionController@update')->name('api.inspections.update'); //inspections.update changed
	Route::delete('/api/inspections/{inspection}', 'InspectionController@destroy')->name('api.inspections.destroy');


	Route::patch('/api/dhivehi/reports/{dhivehiReport}/status/pending', 'DhivehiReportController@sendForProcessing')->name('api.dhivehi-reports.sendForProcessing');

	Route::patch('/api/english/reports/{englishReport}', 'EnglishReportController@update')->name('api.english-reports.update');
	Route::patch('/api/english/reports/{englishReport}/critical', 'EnglishReportController@updateCritical')->name('api.english-reports.critical.update');
	Route::patch('/api/english/reports/{englishReport}/major', 'EnglishReportController@updateMajor')->name('api.english-reports.major.update');
	Route::patch('/api/english/reports/{englishReport}/other', 'EnglishReportController@updateOther')->name('api.english-reports.other.update');
	Route::patch('/api/english/reports/{englishReport}/status/pending', 'EnglishReportController@sendForProcessing')->name('api.english-reports.sendForProcessing');

	Route::get('api/businesses/expired', 'BusinessController@expired')->name('api.businesses.expired');
	Route::get('api/businesses/expiringsoon', 'BusinessController@expiringSoonApi')->name('api.businesses.expiringsoon');
	Route::get('api/inspections/upcoming', 'InspectionController@upcomingApi')->name('api.inspections.upcoming');
	Route::get('api/dhivehi/reports/{dhivehiReport}', 'DhivehiReportController@showApi')->name('api.dhivehi-reports.show'); //dhivehi-reports.showApi
	Route::get('api/english/reports/{englishReport}', 'EnglishReportController@showApi')->name('api.english-reports.show');
// 	Route::get('reports/eng/create', 'EnglishReportController@create')->name('english-reports.create');

	Route::post('/api/businesses/{business}/fines', 'BusinessController@fine')->name('api.businesses.fines.store');
	Route::post('/api/businesses/{business}/terminate', 'BusinessController@terminate')->name('api.businesses.terminate');
	Route::patch('/api/businesses/{business}/reopen', 'BusinessController@reopen')->name('api.businesses.reopen');
// 	Route::get('businesses/{business}/edit', 'BusinessController@edit')->name('businesses.edit');
// 	Route::patch('businesses/{business}', 'BusinessController@update')->name('businesses.update');
//moved 	Route::get('businesses/{business}/applications/create', 'BusinessApplicationController@create')->name('businesses.applications.create');


	Route::post('api/businesses/{business}/license/autofill', 'LicenseController@autofill')->name('api.businesses.licenses.autofill');
	Route::post('api/applications/{application}/licenses', 'ApplicationLicenseController@store')->name('api.applications.licenses.store');
	Route::post('api/applications/{application}/businesses', 'ApplicationBusinessController@store')->name('api.applications.businesses.store');
	Route::post('api/businesses/{business}/inspections', 'BusinessInspectionController@store')->name('api.businesses.inspections.store');
	Route::post('api/businesses/{business}/complaints', 'BusinessComplaintController@store')->name('api.businesses.complaints.store');
	Route::post('api/businesses/{business}/fees', 'BusinessFeeController@store')->name('api.businesses.fees.store');
// 	Route::post('api/businesses/{business}/gradinginspections', 'BusinessGradingInspectionController@store')->name('businesses.grading-inspections.store');
	Route::get('api/businesses/search', 'BusinessController@search')->name('api.businesses.search');
	Route::get('api/businesses/{business}', 'BusinessController@showApi')->name('api.businesses.show');
	Route::get('api/applications', 'ApplicationController@indexApi')->name('api.applications.index');
	// Route::patch('api/applications/{application}/updateStatus', 'ApplicationController@updateStatus')->name('api.applications.updateStatus'); commented on AllApplications.vue
	Route::patch('/api/applications/{application}/businesses/detach', 'ApplicationBusinessController@detach')->name('api.applications.businesses.detach');
	Route::patch('/api/applications/{application}/businesses/{buiness}/attach', 'ApplicationBusinessController@attach')->name('api.applications.businesses.attach');

	Route::get('/api/inspections/{inspection}', 'InspectionController@showApi')->name('api.inspections.show'); //inspections.showApi
	Route::get('/api/gradinginspections/{inspection}', 'GradingInspectionController@showApi')->name('api.grading-inspections.show'); //inspections.showApi
// 	Route::delete('/inspections/{inspection}/fines', 'InspectionFineController@destroy')->name('inspections.fines.destroy');
	Route::patch('/api/inspections/{inspection}/updatefined', 'InspectionController@updateFined')->name('inspections.updateFined');
	Route::patch('/api/inspections/{inspection}/close', 'InspectionController@close')->name('api.inspections.close');
	Route::patch('/api/inspections/{inspection}/decisionmade', 'InspectionController@decisionMade')->name('api.inspections.decisionMade');
	Route::patch('/api/gradinginspections/{inspection}/close', 'GradingInspectionController@close')->name('api.grading-inspections.close');
	Route::patch('/api/inspections/{inspection}/updatefollowup', 'InspectionController@updateFollowup')->name('inspections.update-followup');

// 	Route::patch('/api/inspections/{inspection}/handoverreports', 'InspectionController@handOverReports')->name('inspections.hand-over-reports');

	Route::get('/api/fine-types', 'FineTypeController@indexApi')->name('api.fine-types.index');// fines.indexApi
	Route::get('/api/fee-types', 'FeeTypeController@indexApi')->name('api.fee-types.index');
	Route::post('/api/fine-types', 'FineTypeController@store')->name('api.fine-types.store');// fines.indexApi
	Route::get('/api/fines', 'FineController@indexApi')->name('api.fines.index');// fines.indexApi
	Route::get('/api/licenses', 'LicenseController@indexApi')->name('api.licenses.index');//licenses.indexApi
	Route::get('/api/inspections', 'InspectionController@indexApi')->name('api.inspections.index');//inspections.indexApi
	Route::get('/api/terminations', 'TerminationController@indexApi')->name('api.terminations.index');//terminations.indexApi



// 	Route::resource('businesses.terminations', 'BusinessTerminationController')->only(['businesses.terminations.show']); //aslu its useless route, just for permissions
//moved 	Route::resource('inspections', 'InspectionController')->only(['index']); //aslu its useless route, just for permissions
// 	Route::resource('gradinginspections', 'GradingInspectionController')->only(['show']); //aslu its useless route, just for permissions
//index moved 	Route::resource('fines', 'FineController')->only(['show', 'index']);
	Route::delete('/api/licenses/{license}', 'LicenseController@destroy')->name('api.licenses.destroy');
	Route::delete('/api/terminations/{termination}', 'TerminationController@destroy')->name('api.terminations.destroy');

	Route::get('/api/inspectors', 'UserController@inspectorsList')->name('api.inspectors.index');

	Route::patch('/api/roles/{role}', 'RoleController@update')->name('api.roles.update');
	Route::patch('/api/users/{user}', 'UserController@update')->name('api.users.update');

	Route::patch('/api/users/{user}/roles/detach', 'UserRoleController@detach')->name('api.users.roles.detach');
	Route::patch('/api/users/{user}/roles/attach', 'UserRoleController@attach')->name('api.users.roles.attach');
	Route::get('/api/users/{user}/roles/forcheckbox', 'UserRoleController@listForCheckbox')->name('api.users.roles.forcheckbox');
	// Route::resource('users', 'UserController');
	// Route::resource('roles', 'RoleController');
	Route::delete('/api/roles/{role}', 'RoleController@show')->name('api.roles.destroy');
	Route::get('/api/roles/{role}/permissions/forcheckbox', 'RolePermissionController@listForCheckbox')->name('api.roles.permissions.forcheckbox');
	Route::get('/api/roles/{role}', 'RoleController@show')->name('api.roles.show');
	Route::delete('/api/users/{user}', 'UserController@show')->name('api.users.destroy');
	Route::get('/api/users/{user}', 'UserController@show')->name('api.users.show');
// 	// Route::resource('permissions', 'PermissionController');

// 	// Route::resource('users.roles', 'UserRoleController');
// 	// Route::resource('users.permissions', 'UserPermissionController');
	Route::patch('/api/roles/{role}/permissions/detach', 'RolePermissionController@detach')->name('api.roles.permissions.detach');
	Route::patch('/api/roles/{role}/permissions/attach', 'RolePermissionController@attach')->name('api.roles.permissions.attach');
// 	Route::resource('roles.permissions', 'RolePermissionController');

	Route::get('password/change', 'Auth\ChangePasswordController@showChangeForm')->name('password.change');
	Route::post('password/change', 'Auth\ChangePasswordController@change')->name('password.change.post');

	//moved Route::get('/dashboard', 'ACLController@dashboard')->name('acl.dashboard');
	Route::get('/dashboard', 'ACLController@dashboard')->name('acl.dashboard');//just for permission on home page link
	Route::post('/api/acl/users', 'UserController@store')->name('api.users.store');
	Route::get('/api/acl/users', 'UserController@index')->name('api.users.index');
	Route::post('/api/acl/roles', 'RoleController@store')->name('api.roles.store');
	Route::get('/api/acl/roles', 'RoleController@index')->name('api.roles.index');
	Route::get('/api/acl/permissions', 'PermissionController@index')->name('api.permissions.index');
	// Route::resource('users', 'UserController');
	// Route::resource('roles', 'RoleController');
	// Route::resource('permissions', 'PermissionController');
	// Route::any('{all}', function () {
	//     return view('home');
	// })->where('all', '^(?!api).*$');
	Route::get('/{view?}', 'SPAViewController')->name('spa')->where('view', '(.*)');
});







// Route::get('/{any}', function () {
//     return view('home');
// })->where('any', '.*');


// Route::get('/{any?}', function () {
//     return view('home');
// })->name('home');
