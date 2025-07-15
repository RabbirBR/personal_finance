<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('role_id');
            $table->bigInteger('comp_id');

            // BREAD(Browse, Read, Edit, Add, Delete) for Account Heads
            $table->boolean('browse_account_heads')->default(0);
            $table->boolean('add_account_head')->default(0);
            $table->boolean('delete_account_head')->default(0);

            // BREAD(Browse, Read, Edit, Add, Delete) for Transactions
            $table->boolean('browse_transactions')->default(0);
            $table->boolean('read_transaction')->default(0);
            $table->boolean('add_transaction')->default(0);
            $table->boolean('edit_transaction')->default(0);
            $table->boolean('delete_transaction')->default(0);
            
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
        Schema::dropIfExists('permissions');
    }
}
