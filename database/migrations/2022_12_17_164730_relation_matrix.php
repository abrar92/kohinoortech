<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RelationMatrix extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        # Table creation to maintain relation starts here
        Schema::create('relation_matrix', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->default(null);
            $table->unsignedBigInteger('company_id')->nullable()->default(null);
            $table->softDeletes();
            $table->timestamps();
        });
        # Table creation to maintain  relation ends here

        # Creating Foreign Keys for accuracy and speed.
        Schema::table('relation_matrix', function ($table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('company_id')->references('id')->on('companies');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('module_access');
    }
}
