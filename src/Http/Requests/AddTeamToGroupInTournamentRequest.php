<?php

namespace Api\Http\Requests;

class AddTeamToGroupInTournamentRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'team' => 'required',
            'tournament_id' => 'required|integer',
        ];
    }
}
