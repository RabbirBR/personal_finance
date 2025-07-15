<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountHeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_heads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('comp_id');
            $table->bigInteger('parent_id')->comment("0 = Account doesn't have any parent.");
            $table->string('name');
            $table->text('desc')->nullable();
            $table->boolean('increased_on')->comment('0 = Debit, 1 = Credit');
            $table->boolean('ledger')->default(1)->comment('1 signifies that this is a Ledger Account.');
            $table->tinyInteger('root_account')->nullable()->comment('1 = Assets, 2 = Liability, 3 = Equity, 4 = Revenue, 5 = Expense.');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_heads');
    }
}