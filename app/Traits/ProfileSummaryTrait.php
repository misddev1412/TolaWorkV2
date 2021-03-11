<?php

namespace App\Traits;

use App\ProfileSummary;
use App\Http\Requests\ProfileSummaryFormRequest;

trait ProfileSummaryTrait
{

    public function updateProfileSummary($user_id, ProfileSummaryFormRequest $request)
    {
        ProfileSummary::where('user_id', '=', $user_id)->delete();
        $summary = $request->input('summary');
        $ProfileSummary = new ProfileSummary();
        $ProfileSummary->user_id = $user_id;
        $ProfileSummary->summary = $summary;
        $ProfileSummary->save();
        /*         * ************************************ */
        return response()->json(array('success' => true, 'status' => 200), 200);
    }

}
