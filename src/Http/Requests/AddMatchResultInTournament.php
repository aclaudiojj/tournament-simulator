<?php

namespace Api\Http\Requests;

class AddMatchResultInTournament extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'team_1' => 'required',
            'team_2' => 'required',
            'team_1_score' => 'required|integer|between:0,16',
            'team_2_score' => 'required|integer|between:0,16',
            'stage' => 'required|in:qualify,playoff',
            'tournament_id' => 'required|integer',
        ];
    }
}
