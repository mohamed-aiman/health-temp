<?php

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

// Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth', 'permission'])->group(function () {
	Route::get('/', 'HomeController@index')->name('home');
	Route::get('/manage', 'HomeController@manage')->name('manage');
	// Route::get('/test', function () {
	//     return view('test');
	// })->name('home');

	Route::get('gradingpoints/create', 'GradingPointController@create')->name('grading-points.create');
	Route::get('gradingpoints/{gradingPoint}/edit', 'GradingPointController@edit')->name('grading-points.edit');
	Route::get('gradingpoints/manage', 'GradingPointController@manageGradingPoints')->name('grading-points.manage');
	Route::get('api/gradingpoints/{gradingPoint}', 'GradingPointController@showApi')->name('grading-points.showApi');
	Route::patch('api/gradingpoints/{gradingPoint}', 'GradingPointController@updateApi')->name('grading-points.updateApi');
	Route::post('api/gradingpoints', 'GradingPointController@storeApi')->name('grading-points.storeApi');
	Route::get('gradingpoints/{gradingPoint}/edit', 'GradingPointController@edit')->name('grading-points.edit');
	Route::get('api/gradingpoints', 'GradingPointController@indexApi')->name('grading-points.indexApi');
	Route::delete('api/gradingpoints/{gradingPoint}', 'GradingPointController@destroyApi')->name('grading-points.destroyApi');

	Route::get('gradingcategories/manage', 'GradingCategoryController@manageGradingCategories')->name('grading-categories.manage');
	Route::get('api/gradingcategories', 'GradingCategoryController@indexApi')->name('grading-categories.indexApi');
	Route::post('api/gradingcategories', 'GradingCategoryController@storeApi')->name('grading-categories.storeApi');
	Route::get('gradingcategories/{gradingCategory}/edit', 'GradingCategoryController@edit')->name('grading-categories.edit');
	Route::get('api/gradingcategories/{gradingCategory}', 'GradingCategoryController@showApi')->name('grading-categories.showApi');
	Route::patch('api/gradingcategories/{gradingCategory}', 'GradingCategoryController@updateApi')->name('grading-categories.updateApi');
	Route::delete('api/gradingcategories/{gradingCategory}', 'GradingCategoryController@destroyApi')->name('grading-categories.destroyApi');

	Route::patch('api/gradingforms/{gradingForm}', 'GradingFormController@updateApi')->name('grading-forms.updateApi');
	Route::get('/api/gradingcategories/forselect', 'GradingCategoryController@selectOptions')->name('grading-categories.select-options');
	Route::get('/api/gradingforms/{gradingForm}/points', 'GradingInspectionGradingFormController@getFormPointsForDisplay')->name('grading-forms.points');
	Route::patch('/api/gradingforms/{gradingForm}/formpoints/{formPoint}/value/changed', 'GradingFormFormPointController@valueChanged')->name('grading-forms.form-points.valueChanged');
	Route::patch('/api/gradingforms/{gradingForm}/formpoints/{formPoint}/notapplicable/changed', 'GradingFormFormPointController@notApplicableChanged')->name('grading-forms.form-points.notApplicableChanged');
	Route::get('api/gradingforms/{gradingForm}', 'GradingFormController@showApi')->name('grading-forms.showApi');

	Route::get('gradinginspections/{inspection}/edit', 'GradingInspectionController@edit')->name('grading-inspections.edit');
	Route::get('gradinginspections/upcoming', 'GradingInspectionController@upcoming')->name('grading-inspections.upcoming');
	Route::get('api/gradinginspections/upcoming', 'GradingInspectionController@upcomingApi')->name('api.grading-inspections.upcoming');
	Route::patch('gradinginspections/{inspection}', 'GradingInspectionController@update')->name('inspections.update');
	Route::get('gradinginspections/{inspection}/gradingforms/edit', 'GradingInspectionGradingFormController@edit')->name('grading-inspections.gradingforms.edit');
	Route::get('gradinginspections/{inspection}/gradingforms', 'GradingInspectionGradingFormController@show')->name('grading-inspections.gradingforms.show');

	Route::get('/applications/unprocessed', 'ApplicationController@unprocessed')->name('applications.unprocessed');
	Route::get('/api/applications/unprocessed', 'ApplicationController@unprocessedApi')->name('applications.unprocessedApi');
	Route::get('applications/{application}/process', 'ApplicationController@process')->name('applications.process');
	Route::get('applications/create', 'ApplicationController@create')->name('applications.create');
	Route::get('applications/{application}', 'ApplicationController@show')->name('applications.show');
	Route::patch('applications/{application}', 'ApplicationController@update')->name('applications.update');
	Route::post('applications', 'ApplicationController@store')->name('applications.store');
	Route::get('applications', 'ApplicationController@index')->name('applications.index');
	Route::get('/businesses/expiringsoon', 'BusinessController@expiringSoon')->name('businesses.expiringsoon');
	Route::resource('businesses', 'BusinessController');

	Route::get('inspections/create', 'InspectionController@create')->name('inspections.create');
	Route::get('inspections/upcoming', 'InspectionController@upcoming')->name('inspections.upcoming');
	Route::get('inspections/{inspection}/dhivehi/reports', 'InspectionDhivehiReportController@show')->name('inspections.dhivehi-reports.show');
	Route::get('dhivehi/reports/{dhivehiReport}', 'DhivehiReportController@show')->name('dhivehi-reports.show');
	Route::get('inspections/{inspection}/dhivehi/reports/edit', 'InspectionDhivehiReportController@edit')->name('inspections.dhivehi-reports.edit');
	Route::patch('/dhivehi/reports/{dhivehiReport}', 'DhivehiReportController@update')->name('dhivehi-reports.update');
	Route::get('inspections/{inspection}/english/reports', 'InspectionEnglishReportController@show')->name('inspections.english-reports.show');
	Route::post('/inspections/{inspection}/fines', 'InspectionFineController@store')->name('inspections.fines.store');
	Route::get('inspections/{inspection}', 'InspectionController@show')->name('inspections.show');
	Route::get('inspections', 'InspectionController@index')->name('inspections.index');
	Route::patch('inspections/{inspection}', 'InspectionController@update')->name('inspections.update');
	Route::delete('inspections/{inspection}', 'InspectionController@destroy')->name('inspections.destroy');


	Route::patch('/english/reports/{englishReport}', 'EnglishReportController@update')->name('english-reports.update');
	Route::patch('/english/reports/{englishReport}/critical', 'EnglishReportController@updateCritical')->name('english-reports.critical.update');
	Route::patch('/english/reports/{englishReport}/major', 'EnglishReportController@updateMajor')->name('english-reports.major.update');
	Route::patch('/english/reports/{englishReport}/other', 'EnglishReportController@updateOther')->name('english-reports.other.update');


	Route::get('api/businesses/expired', 'BusinessController@expired')->name('businesses.expired');
	Route::get('api/businesses/expiringsoon', 'BusinessController@expiringSoonApi')->name('api.businesses.expiringsoon');
	Route::get('api/inspections/upcoming', 'InspectionController@upcomingApi')->name('api.inspections.upcoming');
	Route::get('api/dhivehi/reports/{dhivehiReport}', 'DhivehiReportController@showApi')->name('dhivehi-reports.showApi');
	Route::get('api/english/reports/{englishReport}', 'EnglishReportController@showApi')->name('english-reports.showApi');
	Route::get('reports/eng/create', 'EnglishReportController@create')->name('english-reports.create');

	Route::get('businesses/{business}/edit', 'BusinessController@edit')->name('businesses.edit');
	Route::patch('businesses/{business}', 'BusinessController@update')->name('businesses.update');
	Route::get('businesses/{business}/applications/create', 'BusinessApplicationController@create')->name('businesses.applications.create');


	Route::post('api/applications/{application}/licenses', 'ApplicationLicenseController@store')->name('applications.licenses.store');
	Route::post('api/applications/{application}/businesses', 'ApplicationBusinessController@store')->name('applications.businesses.store');
	Route::post('api/businesses/{business}/inspections', 'BusinessInspectionController@store')->name('businesses.inspections.store');
	Route::post('api/businesses/{business}/gradinginspections', 'BusinessGradingInspectionController@store')->name('businesses.grading-inspections.store');
	Route::post('api/applications/{application}/inspections', 'ApplicationInspectionController@store')->name('applications.inspections.store');
	Route::get('api/businesses/search', 'BusinessController@search')->name('api.businesses.search');
	Route::get('api/businesses/{business}', 'BusinessController@showApi')->name('api.businesses.showApi');
	Route::get('api/applications', 'ApplicationController@indexApi')->name('api.applications.index');
	Route::get('api/applications/{application}', 'ApplicationController@showApi')->name('api.applications.show');
	Route::patch('api/applications/{application}/updateStatus', 'ApplicationController@updateStatus')->name('applications.updateStatus');
	Route::patch('/api/applications/{application}/businesses/detach', 'ApplicationBusinessController@detach')->name('applications.updateStatus');
	Route::patch('/api/applications/{application}/businesses/{buiness}/attach', 'ApplicationBusinessController@attach')->name('applications.updateStatus');

	Route::get('/api/inspections/{inspection}', 'InspectionController@showApi')->name('inspections.showApi');
	Route::delete('/inspections/{inspection}/fines', 'InspectionFineController@destroy')->name('inspections.fines.destroy');
	Route::patch('/api/inspections/{inspection}/updatefined', 'InspectionController@updateFined')->name('inspections.updateFined');
	Route::patch('/api/inspections/{inspection}/updatefollowup', 'InspectionController@updateFollowup')->name('inspections.update-followup');
	Route::patch('/api/inspections/{inspection}/handoverreports', 'InspectionController@handOverReports')->name('inspections.hand-over-reports');

	Route::resource('users', 'UserController');
	// Route::resource('roles', 'RoleController');
	// Route::resource('permissions', 'PermissionController');

	// Route::resource('users.roles', 'UserRoleController');
	// Route::resource('users.permissions', 'UserPermissionController');
	// Route::resource('roles.permissions', 'RolePermissionController');

});
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


