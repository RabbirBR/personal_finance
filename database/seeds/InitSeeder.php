<?php

use Illuminate\Database\Seeder;

class InitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->insert([
            'name' => 'US Dollar',
            'symbol' => '$',
            'code' => 'USD',
            'decimal_places' => 2,
            'symbol_placement'=> 0,
            ]);

        DB::table('currencies')->insert([
            'name' => 'Bangladeshi Taka',
            'symbol' => '৳',
            'code' => 'BDT',
            'decimal_places' => 2,
            'symbol_placement'=> 1,
            ]);

        DB::table('currencies')->insert([
            'name' => 'Bitcoin',
            'code' => 'BTC',
            'decimal_places' => 8,
            'symbol_placement'=> 0,
            ]);

        DB::table('currencies')->insert([
            'name' => 'Etherium',
            'symbol' => 'Ξ',
            'code' => 'ETH',
            'decimal_places' => 12,
            'symbol_placement'=> 0,
            ]);

        DB::table('companies')->insert([
            'comp_name' => 'Globex Corporation',
            'email' => 'demo@company_one.com',
            'address' => 'Fake St.',
            'city' => 'Imaginary City',
            'state' => 'Smallest State',
            'country' => 'Unknown Country',
            'zip_code' => '3214',
            'logo' => '',
            'currency' => 2,
            ]);

        DB::table('companies')->insert([
            'comp_name' => 'Acme Corporation',
            'email' => 'demo@company_two.com',
            'address' => 'Fake St.',
            'city' => 'Imaginary City',
            'state' => 'Smallest State',
            'country' => 'Unknown Country',
            'zip_code' => '4321',
            'logo' => '',
            'currency' => 1,
            ]);

        DB::table('user_roles')->insert([
            'role_name' => 'Admin',
            'admin' => 1
            ]);

        DB::table('user_roles')->insert([
            'role_name' => 'Accountant',
            'admin' => 0
            ]);

        DB::table('permissions')->insert([
            'role_id' => 2,
            'comp_id' => 1,

            'browse_account_heads' => 1,
            'add_account_head' => 1,
            'delete_account_head' => 1,

            'browse_transactions' => 1,
            'read_transaction' => 1,
            'add_transaction' => 1,
            'edit_transaction' => 1,
            'delete_transaction' => 1,
            ]);

        DB::table('users')->insert([
            'emp_id' => '0',
            'name' => 'Super Admin',
            'role_id' => 1,
            'designation' => 'Demo Admin',
            'pro_pic' => '',
            'email' => 'super_admin@app.com',
            'password' => bcrypt('secret'),
            ]);

        DB::table('users')->insert([
            'emp_id' => '1',
            'name' => 'Test Accountant',
            'role_id' => 2,
            'designation' => 'Accountant',
            'pro_pic' => '',
            'email' => 'demo_acc@app.com',
            'password' => bcrypt('secret'),
            ]);

        DB::table('account_heads')->insert([
            'comp_id' => 1,
            'parent_id' => 0,
            'name' => 'Assets',
            'desc' => 'Tangible and Intangible items that the company owns that have value (e.g. Cash, Computer Systems, Patents).',
            'increased_on' => 0,
            'ledger' => '0',
            'root_account' => 1
            ]);

        DB::table('balance_histories')->insert([
            'acc_id' => 1,
            'date' => date("Y-m-d"),
            'opening_balance' => 0,
            'closing_balance' => 0
            ]);

        DB::table('account_heads')->insert([
            'comp_id' => 1,
            'parent_id' => 0,
            'name' => 'Liabilities',
            'desc' => 'Money that the company owes to others (e.g. Mortgages, Vehicle loans).',
            'increased_on' => 1,
            'ledger' => '0',
            'root_account' => 2
            ]);

        DB::table('balance_histories')->insert([
            'acc_id' => 2,
            'date' => date("Y-m-d"),
            'opening_balance' => 0,
            'closing_balance' => 0
            ]);

        DB::table('account_heads')->insert([
            'comp_id' => 1,
            'parent_id' => 0,
            'name' => 'Equity',
            'desc' => 'Portion of the total assets that the owners or stockholders of the company fully own.',
            'increased_on' => 1,
            'ledger' => '0',
            'root_account' => 3
            ]);

        DB::table('balance_histories')->insert([
            'acc_id' => 3,
            'date' => date("Y-m-d"),
            'opening_balance' => 0,
            'closing_balance' => 0
            ]);

        DB::table('account_heads')->insert([
            'comp_id' => 1,
            'parent_id' => 0,
            'name' => 'Income/Revenue',
            'desc' => 'Money the company earns from its sales of Products or Services, Interest and Dividends earned from marketable securities.',
            'increased_on' => 1,
            'ledger' => '0',
            'root_account' => 4
            ]);

        DB::table('balance_histories')->insert([
            'acc_id' => 4,
            'date' => date("Y-m-d"),
            'opening_balance' => 0,
            'closing_balance' => 0
            ]);

        DB::table('account_heads')->insert([
            'comp_id' => 1,
            'parent_id' => 0,
            'name' => 'Expense',
            'desc' => 'Money the company spends to produce the Goods or Services that it Sells (Ex: Office Supplies, Utilities, Advertising).',
            'increased_on' => 0,
            'ledger' => '0',
            'root_account' => 5
            ]);

        DB::table('balance_histories')->insert([
            'acc_id' => 5,
            'date' => date("Y-m-d"),
            'opening_balance' => 0,
            'closing_balance' => 0
            ]);


        // Company two Heads
        DB::table('account_heads')->insert([
            'comp_id' => 2,
            'parent_id' => 0,
            'name' => 'Assets',
            'desc' => 'Tangible and Intangible items that the company owns that have value (e.g. Cash, Computer Systems, Patents).',
            'increased_on' => 0,
            'ledger' => '0',
            'root_account' => 6
            ]);

        DB::table('balance_histories')->insert([
            'acc_id' => 6,
            'date' => date("Y-m-d"),
            'opening_balance' => 0,
            'closing_balance' => 0
            ]);

        DB::table('account_heads')->insert([
            'comp_id' => 2,
            'parent_id' => 0,
            'name' => 'Liabilities',
            'desc' => 'Money that the company owes to others (e.g. Mortgages, Vehicle loans).',
            'increased_on' => 1,
            'ledger' => '0',
            'root_account' => 7
            ]);

        DB::table('balance_histories')->insert([
            'acc_id' => 7,
            'date' => date("Y-m-d"),
            'opening_balance' => 0,
            'closing_balance' => 0
            ]);

        DB::table('account_heads')->insert([
            'comp_id' => 2,
            'parent_id' => 0,
            'name' => 'Equity',
            'desc' => 'That portion of the total assets that the owners or stockholders of the company fully own.',
            'increased_on' => 1,
            'ledger' => '0',
            'root_account' => 8
            ]);

        DB::table('balance_histories')->insert([
            'acc_id' => 8,
            'date' => date("Y-m-d"),
            'opening_balance' => 0,
            'closing_balance' => 0
            ]);

        DB::table('account_heads')->insert([
            'comp_id' => 2,
            'parent_id' => 0,
            'name' => 'Income/Revenue',
            'desc' => 'Money the company earns from its sales of Products or Services, Interest and Dividends earned from marketable securities.',
            'increased_on' => 1,
            'ledger' => '0',
            'root_account' => 9
            ]);

        DB::table('balance_histories')->insert([
            'acc_id' => 9,
            'date' => date("Y-m-d"),
            'opening_balance' => 0,
            'closing_balance' => 0
            ]);

        DB::table('account_heads')->insert([
            'comp_id' => 2,
            'parent_id' => 0,
            'name' => 'Expense',
            'desc' => 'Money the company spends to produce the goods or services that it sells (Ex: Office Supplies, Utilities, Advertising).',
            'increased_on' => 0,
            'ledger' => '0',
            'root_account' => 10
            ]);

        DB::table('balance_histories')->insert([
            'acc_id' => 10,
            'date' => date("Y-m-d"),
            'opening_balance' => 0,
            'closing_balance' => 0
            ]);
    }
}