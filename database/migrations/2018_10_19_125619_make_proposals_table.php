<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('proposals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('proposal_number');
            $table->string('proposal_type');
            $table->string('technical_name');
            $table->string('client_source');
            $table->string('client_name')->nullable();
            $table->date('proposal_date')->nullable();
            $table->string('propsal_value')->nullable();
            $table->string('generated_code')->nullable();
            $table->integer('sales_agent_ID');
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
        //

        Schema::dropIfExists('proposals');
    }
}
