<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['welcome'] 										= 'welcome';   // For testing use only 
$route['default_controller'] 							= 'user/login';
$route['register'] 										= 'user';
$route['registration-success'] 							= 'user/registration_success';
$route['login'] 										= 'user/login';
$route['logout'] 										= 'user/logout';
$route['forgot'] 										= 'user/forgot';
$route['activation'] 									= 'user/complete_registration';
$route['valid-domain/(:any)']['get'] 					= 'user/validDomain/$1';
$route['profile'] 										= 'user/profile';
$route['user-profile'] 									= 'profile';
$route['change-password'] 								= 'profile/change_password';
$route['profile-image-change'] 							= 'profile/profile_pic_upload';
$route['dump']											= 'DumpController';
$route['get-dump']['post']								= 'DumpController/get_dump';
//$route['form-version/(:any)']['get']					= 'create_form/formVersion/$1';
$route['form-version']['post']							= 'create_form/formVersion';
$route['create-form-upload'] 							= 'create_form/import';
$route['forms-list'] 									= 'create_form/forms_list';
$route['forms-add'] 									= 'create_form/index';
//$route['forms-edit/?(:any)?/?(:any)?']['get']			= 'create_form/edit_form/$1/$2';
$route['forms-edit/(:any)/(:any)/(:any)']['get']		= 'create_form/edit_form/$1/$2/$3';
$route['forms-update']['post']							= 'create_form/form_update';
$route['forms-delete/(:any)']['get']					= 'create_form/delete_form/$1';
$route['create-form/(:any)'] 							= 'create_form/create_Uiform_index/$1';
$route['custom-rating-save'] 							= 'create_form/custom_rating_insert';
$route['custom-rating-update'] 							= 'create_form/custom_rating_form_edit';

$route['create-form-save']['post']						= 'create_form/create_Uiform';
$route['form-status']['post']							= 'create_form/changeFormStatus';
$route['form-details']['post']							= 'create_form/form_details';    		// for get lob for particular form from form details
$route['Get-details']['post']							= 'create_form/get_details';    	// for get form for particular lob from form details
$route['Get-Versions']['post']							= 'create_form/form_versions';    	// for get form for particular lob from form details
$route['get-category']['post']							= 'create_form/get_category';    	// for get category for particular lob from forms
$route['get-attributes']['post']						= 'create_form/get_attributes';    	// for get attributes for particular category from forms
$route['Get-Unique-Form']['post']						= 'create_form/unique_form_check';    	// for check unique form name from form details
$route['Sub-varsion-count-check']['post']				= 'create_form/subscriptionEvaFormVersion_count_check';    	// for check unique form name from form details
$route['Agent-QA-Performance']							= 'ReportsController';
$route['Agent-QA-Performance-Report']['post']			= 'ReportsController/agent_qa_performance';
$route['Agent-QA-Performance-Report-list']['post']		= 'ReportsController/agent_qa_performance_list';
//$route['Scorecard-Performance']							= 'ReportsController/scorecard_performance_index';
$route['attribute-report']								= 'ReportsController/scorecard_performance_index';
$route['Scorecard-Performance-Report']['post']			= 'ReportsController/scorecard_performance_report';
$route['Scorecard-Performance-Report-list']['post']		= 'ReportsController/scorecard_performance_report_list';
$route['Fatal-Report']									= 'ReportsController/fatal_index';
$route['Fatal-Report-List']['post']						= 'ReportsController/fatal_report';
$route['Fatal-Report-Audit-List']['post']				= 'ReportsController/audit_list';
$route['Autofail-Report']								= 'ReportsController/autofail_index';
$route['autofail-audit-summary']['post']				= 'ReportsController/autofail_audit_summary';
$route['autofail-attrubutes-summary']['post']			= 'ReportsController/autofail_attrubutes_summary';
$route['autofail-Report-List']['post']					= 'ReportsController/autofail_report';
$route['autofail-report-audit-list']['post']			= 'ReportsController/autofail_audit_list';
$route['tag-report']									= 'ReportsController/tag_report_index';
$route['tag-report-list']['post']						= 'ReportsController/tag_report';
$route['tag-report-audit-list']['post']					= 'ReportsController/tag_audit_list';
$route['tag-report-audit-list-kpi']['post']				= 'ReportsController/tag_audit_list_kpi';
// End Rajesh

//$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
//added by amit
$route['hierarchy'] 									= 'hierarchy_management';
$route['client_user'] 									= 'client_user';
$route['create_form'] 									= 'create_form';
$route['audit-history'] 								= 'Audit_history';
$route['get-forms']['post']								= 'Audit_history/getForms';
$route['audit-data']['post']							= 'Audit_history/auditData';
$route['form-view/?(:any)?/?(:any)?/?(:any)?/?(:any)?'] = 'forms/select/$1/$2/$3/$4';
$route['content-upload']['post'] 						= 'forms/contentUpload';
//// added By Santosh
// Agent 
// $route['add_agent']['get']							= 'Agent';
// $route['edit_agent/(:any)'] 							= 'Agent/EditAgent/$1';
// $route['invalid_agent'] 								= 'Agent/invalid';
// $route['agent_roster_upload'] 						= 'Agent/roster';
// $route['import_agent_roster'] 						= 'Agent/import';// csv upload
// $route['addAgent'] 									= 'Agent/addAgent';
// $route['delete_agent'] 								= 'Agent/deleteAgent';
$route['agent-hierarchy']['get']						= 'Agent/agentHierarchy';
$route['ah/(:any)/(:any)']['get']						= 'Agent/agentHierarchyDetails/$1/$2';
// $route['team-csv-upload']['get']						= 'Agent/roster';

//User Management
$route['team']['get']									= 'Agent/Team';           	  			/*Add And List Team View*/
$route['team-ajax']                                     = 'Agent/TeamAjax';                     /*Fetch Team & Hierarchy List in Ajax*/
$route['isSupervisor']['post']							= 'Agent/isSupervisor';           	  	/*Add And List Team View*/
$route['add-team']['post']								= 'Agent/addTeam';			  			/*Add Employee Data*/
$route['edit-team/(:any)']['get']                       = 'Agent/editTeam/$1';                  /*Edit Employee View*/
$route['update-team']['post']							= 'Agent/updateTeam';       			/*Update employee data*/
$route['updateStatus']['post']							= 'Agent/updateStatus';    				/*active inactive*/
$route['team-roster']['get']							= 'Agent/TeamRoster';      				/*Employee CSV Uplode*/
$route['add-team-roster']['post']						= 'Agent/importTeamCSV'; 				/*Add data through CSV*/
$route['in-active-team']['get']							= 'Agent/inActiveTeam';  				/*get Inactive Employee*/
$route['lob-data/(:any)']['get']						= 'Agent/lobData/$1';
$route['get-supervisor/(:any)']['get']					= 'Agent/getSupervisor/$1';
$route['get-supervisor-details/(:any)']['get']			= 'Agent/getSupervisorDetails/$1';
$route['user-form-data']['post']						= 'Agent/getUserFormDetails';    		/*Employee form data based on employee id*/
$route['user-details']['post']                          = 'Agent/getUserDetails';               /*Employee form data based on employee id*/
// End Agent 

// Hierarchy_management (added by shafquat)
$route['hierarchy'] 									= 'hierarchy_management';
$route['get-hierarchy'] 								= 'hierarchy_management/ajax_hierarchy';
$route['form_type']['post']								= 'Hierarchy_management/formType';
//$route['edit-hierarchy/(:any)']['get']					= 'Hierarchy_management/editHierarchy/$1';
//$route['update-hierarchy']['post']						= 'Hierarchy_management/updateHierarchyData';
$route['delete-hierarchy']['delete']					= 'Hierarchy_management/deleteHierarchy';
// End Hierarchy_management

// User Registration	
$route['add_role']['get']								=	'AdminController/userRole';
$route['user_role_data']['post']						=	'AdminController/userRoleData';
$route['delete_role']['delete']							=	'AdminController/userRoleDelete';
$route['update_role']['put']							=	'AdminController/userRoleUpdate';
$route['add_user']['get']								=	'AdminController/AddUser';
$route['user_data']['post']								=	'AdminController/AddUserData';
$route['Edit-user/(:any)']['get']						=	'AdminController/EditUser/$1';
$route['edit_user_data']['post']						=	'AdminController/EditUserData';
$route['user_permission/?(:any)?']['get']				=	'AdminController/userPermission/$1';
$route['user_permission_data']['post']					=	'AdminController/userPermissionData';
// End User Registration	

// Payment
$route['payment']['get']								=	'PaymentController/index';
$route['invoice']['get']								=	'PaymentController/invoice';
$route['paymet/(:any)/(:any)']['get']					=	'PaymentController/paymet/$1/$2';
// End Payment 
$route['forgot-password']['post']						=	'User/forgotPassword';
$route['reset-password/(:any)']['get']					=	'User/resetPassword/$1';
$route['resetPassword']['post']				    		=	'User/rPassword';
$route['reset-password']['get']				    		=	'User/firstTimeLogin';
$route['change_password']['post']			    		=	'User/ChangeLoginPassword';
// Dashboard
$route['dashboard']										=	'DashboardController/index';
$route['get-cat']['post']								=	'DashboardController/getCategory';
$route['get-attribute-data']['post']					=	'DashboardController/getArrtibuteQAScore';
$route['get-lob-data']['post']							=	'DashboardController/getLobSearchData';
$route['filter']['post']								=	'DashboardController/chartFilter';
$route['attribute-filter']['post']						=	'DashboardController/attrFilter';
$route['category-filter']['post']						=	'DashboardController/catFilter';
$route['action-items-filter']['post']					=	'DashboardController/actionItemFilter';
$route['top-templates-filter']['post']					=	'DashboardController/topFaildAttributeResponseFilter';
// End Dashboard
// Team View
$route['team-view']['get']								=	'TeamViewController/index';   
$route['emp-all-audit-data']['post']					= 	'TeamViewController/employeeAuditData'; 
// End Team View
// permission
$route['permission-denied']['get']						=	'permissionController';
// Permission
// Subscription Details
$route['Subscription']['get']							=	'SubscriptionController';

$route['upgrade-subscription/(:any)']['get']			=	'PaymentController/upgradeSubscriptionPlan/$1';
// End Subscription Details
// End Santosh
//Temp
$route['dashboard_new'] 								= 'DashboardController/sanju';
$route['dashboard_new_customer'] 						= 'DashboardController/sanju_new_customer';
$route['reset-dashboard-filter'] 						= 'DashboardController/resetDashboardFilter';

// Start Other Route

$route['user-management']['get']							=	'UserManagementController';
$route['user-management/users/?(:any)?/?(:any)?']['get']	=	'UserManagementController/users/$1/$2';
$route['add-group']['post']									=	'UserManagementController/addGroup';
$route['edit-group']['post']								=	'UserManagementController/editGroup';
$route['group-by-site']['post']								=	'UserManagementController/groupBySite';

$route['del-group']['post']									=	'UserManagementController/deleteGroup';
$route['add-site']['post']									=	'UserManagementController/addSite';
$route['del-site']['post']									=	'UserManagementController/deleteSite';
$route['edit-site']['post']									=	'UserManagementController/editSite';
$route['add-user']['post']									=	'UserManagementController/addUser';
$route['del-user']['post']									=	'UserManagementController/deleteUser';
$route['user-bulk-upload']['post']							=	'UserManagementController/userBulkUpload';
$route['my-history']['get']									=	'SupervisorController/myHistory';
$route['my-history-data']['post']							=	'SupervisorController/myHistoryData';
$route['template-data']['post']								=	'DashboardController/getTemplateSiteGrousWise';
$route['auditor-filter']['post']							= 	'DashboardController/auditoFilter';
$route['temp-opt']['post']									= 	'DashboardController/getTemplateResponse';
$route['temp-response-data']['post']						= 	'DashboardController/getTemplateResponseData';
$route['dashboard-filter-data']['post']						= 	'DashboardController/getDashboardFilterData';
$route['alert-management']['get']  							=	'AlertManagementController';
$route['template-details']['post']  						=	'AlertManagementController/templateDetails';
$route['user-list']['post']  								=	'AlertManagementController/userList';
$route['notify-response']['post']  							=	'AlertManagementController/notifyResponse';
$route['notify-response-details']['post']  					=	'AlertManagementController/notifyResponseDetails';
$route['notify-status']['post']  							=	'AlertManagementController/notifyStatus';
$route['get-sites-data']['post']  							=	'UserManagementController/getSites';
$route['get-group-data']['post']  							=	'UserManagementController/getGroup';
// Report Module
$route['action-items'] 									    = 'ReportController/actionItems';   
$route['audit-summary']									    = 'ReportController/AuditSummary';
$route['audit-details']									    = 'ReportController/AuditDetails';
$route['alert-submit'] 									    = 'ReportController/alertSubmit';
$route['attribute_report']									= 'ReportController/attributeReport';
$route['attribute-report-details']['post']					= 'ReportController/attributeReportDetails';
// Report Module
// NON BPO template RAJESH
$route['welcome-setup']['get']								=	'WelcomeSetupController';				//0
$route['welcome-setup/templates']['get']					=	'WelcomeSetupController/templates';			//1
//$route['welcome-setup/template-create']['get']			=	'WelcomeSetupController/templates_create'; 	//2
$route['welcome-setup/site-setup']['get']					=	'WelcomeSetupController/site_setup'; 		//3
//$route['welcome-setup/template-edit/(:any)']['get']		= 	'TemplateController/template_edit/$1';		//4
$route['welcome-setup/complated']['get']					=	'WelcomeSetupController/setup_complate';	//0
$route['welcome-setup-skip/(:any)']['get']					=	'WelcomeSetupController/skip_setup/$1';	

$route['template-details/?(:any)?']['get']  				=	'TemplateController';
$route['template-save']['post']  							=	'TemplateController/template_insert';
$route['template-update']['post']  							=	'TemplateController/template_update';
$route['template-copy']['post']  						    =    'TemplateController/template_copy';
$route['template-preview']  							    =	'TemplateController/form_preview';
$route['get-unique-template']['post']						= 	'TemplateController/unique_template_check';    	// for check unique template name from template detail

//NON BPO routs Amit
$route['template/(:any)?/?(:any)?/?(:any)?']                = 'TemplateViewController/select/$1/$2/$3';
$route['get-templates']['post']							    = 'DumpController/get_templates';
$route['attr-file-upload']['post']							= 'TemplateViewController/attrFileUpload';
$route['del-attr-file/(:any)']['get']						= 'TemplateViewController/detAttrFileUpload/$1';


//=======
$route['get-unique-template']['post']						= 	'TemplateController/unique_template_check';    	// for check unique template name from template details
$route['template-list'] 									= 	'TemplateController/template_list';
$route['other-template-list/?(:any)?'] 						= 	'TemplateController/template_list_others/$1';
//$route['other-template-list'] 							= 	'TemplateController/template_list_others';
$route['template-status']['post']							= 	'TemplateController/changeTempStatus';
//$route['template-delete']['post']							= 	'TemplateController/delete_template';
$route['template-delete/(:any)']['get']						= 	'TemplateController/delete_template/$1';
$route['template-share']['post']							= 	'TemplateController/share_template';
$route['template-share-list']['post']						= 	'TemplateController/template_share_list';
$route['template-edit/(:any)/?(:any)?/?(:any)?']['get']		= 	'TemplateController/template_edit/$1/$2/$3';
//$route['template-pre/(:any)']['get']						= 	'TemplateController/template_pre/$1';

// End Other Route
$route['supervisor']                                        =     'SupervisorController';
$route['bucket']                                            =     'SupervisorController/myBucket';
/// Custom Kpi
$route['kpi']['get']									    = 	'TemplateController/custom_kpi';
$route['attribute-list-kpi']['post'] 					    = 	'TemplateController/attribute_list_kpi';
$route['kpi-insert']['post'] 					            = 	'TemplateController/kpi_add';
$route['kpi-delete']['post'] 					            = 	'TemplateController/kpi_delete';
$route['kpi-update']['post'] 					            = 	'TemplateController/kpi_update';
$route['kpi-save']['post'] 					                = 	'TemplateController/kpi_save';
$route['getFromData']['post']                               =   'SupervisorController/getTemplateData';
$route['statusChangeAccTat']['post']                        =   'Ajaxdata/statusChangeAccordingTat';