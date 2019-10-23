##Dashboard 
###Route::get('/', 'HomeController@index')->name('home');
###dashboard-search-list.blade.php
Route::get('api/businesses/search', 'BusinessController@search')->name('api.businesses.search');
Route::get('api/businesses/expiringsoon', 'BusinessController@expiringSoonApi')->name('api.businesses.expiringsoon');
Route::get('api/businesses/expired', 'BusinessController@expired')->name('api.businesses.expired');
Route::get('business/{business}', 'BusinessController@show')->name('businesses.show'); //go to business

##Show Business 
###Route::get('business/{business}', 'BusinessController@show')->name('businesses.show'); //acctualy in resource route
###business-show.blade.php
Route::get('businesses/{business}/edit', 'BusinessController@edit')->name('businesses.edit'); //edit button
Route::get('businesses/{business}/applications/create', 'BusinessApplicationController@create')->name('businesses.applications.create'); //new application button
Route::post('api/businesses/{business}/inspections', 'BusinessInspectionController@store')->name('businesses.inspections.store'); // save inspection form
Route::post('api/businesses/{business}/gradinginspections', 'BusinessGradingInspectionController@store')->name('businesses.grading-inspections.store');// save grading inspection form
#####Component [business-details]
Route::get('business/{business}', 'BusinessController@show')->name('businesses.show'); //go to business
#####Component [business-applications]
Route::get('applications/{application}', 'ApplicationController@show')->name('applications.show'); // go to application
Route::get('applications/{application}/process', 'ApplicationController@process')->name('applications.process'); // go to application process
#####Component [business-inspections]
Route::get('inspections/{inspection}', 'InspectionController@show')->name('inspections.show');
Route::get('applications/{application}/process', 'ApplicationController@process')->name('applications.process'); // go to application process
Route::get('inspections/{inspection}/dhivehi/reports/edit', 'InspectionDhivehiReportController@edit')->name('inspections.dhivehi-reports.edit'); //go to dv report edit
Route::get('inspections/{inspection}/english/reports/edit', 'InspectionEnglishReportController@edit')->name('inspections.english-reports.edit'); //go to en report edit
Route::get('normalinspections/{inspection}/normalforms/edit', 'NormalInspectionNormalFormController@edit')->name('normal-inspections.normalforms.edit'); // go to inspection form edit
#####Component [business-grading-inspections]
Route::resource('gradinginspections', 'GradingInspectionController')->only(['show']); //aslu its useless route, just for permissions
Route::get('gradinginspections/{inspection}/gradingforms/edit', 'GradingInspectionGradingFormController@edit')->name('grading-inspections.gradingforms.edit'); //go to edit button
Route::get('gradinginspections/{inspection}/edit', 'GradingInspectionController@edit')->name('grading-inspections.edit');
#####Component [business-fines]
Route::resource('fines', 'FineController')->only(['show']); //aslu its useless route, just for permissions
Route::post('/uploads/fines/{fine}/receipt', 'FineController@uploadReceipt')->name('uploads.fines.receipt');
Route::get('/fines/{fine}/receipt', 'FineController@viewReceipt')->name('fines.receipt.show');
#####Component [business-licenses]
Route::resource('licenses', 'LicenseController')->only(['show']);//aslu its useless route, just for permissions
Route::get('applications/{application}', 'ApplicationController@show')->name('applications.show'); //application id link <th>s
Route::post('/uploads/licenses/{license}/receipt', 'LicenseController@uploadReceipt')->name('uploads.licenses.receipt');
Route::get('/licenses/{license}/receipt', 'LicenseController@viewReceipt')->name('licenses.receipt.show');
#####Component [business-terminations]
Route::resource('businesses.terminations', 'BusinessTerminationController')->only(['businesses.terminations.show']); //aslu its useless route, just for permissions


##New Application
###Route::get('applications/create', 'ApplicationController@create')->name('applications.create');
###applications-create.blade.php
Route::post('applications', 'ApplicationController@store')->name('applications.store'); //save application form
Route::get('applications/{application}/edit', 'ApplicationController@edit')->name('applications.edit'); //go to the newly created application form or edit

##Draft Applications
###Route::get('/applications/draft', 'ApplicationController@draft')->name('applications.draft');
###applications-draft.blade.php
Route::get('/api/applications/draft', 'ApplicationController@draftApi')->name('applications.draftApi');
Route::get('applications/{application}/edit', 'ApplicationController@edit')->name('applications.edit'); //go to the newly created application form or edit


##Pending Applications
###Route::get('/applications/pending', 'ApplicationController@pending')->name('applications.pending');
###applications-pending.blade.php
Route::get('/api/applications/pending', 'ApplicationController@pendingApi')->name('applications.pendingApi');
Route::get('applications/{application}/process', 'ApplicationController@process')->name('applications.process');

##Upcoming Inspections
###Route::get('inspections/upcoming', 'InspectionController@upcoming')->name('inspections.upcoming');
###upcomming-inspections-index.blade.php
Route::patch('inspections/{inspection}', 'InspectionController@update')->name('inspections.update'); //edit mode on
Route::get('inspections/{inspection}', 'InspectionController@show')->name('inspections.show'); //go to inspection
Route::get('normalinspections/{inspection}/normalforms/edit', 'NormalInspectionNormalFormController@edit')->name('normal-inspections.normalforms.edit');

##Inspection forms to be processed
###Route::get('normalforms/pending', 'NormalFormController@pending')->name('normal-forms.pending');
###normal-forms-pending.blade.php
Route::get('/api/normalforms/pending', 'NormalFormController@pendingApi')->name('normal-forms.pendingApi');
Route::get('normalforms/{normalForm}/process', 'NormalFormController@process')->name('normal-forms.process');

##Processed Inspection Forms
###Route::get('/normalforms/processed', 'NormalFormController@processed')->name('normal-forms.processed');
###normal-forms-processed.blade.php
Route::get('/api/normalforms/processed', 'NormalFormController@processedApi')->name('normal-forms.processedApi');
Route::get('normalforms/{normalForm}', 'NormalFormController@show')->name('normal-forms.show');
Route::get('inspections/{inspection}/dhivehi/reports/edit', 'InspectionDhivehiReportController@edit')->name('inspections.dhivehi-reports.edit');
Route::get('inspections/{inspection}/english/reports/edit', 'InspectionEnglishReportController@edit')->name('inspections.english-reports.edit');
Route::get('inspections/{inspection}', 'InspectionController@show')->name('inspections.show');

##Processed Inspection Forms having Pending Reports
###Route::get('/inspections/reports/pending', 'InspectionReportController@pendingReports')->name('inspections.pending-reports');
###inspections-pending-reports.blade.php
Route::get('/api/inspections/reports/pending', 'InspectionReportController@pendingReportsApi')->name('api.inspections.pending-reports');
Route::get('normalforms/{normalForm}', 'NormalFormController@show')->name('normal-forms.show');
Route::get('dhivehi/reports/{dhivehiReport}/process', 'DhivehiReportController@process')->name('dhivehi-reports.process');
Route::get('english/reports/{englishReport}/process', 'EnglishReportController@process')->name('english-reports.process');
Route::get('inspections/{inspection}', 'InspectionController@show')->name('inspections.show');

##Processed Inspection Forms having Processed Reports
###Route::get('/inspections/reports/processed', 'InspectionReportController@processedReports')->name('inspections.processed-reports');
###inspections-processed-reports.blade.php
Route::get('/api/inspections/reports/processed', 'InspectionReportController@processedReportsApi')->name('api.inspections.processed-reports');
Route::get('normalforms/{normalForm}', 'NormalFormController@show')->name('normal-forms.show');
Route::get('dhivehi/reports/{dhivehiReport}/process', 'DhivehiReportController@process')->name('dhivehi-reports.process');
Route::get('english/reports/{englishReport}/process', 'EnglishReportController@process')->name('english-reports.process');
Route::get('inspections/{inspection}/finish', 'InspectionController@finish')->name('inspections.finish');

##Manage
###Route::get('/manage', 'HomeController@manage')->name('manage');
###manage.blade.php
Route::get('/dashboard', 'ACLController@dashboard')->name('acl.dashboard'); //acl prefixed
Route::get('applications', 'ApplicationController@index')->name('applications.index');
Route::get('gradingpoints/manage', 'GradingPointController@manageGradingPoints')->name('grading-points.manage');
Route::get('gradingcategories/manage', 'GradingCategoryController@manageGradingCategories')->name('grading-categories.manage');
Route::get('normalpoints/manage', 'NormalPointController@manageNormalPoints')->name('normal-points.manage');
Route::get('normalcategories/manage', 'NormalCategoryController@manageNormalCategories')->name('normal-categories.manage');

-----------------------------------------------------------------------------------

##Manage > Manage Grading Points
###Route::get('gradingpoints/manage', 'GradingPointController@manageGradingPoints')->name('grading-points.manage');
###manage-grading-points.blade.php
Route::get('/manage', 'HomeController@manage')->name('manage'); //back to manage
Route::get('api/gradingpoints', 'GradingPointController@indexApi')->name('grading-points.indexApi');
Route::post('api/gradingpoints', 'GradingPointController@storeApi')->name('grading-points.storeApi');
Route::get('gradingpoints/{gradingPoint}/edit', 'GradingPointController@edit')->name('grading-points.edit');

##Manage > Manage Grading Categories
###Route::get('gradingcategories/manage', 'GradingCategoryController@manageGradingCategories')->name('grading-categories.manage');
###manage-grading-categories.blade.php
Route::get('/manage', 'HomeController@manage')->name('manage'); //back to manage
Route::post('api/gradingcategories', 'GradingCategoryController@storeApi')->name('grading-categories.storeApi');
Route::get('api/gradingcategories', 'GradingCategoryController@indexApi')->name('grading-categories.indexApi');
Route::get('gradingcategories/{gradingCategory}/edit', 'GradingCategoryController@edit')->name('grading-categories.edit');

##Manage > Manage Normal Points
###Route::get('normalpoints/manage', 'NormalPointController@manageNormalPoints')->name('normal-points.manage');
###manage-normal-points.blade.php
Route::get('/manage', 'HomeController@manage')->name('manage'); //back to manage
Route::post('api/normalpoints', 'NormalPointController@storeApi')->name('normal-points.storeApi');
Route::get('api/normalpoints', 'NormalPointController@indexApi')->name('normal-points.indexApi');
Route::get('normalpoints/{normalPoint}/edit', 'NormalPointController@edit')->name('normal-points.edit');

##Manage > Manage Normal Points
###Route::get('normalcategories/manage', 'NormalCategoryController@manageNormalCategories')->name('normal-categories.manage');
###manage-normal-categories.blade.php
Route::get('/manage', 'HomeController@manage')->name('manage'); //back to manage
Route::post('api/normalcategories', 'NormalCategoryController@storeApi')->name('normal-categories.storeApi');
Route::get('api/normalcategories', 'NormalCategoryController@indexApi')->name('normal-categories.indexApi');
Route::get('normalcategories/{normalCategory}/edit', 'NormalCategoryController@edit')->name('normal-categories.edit');

------------------------------

##‫ACL Dashboard
###Route::get('/dashboard', 'ACLController@dashboard')->name('acl.dashboard'); //acl prefixed
###acl.acl-dashboard.blade.php
Route::post('users', 'UserController')->name('users.store');
Route::post('roles', 'RoleController')->name('roles.store');
#####Component [acl-roles]
Route::get('roles', 'RoleController@index')->name('roles.index');
Route::delete('roles/{id}', 'RoleController@destroy')->name('roles.destroy');
Route::patch('roles/{id}', 'RoleController@update')->name('roles.update');
#####Component [acl-users]
Route::get('users', 'UserController@index')->name('users.index');
Route::delete('users/{id}', 'UserController@destroy')->name('users.destroy');
#####Component [acl-permissions]
Route::get('permissions', 'PermissionController@index')->name('permissions.index');
------------------------------

##‫ކާބޯތަކެތީގެ ޚިދުމަތްދޭ ތަންތަން ބަލާ ފާސްކުރާ ޗެކްލިސްޓް
###Route::get('normalinspections/{inspection}/normalforms/edit', 'NormalInspectionNormalFormController@edit')->name('normal-inspections.normalforms.edit');
###normal-form-edit.blade.php
TODO





#TODOS
take care of applications-create.blade.php php form post, change it to axios post
