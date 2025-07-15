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

Auth::routes();

Route::middleware(['auth'])->group(function () {
	/*
	|--------------------------------------------------------------------------
	| Web Routes requiring Authentication
	|--------------------------------------------------------------------------
	|
	| By design, the entire Application (with the exception of the login page)
	| requires Authentication, since all data stored in this application
	| will be considered confidential.
	| 
	*/
	
	Route::get('/', 'HomeController@index')->name('Login or Dashboard Page');

	Route::get('/home', function () {
		return redirect('/');
	});

	Route::prefix('admin')->group(function () {
		/*
		|--------------------------------------------------------------------------
		| Administrator Routes
		|--------------------------------------------------------------------------
		|
		| These are the Routes for the Administrators of the system. It includes 
		| the Settings for the Application the activity log, BREAD(Browse, Read, Edit, Add, Delete)
		| of Companies, User Roles and Users.
		|
		*/

		Route::prefix('currencies')->group(function () {
			Route::get('/', 'CurrenciesController@index')->name('Currencies Browse');
			Route::get('/list', 'CurrenciesController@list')->name('Ajax call for getting Currencies');
			Route::post('/add', 'CurrenciesController@add')->name('Add Currency Request.');
			Route::post('/edit', 'CurrenciesController@edit')->name('Edit Currency Request.');
			Route::post('/delete', 'CurrenciesController@delete')->name('Delete Currency Request.');
		});

		Route::prefix('companies')->group(function () {
			Route::get('/', 'CompaniesController@index')->name('Companies Browse');
			Route::get('/list', 'CompaniesController@list')->name('Ajax call for getting Companies');
			Route::post('/add', 'CompaniesController@add')->name('Add Company Request.');
			Route::post('/edit', 'CompaniesController@edit')->name('Edit Company Request.');
		});

		Route::prefix('roles')->group(function () {
			Route::get('/', function () {
				return "User Roles Home";
			})->name('User Roles Browse');
		});

		Route::prefix('users')->group(function () {
			Route::get('/', function () {
				return "Users Home";
			})->name('Users Browse');
		});

		Route::prefix('settings')->group(function () {
			Route::get('/', 'SettingsController@index')->name('Application Settings Home');
			Route::get('/update', 'SettingsController@update')->name('Application Settings Update');
		});

		Route::prefix('activity')->group(function () {
			Route::get('/', 'ActivityLogController@index')->name('Activity Log Browse');
			Route::post('/list', 'ActivityLogController@list')->name('Activity Log Browse');
		});

		// Route::get('/activity', function () {
		// 	return "Activity Log";
		// })->name('Activity Log');
	});

	Route::prefix('accounting')->group(function () {
		/*
		|--------------------------------------------------------------------------
		| Accounts Management Routes 
		|--------------------------------------------------------------------------
		|
		| These are the Routes for the Settings that will initially be filled
		| by the administrator. 
		|
		*/
		
		Route::get('/', function () {
			return redirect('/');
		});
		
		Route::prefix('accountHeads')->group(function () {
			Route::get('/', 'ChartOfAccountsController@index')->name('Chart of Accounts Home');
			Route::get('/list/{comp_id}', 'ChartOfAccountsController@list')->name('Ajax call for getting Chart of Accounts');
			Route::get('/debit_credit/{parent_id}', 'ChartOfAccountsController@debit_credit')->name('Ajax call for Choosing default Debit or Credit');
			Route::post('/add', 'ChartOfAccountsController@add')->name('Add Account Request.');
		});

		Route::prefix('ledgers')->group(function () {
			Route::get('/', function () {
				return "Ledger Home";
			})->name('Ledger Home');
		});

		Route::prefix('transactions')->group(function () {
			Route::get('/', 'TransactionController@index')->name('Chart of Accounts Home');
			Route::get('/list/{comp_id}', 'TransactionController@list')->name('Ajax call for getting list of Transactions.');
			Route::get('/get_select/{comp_id}/{default_id}', 'TransactionController@get_select')->name('Ajax call for getting head Dropdown.');
		});

		Route::prefix('reports')->group(function () {
			/*
			|--------------------------------------------------------------------------
			| Accounts Reports Routes 
			|--------------------------------------------------------------------------
			|
			| These are the Routes for the Reports that the Application will show 
			| to users.
			|
			*/

			Route::get('/', function () {
				return "Reports Home";
			})->name('Reports Home');

			Route::prefix('trial_balance')->group(function () {
				Route::get('/', function () {
					return "Trial Balance Home";
				})->name('Trial Balance Home');
			});

			Route::prefix('income_statement')->group(function () {
				Route::get('/', function () {
					return "Income / Profit & Loss Statement";
				})->name('Income / Profit & Loss Statement');
			});

			Route::prefix('cash_flow_statement')->group(function () {
				Route::get('/', function () {
					return "Cash Flow Statement";
				})->name('Cash Flow Statement');
			});

			Route::prefix('balance_sheet')->group(function () {
				Route::get('/', function () {
					return "Balance Sheet";
				})->name('Balance Sheet');
			});
		});
	});
});