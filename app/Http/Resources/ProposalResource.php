<?php

namespace App\Http\Resources;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ProposalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'proposal_number' => $this->proposal_number,
            'technical_name' => $this->technical_name,
            'client_source' => $this->client_source,
            'client_name' => $this->client_name	,
            'proposal_date' => $this->proposal_date,
            'propsal_value' => $this->propsal_value,
            'generated_code' => $this->generated_code,
            'sales_agent' => new UserResource(User::find($this->sales_agent_ID)),

        ];
    }
}
