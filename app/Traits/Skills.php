<?php

namespace App\Traits;

use App\JobSkillManager;

trait Skills
{

    private function storeJobSkills($request, $job_id)
    {
        if ($request->has('skills')) {
            JobSkillManager::where('job_id', '=', $job_id)->delete();
            $skills = $request->input('skills');
            foreach ($skills as $job_skill_id) {
                $jobSkillManager = new JobSkillManager();
                $jobSkillManager->job_id = $job_id;
                $jobSkillManager->job_skill_id = $job_skill_id;
                $jobSkillManager->save();
            }
        }
    }

}
