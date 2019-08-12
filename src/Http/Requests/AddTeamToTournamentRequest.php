<?php

namespace Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddTeamToTournamentRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'team' => 'required',
            'tournament_id' => 'required|integer',
        ];
    }
}
