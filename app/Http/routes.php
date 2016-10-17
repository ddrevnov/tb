<?php

Route::group(['middleware' => 'web'], function () {
	Route::post('/forgotpass', ['uses' => 'Auth\AuthController@forgotpass']);
	Route::post('/login', ['uses' => 'Auth\AuthController@login']);

	Route::auth();
	Route::group(['middleware' => 'auth'], function () {
		Route::group(['prefix' => 'backend'], function () {
			Route::group(['namespace' => 'Director'], function () {

				Route::get('/', ['as' => 'director', 'uses' => 'DirectorController@index']);
				Route::get('/search', ['uses' => 'DirectorController@search']);
				Route::post('/check_email', ['uses' => 'DirectorController@checkEmail']);
				Route::post('/get_dashboard', ['uses' => 'DirectorDashboardController@getDashboard']);
				Route::post('/get_new_messages', ['uses' => 'DirectorMessagesController@getNewMessages']);
				Route::post('/get_notice', ['uses' => 'DirectorNoticeController@getNotice']);
				Route::post('/delete_notice', ['uses' => 'DirectorNoticeController@deleteNotice']);
				Route::post('/get_location', ['uses' => 'DirectorController@getLocation']);


				Route::group(['namespace' => 'Admins'], function () {
					Route::get('/admins_new/{id}', ['as' => 'admin_info_new', 'uses' => 'DirectorNewAdminController@adminInfoNew']);
					Route::get('/admin_create', ['uses' => 'DirectorNewAdminController@createAdmin']);
					Route::post('/new_admin_store', ['uses' => 'DirectorNewAdminController@newAdminStore']);

					Route::group(['prefix' => 'admins'], function () {
						Route::get('/', ['as' => 'admins', 'uses' => 'DirectorAdminsController@admins']);
						Route::group(['prefix' => '{admin}'], function () {
							Route::get('/', ['as' => 'admin_info', 'uses' => 'DirectorSingleAdminController@adminInfo']);
							Route::post('/get_personal_info', ['uses' => 'DirectorSingleAdminController@getAdminPersonalInfo']);
							Route::post('/get_worktimes', ['uses' => 'DirectorSingleAdminController@getAdminWorkTimes']);
							Route::post('/store_logo', ['uses' => 'DirectorSingleAdminController@storeLogo']);
							Route::post('/store_avatar', ['uses' => 'DirectorSingleAdminController@storeAvatar']);
							Route::post('/set_personal_info', ['uses' => 'DirectorSingleAdminController@setAdminPersonalInfo']);
							Route::post('/set_password', ['uses' => 'DirectorSingleAdminController@setAdminPassword']);
							Route::post('/set_email', ['uses' => 'DirectorSingleAdminController@setAdminEmail']);
							Route::post('/edit_worktimes', ['uses' => 'DirectorSingleAdminController@setAdminWorkTimes']);

							Route::post('/get_category_services', ['uses' => 'DirectorAdminServicesController@getAdminCategoryServices']);
							Route::post('/createcategory', ['uses' => 'DirectorAdminServicesController@createServiceCategory']);
							Route::post('/editcategory', ['uses' => 'DirectorAdminServicesController@editServiceCategory']);
							Route::post('/removecategory', ['uses' => 'DirectorAdminServicesController@removeServiceCategory']);
							Route::post('/createservice', ['uses' => 'DirectorAdminServicesController@createService']);
							Route::post('/editservice', ['uses' => 'DirectorAdminServicesController@editService']);
							Route::post('/removeservice', ['uses' => 'DirectorAdminServicesController@removeService']);

							Route::get('/create_employee', ['uses' => 'DirectorAdminEmployeeController@createAdminEmployee']);
							Route::post('/admin_empl_store', ['uses' => 'DirectorAdminEmployeeController@adminEmployeeStore']);
						});

						Route::group(['prefix' => 'edit_employee/{employee}'], function () {
							Route::get('/', ['uses' => 'DirectorAdminEmployeeController@editAdminEmployee']);
							Route::post('/get_personal_info', ['uses' => 'DirectorAdminEmployeeController@getAdminEmployee']);
							Route::post('/set_personal_info', ['uses' => 'DirectorAdminEmployeeController@setAdminEmployee']);
							Route::post('/set_password', ['uses' => 'DirectorAdminEmployeeController@setAdminEmployeePassword']);
							Route::post('/set_email', ['uses' => 'DirectorAdminEmployeeController@setAdminEmployeeEmail']);
							Route::post('/store_avatar', ['uses' => 'DirectorAdminEmployeeController@storeAdminEmployeeAvatar']);
							Route::post('/update_services', ['uses' => 'DirectorAdminEmployeeController@updateAdminEmployeeService']);
						});

					});
				});

				Route::get('/clients', ['uses' => 'DirectorClientsController@clients']);
				Route::get('/clients/{client}', ['as' => 'd_client_info', 'uses' => 'DirectorClientsController@clientInfo']);


				Route::group(['namespace' => 'Orders'], function () {
					Route::group(['prefix' => 'orders'], function () {
						Route::get('/', ['uses' => 'DirectorOrdersController@orders']);
						Route::post('/get_orders', ['uses' => 'DirectorOrdersController@getOrders']);
						Route::post('/get_bank_info', ['uses' => 'DirectorOrdersController@getBankDetails']);
						Route::post('/get_legal_address', ['uses' => 'DirectorOrdersController@getLegalAddress']);
						Route::post('/update_bank_details', ['uses' => 'DirectorOrdersController@setBankDetails']);
						Route::post('/update_legal_address', ['uses' => 'DirectorOrdersController@setLegalAddress']);
						Route::post('/store_logo', ['uses' => 'DirectorOrdersController@storeLogo']);
						Route::post('/confirm_order', ['uses' => 'DirectorOrdersController@confirmOrder']);
						Route::post('/search', ['uses' => 'DirectorOrdersController@searchOrder']);
						Route::any('/download/{order}', ['uses' => 'DirectorOrdersController@downloadOrder']);
						Route::any('/send/{order}', ['uses' => 'DirectorOrdersController@sendOrder']);
						Route::any('/cancel/{order}', ['uses' => 'DirectorOrdersController@cancelOrder']);
					});
				});

				Route::group(['prefix' => 'tariffs'], function () {
					Route::get('/', ['as' => 'tariffs', 'uses' => 'DirectorTariffsController@tariffs']);
					Route::get('/create', ['uses' => 'DirectorTariffsController@createTariff']);
					Route::get('/edit/{id}', ['uses' => 'DirectorTariffsController@editTariff']);
					Route::get('/remove/{id}', ['uses' => 'DirectorTariffsController@removeTariff']);
					Route::post('/store', ['uses' => 'DirectorTariffsController@storeTariff']);
				});

				Route::get('/notice', ['uses' => 'DirectorNoticeController@notice']);

				Route::group(['prefix' => 'messages'], function () {
					Route::get('/', ['uses' => 'DirectorMessagesController@messages']);
					Route::get('/{id}', ['uses' => 'DirectorMessagesController@messages']);
					Route::post('/get_user', ['uses' => 'DirectorMessagesController@getUserChat']);
					Route::post('/send_message', ['uses' => 'DirectorMessagesController@sendMessage']);
				});

				Route::get('/newsletter', ['as' => 'director_newsletter', 'uses' => 'MailController@indexMail']);
				Route::get('/newsletter/{id}', ['uses' => 'MailController@showMail']);
				Route::get('/newsletter2', ['uses' => 'MailController@createMail']);
				Route::get('/newsletter2/{id}', ['uses' => 'MailController@editMail']);
				Route::post('/newsletter_store', ['uses' => 'MailController@storeMail']);
				Route::post('/newsletter_save', ['uses' => 'MailController@saveMail']);
				Route::get('/get_admin_email', ['uses' => 'MailController@getAdminsEmail']);
				Route::post('/getemail', ['uses' => 'MailController@getMail']);


				Route::get('/employees', ['uses' => 'DirectorEmployeesController@employees']);
				Route::get('/employee_create', ['uses' => 'DirectorEmployeesController@create']);
				Route::post('/employee_store', ['uses' => 'DirectorEmployeesController@store']);


				Route::group(['prefix' => 'employee_info/{directorEmployee}'], function () {
					Route::get('', ['uses' => 'DirectorEmployeesController@employeeInfo']);
					Route::post('/get_personal_info', ['uses' => 'DirectorEmployeesController@getEmployeeInfo']);
					Route::post('/set_personal_info', ['uses' => 'DirectorEmployeesController@setEmployeeInfo']);
					Route::post('/set_password', ['uses' => 'DirectorEmployeesController@setPassword']);
					Route::post('/set_email', ['uses' => 'DirectorEmployeesController@setEmail']);
					Route::post('/store_avatar', ['uses' => 'DirectorEmployeesController@storeAvatar']);
				});

				Route::group(['namespace' => 'SMS', 'prefix' => 'sms'], function (){
					Route::get('/', ['uses' => 'DirectorSMSController@index']);
					Route::get('/create', ['uses' => 'DirectorSMSController@create']);
					Route::post('/store', ['uses' => 'DirectorSMSController@store']);
					Route::get('/delete/{package}', ['uses' => 'DirectorSMSController@delete']);
					Route::post('/edit/{package}', ['uses' => 'DirectorSMSController@edit']);
					Route::post('/show_sms_statistic', ['uses' => 'DirectorSMSController@showSMSStatistic']);
				});

				Route::get('/profil', ['uses' => 'DirectorProfilController@profil']);
				Route::post('/profil/get_personal_info', ['uses' => 'DirectorProfilController@getPersonalInfo']);
				Route::post('/profil/set_personal_info', ['uses' => 'DirectorProfilController@setPersonalInfo']);
				Route::post('/profil/set_password', ['uses' => 'DirectorProfilController@setPassword']);
				Route::post('/profil/set_email', ['uses' => 'DirectorProfilController@setEmail']);


				Route::post('/profil_edit', ['uses' => 'DirectorProfilController@profilEdit']);
				Route::any('/storeavatar', ['uses' => 'DirectorProfilController@storeAvatar']);


				Route::get('/settings1', ['uses' => 'DirectorProfilController@settings1']);
				Route::get('/settings2', ['uses' => 'DirectorProfilController@settings2']);
				Route::get('/settings3', ['uses' => 'DirectorProfilController@settings3']);
				Route::get('/settings4', ['uses' => 'DirectorProfilController@settings4']);
			});
		});

		Route::group(['domain' => '{subdomain}.' . env('MAIN_DOMAIN')], function () {
			Route::group(['namespace' => 'Admin', 'middleware' => ['statusAdmin', 'SessionLogout']], function () {
				Route::group(['prefix' => 'office'], function () {
					Route::get('/', ['as' => 'admin', 'uses' => 'AdminController@index']);
					Route::post('/get_new_messages', ['uses' => 'AdminMessagesController@getNewMessages']);
					Route::post('/get_dashboard', ['uses' => 'AdminDashboardController@getDashboard']);
					Route::get('/orders_list', ['as' => 'orders_list', 'uses' => 'AdminOrdersController@ordersList']);
					Route::get('/search', ['uses' => 'AdminController@search']);
					Route::get('/set_locale/{loc}', ['uses' => 'AdminController@setLocale']);

					Route::group(['prefix' => 'start_assistant'], function () {
						Route::get('/', ['uses' => 'AdminStartAssistantController@startAssistant']);
						Route::post('/get_start_data', ['uses' => 'AdminStartAssistantController@getStartData']);
						Route::post('/store_logo', ['uses' => 'AdminStartAssistantController@storeLogo']);
						Route::post('/store_avatar', ['uses' => 'AdminStartAssistantController@storeAvatar']);
						Route::post('/confirm', ['uses' => 'AdminStartAssistantController@confirm']);
					});

					Route::get('/gastebuch', ['uses' => 'AdminController@gastebuch']);
					Route::get('/kalendar', ['uses' => 'CalendarController@indexCalendar']);
					Route::post('/kalendar/get_clients', ['uses' => 'CalendarController@getClients']);

					Route::post('/add_calendar', ['uses' => 'CalendarController@addCalendar']);
					Route::post('/add_holiday', ['uses' => 'CalendarController@addHoliday']);
					Route::post('/get_calendar', ['uses' => 'CalendarController@getCalendar']);
					Route::post('/check_employee', ['uses' => 'CalendarController@checkEmployee']);
					Route::post('/get_employees', ['uses' => 'CalendarController@getEmployees']);
					Route::post('/get_services', ['uses' => 'CalendarController@getServices']);

					Route::post('/check_email', ['uses' => 'CalendarController@checkEmail']);

					Route::group(['prefix' => 'clients'], function () {
						Route::get('/', ['uses' => 'AdminClientsController@clientsList']);
						Route::get('/create', ['uses' => 'AdminClientsController@create']);
						Route::post('/store', ['uses' => 'AdminClientsController@store']);

						Route::group(['prefix' => '/info/{client}'], function () {
							Route::get('/', ['uses' => 'AdminClientsController@clientInfo']);
							Route::post('/get_personal_info', ['uses' => 'AdminClientsController@getClientInfo']);
							Route::post('/set_personal_info', ['uses' => 'AdminClientsController@setClientInfo']);
							Route::post('/set_password', ['uses' => 'AdminClientsController@setPassword']);
							Route::post('/set_email', ['uses' => 'AdminClientsController@setEmail']);
							Route::post('/store_avatar', ['uses' => 'AdminClientsController@storeAvatar']);
						});
					});

					Route::group(['namespace' => 'Services'], function () {
						Route::group(['prefix' => 'services'], function () {
							Route::get('/', ['uses' => 'AdminServicesController@services']);
							Route::post('/get_category_services', ['uses' => 'AdminServicesController@getCategoryAndServices']);
							Route::post('/createcategory', ['uses' => 'AdminCategoriesController@addNewServiceCategory']);
							Route::post('/editcategory', ['uses' => 'AdminCategoriesController@editServiceCategory']);
							Route::post('/removecategory', ['uses' => 'AdminCategoriesController@removeServiceCategory']);
							Route::post('/createservice', ['uses' => 'AdminServicesController@addNewService']);
							Route::post('/editservice', ['uses' => 'AdminServicesController@editService']);
							Route::post('/removeservice', ['uses' => 'AdminServicesController@removeService']);
						});
					});

					Route::group(['namespace' => 'Employees'], function () {
						Route::group(['prefix' => 'employees'], function () {
							Route::get('/', ['as' => 'employees', 'uses' => 'AdminEmployeeController@employeesList']);

							Route::get('/create', ['uses' => 'AdminNewEmployeeController@employeeCreate']);
							Route::post('/check_email', ['uses' => 'AdminNewEmployeeController@checkEmail']);
							Route::post('/store', ['uses' => 'AdminNewEmployeeController@employeeStore']);
							Route::post('/update_services/{employee}', ['uses' => 'AdminEmployeeController@updateEmployeeService']);
							Route::get('/delete/{employee}', ['uses' => 'AdminEmployeeController@destroy']);

							Route::group(['prefix' => 'info/{employee}'], function () {
								Route::get('/', ['uses' => 'AdminEmployeeController@employeeInfo']);
								Route::post('get_personal_info', ['uses' => 'AdminEmployeeController@getEmplInfo']);
								Route::post('/set_personal_info', ['uses' => 'AdminEmployeeController@setEmplInfo']);
								Route::post('/set_password', ['uses' => 'AdminEmployeeController@setPassword']);
								Route::post('/set_email', ['uses' => 'AdminEmployeeController@setEmail']);
								Route::post('/store_avatar', ['uses' => 'AdminEmployeeController@storeAvatar']);
							});
						});
					});

					Route::group(['prefix' => 'profil_admin'], function () {
						Route::get('/', ['uses' => 'AdminProfilController@profilAdmin']);
						Route::post('/get_personal_info', ['uses' => 'AdminProfilController@getPersonalInfo']);
						Route::post('/set_personal_info', ['uses' => 'AdminProfilController@setPersonalInfo']);
						Route::post('/set_password', ['uses' => 'AdminProfilController@setPassword']);
						Route::post('/set_email', ['uses' => 'AdminProfilController@setEmail']);
						Route::post('/store_avatar', ['uses' => 'AdminProfilController@storeAvatar']);

						Route::post('/to_employee', ['uses' => 'AdminProfilController@profilAdminService']);
						Route::post('/to_admin', ['uses' => 'AdminProfilController@toAdmin']);
						Route::post('/edit_services', ['uses' => 'AdminProfilController@profilAdminEditServices']);
					});

					Route::group(['prefix' => 'profil_employee'], function () {
						Route::get('/', ['uses' => 'AdminProfilController@profilEmployee']);
						Route::post('/update_services', ['uses' => 'AdminProfilController@updateEmployeeService']);
						Route::post('/get_personal_info', ['uses' => 'AdminProfilController@getEmplPersonalInfo']);
						Route::post('/set_personal_info', ['uses' => 'AdminProfilController@setEmplPersonalInfo']);
						Route::post('/set_password', ['uses' => 'AdminProfilController@setEmplPassword']);
						Route::post('/set_email', ['uses' => 'AdminProfilController@setEmplEmail']);
						Route::post('/store_avatar', ['uses' => 'AdminProfilController@storeEmplAvatar']);

						Route::post('/edit_services', ['uses' => 'AdminProfilController@profilAdminEditServices']);
					});

					Route::get('/newsletter', ['uses' => 'MailController@indexMail']);
					Route::get('/newsletter/{id}', ['uses' => 'MailController@showMail']);
					Route::get('/newsletter2', ['uses' => 'MailController@createMail']);
					Route::get('/newsletter2/{id}', ['uses' => 'MailController@editMail']);
					Route::post('/newsletter_store', ['uses' => 'MailController@storeMail']);
					Route::get('/get_client_email', ['uses' => 'MailController@getClientEmail']);

					Route::group(['namespace' => 'SMS', 'prefix' => 'sms'], function (){
						Route::get('/', ['uses' => 'AdminSMSController@index']);
						Route::post('/buy', ['uses' => 'AdminSMSController@buy']);
						Route::post('/change_notify', ['uses' => 'AdminSMSController@changeNotify']);
						Route::post('/filter_orders', ['uses' => 'AdminSMSController@filterOrders']);
						Route::post('/save_sms_content', ['uses' => 'AdminSMSController@saveSMSContent']);
						Route::post('/show_sms_statistic', ['uses' => 'AdminSMSController@showSMSStatistic']);
					});

					Route::group(['prefix' => 'messages'], function () {
						Route::get('/', ['uses' => 'AdminMessagesController@messages']);
						Route::get('/{id}', ['uses' => 'AdminMessagesController@messages']);
						Route::post('/get_user', ['uses' => 'AdminMessagesController@getUserChat']);
						Route::post('/get_new_messages', ['uses' => 'AdminMessagesController@getNewMessages']);
						Route::post('/send_message', ['uses' => 'AdminMessagesController@sendMessage']);
					});

					Route::group(['prefix' => 'notice'], function () {
						Route::get('/', ['uses' => 'AdminNoticeController@notice']);
					});
					Route::post('/get_notice', ['uses' => 'AdminNoticeController@getNotice']);
					Route::post('/delete_notice', ['uses' => 'AdminNoticeController@deleteNotice']);

					Route::group(['prefix' => 'billing'], function () {
						Route::get('/', ['uses' => 'AdminBillingController@billing']);
						Route::get('/download/{id}', ['uses' => 'AdminBillingController@downloadOrder']);
						Route::get('/download_archive', ['uses' => 'AdminBillingController@downloadArchive']);
						Route::post('/get_bank_details', ['uses' => 'AdminBillingController@getBankDetails']);
						Route::post('/set_bank_details', ['uses' => 'AdminBillingController@setBankDetails']);
						Route::any('/document', ['uses' => 'AdminBillingController@document']);
						Route::post('/refusal', ['uses' => 'AdminBillingController@refusal']);
					});

					Route::get('/firmdetails', ['uses' => 'AdminFirmDetailsController@firmdetails']);
					Route::post('/get_firm_details', ['uses' => 'AdminFirmDetailsController@getFirmDetails']);
					Route::post('/set_firm_details', ['uses' => 'AdminFirmDetailsController@setFirmDetails']);
					Route::post('/get_location', ['uses' => 'AdminController@getLocation']);
					Route::any('/aboutusedit', ['uses' => 'AdminFirmDetailsController@editAboutUs']);
					Route::any('/logoedit', ['uses' => 'AdminFirmDetailsController@editLogo']);
					Route::post('/firmdetails/get_worktimes', ['uses' => 'AdminFirmDetailsController@getWorkTimes']);
					Route::post('/firmdetails/edit_worktimes', ['uses' => 'AdminFirmDetailsController@setWorkTimes']);
					Route::any('/firmdadressedit', ['uses' => 'AdminFirmDetailsController@editAdress']);

					Route::group(['prefix' => 'kalendar_config'], function () {
						Route::get('/', ['uses' => 'AdminCalendarConfigController@config']);
						Route::post('/get_config', ['uses' => 'AdminCalendarConfigController@getConfig']);
						Route::post('/edit', ['uses' => 'AdminCalendarConfigController@setConfig']);
					});

					Route::group(['prefix' => 'tariff'], function () {
						Route::get('/', ['uses' => 'AdminTariffController@currentTariff']);
						Route::post('/get_tariffs', ['uses' => 'AdminTariffController@getTariffs']);
						Route::post('/change', ['uses' => 'AdminTariffController@changeTariff']);
						Route::any('/freeze', ['uses' => 'AdminTariffController@freezeProfil']);
					});

					Route::get('/slider', ['uses' => 'AdminSliderController@slider']);
					Route::get('/slider2', ['uses' => 'AdminSliderController@slider2']);
					Route::post('/slideupload', ['uses' => 'AdminSliderController@uploadSlide']);
					Route::post('/slideedit', ['uses' => 'AdminSliderController@editSlide']);
					Route::any('/slideremove', ['uses' => 'AdminSliderController@removeSlide']);
				});
			});

		});
	});

	Route::group(['domain' => '{subdomain}.' . env('MAIN_DOMAIN')], function () {
		Route::group(['middleware' => 'ClientMiddleware'], function () {
			Route::group(['namespace' => 'Client'], function () {
				Route::get('/', ['uses' => 'ClientAboutController@index']);
				Route::get('/about', ['as' => 'about', 'uses' => 'ClientAboutController@about']);
				Route::get('/sms', ['uses' => 'ClientSMSController@index']);

				Route::get('/gustebook', ['uses' => 'ClientGuestBookController@gustebook']);
				Route::get('/kontact', ['uses' => 'ClientContactsController@kontact']);
				Route::get('/newsletter', ['uses' => 'ClientNewsletterController@newsletter']);
				Route::get('/settings', ['uses' => 'ClientProfilController@settings']);
				Route::get('/set_locale/{loc}', ['uses' => 'ClientController@setLocale']);

				Route::get('/booking', ['uses' => 'ClientBookingController@booking']);
				Route::post('/get_employees', ['uses' => 'ClientBookingController@getEmployees']);
				Route::post('/get_work_times', ['uses' => 'ClientBookingController@getWorkTimes']);
				Route::post('/check_employee', ['uses' => 'ClientBookingController@checkEmployee']);
				Route::post('/new_order', ['uses' => 'ClientBookingController@newOrder']);
				Route::post('/check_email', ['uses' => 'ClientProfilController@checkEmail']);

				Route::post('/forgotpas', ['uses' => 'AuthController@forgotpass']);

				Route::group(['prefix' => 'client'], function () {
					Route::get('/', ['as' => 'client', 'uses' => 'ClientController@index']);
					Route::get('/registration', ['uses' => 'ClientProfilController@registration']);
					Route::post('/store', ['uses' => 'ClientProfilController@store']);
					Route::post('/check', ['uses' => 'ClientProfilController@check']);
					Route::get('/logout', ['uses' => 'ClientProfilController@logout']);
					Route::get('/about', ['as' => 'about', 'uses' => 'ClientAboutController@about']);
					Route::get('/booking', ['uses' => 'ClientBookingController@booking']);
					Route::post('/get_employees', ['uses' => 'ClientBookingController@getEmployees']);
					Route::post('/get_work_times', ['uses' => 'ClientBookingController@getWorkTimes']);
					Route::get('/set_locale/{loc}', ['uses' => 'ClientController@setLocale']);

					Route::get('/gustebook', ['uses' => 'ClientGuestBookController@gustebook']);
					Route::post('/gustebook', ['uses' => 'ClientGuestBookController@editGustebook']);

					Route::get('/gustebook/comment/delete/{id}', ['uses' => 'ClientGuestBookController@deletegustebook']);
					Route::get('/gustebook/comment/edit/{id}', ['uses' => 'ClientGuestBookController@editcommentsgustebook']);

					Route::get('/kontact', ['uses' => 'ClientContactsController@kontact']);
					Route::group(['middleware' => 'statusClient'], function () {
						Route::get('/newsletter', ['uses' => 'ClientNewsletterController@newsletter']);
						Route::post('/newsletter/edit', ['uses' => 'ClientNewsletterController@newsletterEdit']);
						Route::get('/settings', ['uses' => 'ClientProfilController@settings']);
						Route::post('/change_avatar', ['uses' => 'ClientProfilController@changeAvatar']);
						Route::post('/update', ['uses' => 'ClientProfilController@update']);
						Route::post('/update_pass', ['uses' => 'ClientProfilController@updatePassword']);
					});
				});
			});
		});
	});
});

Route::post('/newadmin', 'RegisterController@check');
