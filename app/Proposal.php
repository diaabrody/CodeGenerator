<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    //

    protected $fillable = [
        'proposal_number', 'proposal_type', 'technical_name', 'client_source',
        'client_name', 'proposal_date', 'propsal_value', 'sales_agent_ID' , 'generated_code'
    ];


}
