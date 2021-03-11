<?php

namespace App\Traits;

use DB;
use File;
use ImgUploader;
use App\User;
use App\ProfileSummary;
use App\ProfileProject;
use App\ProfileExperience;
use App\ProfileEducation;
use App\ProfileSkill;
use App\ProfileLanguage;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Traits\Active;

trait CommonUserFunctions
{

	use Active;
	
    private function deleteUserImage($id)
    {
        try {
            $user = User::findOrFail($id);
            $image = $user->image;
            if (!empty($image)) {
                File::delete(ImgUploader::real_public_path() . 'user_images/thumb/' . $image);
                File::delete(ImgUploader::real_public_path() . 'user_images/mid/' . $image);
                File::delete(ImgUploader::real_public_path() . 'user_images/' . $image);
            }
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }
	
	public function deleteUser(Request $request)
    {

        $user_id = $request->input('id');
        try {
			
			ProfileSummary::where('user_id', '=', $user_id)->delete();
			$this->deleteAllProfileCvs($user_id);
			$this->deleteAllProfileProjects($user_id);
			ProfileExperience::where('user_id', '=', $user_id)->delete();
			$this->deleteAllProfileEducation($user_id);
			ProfileSkill::where('user_id', '=', $user_id)->delete();
			ProfileLanguage::where('user_id', '=', $user_id)->delete();
			
            $this->deleteUserImage($user_id);
			
            $user = User::findOrFail($user_id);
            $user->delete();

            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }
	
	public function updateImmediateAvailableStatus(Request $request)
    {
        $id = $request->input('user_id');
		$old_status = $request->input('old_status');
        try {
            $user = User::findOrFail($id);
            $user->is_immediate_available = !$old_status;
            $user->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }
	
	private function updateUserFullTextSearch($user)
	{
		$str = '';
		$str .= $user->getName();
		$str .= ' '.$user->getCountry('country');
		$str .= ' '.$user->getState('state');
		$str .= ' '.$user->getCity('city');
		$str .= ' '.$user->father_name;
		$str .= ' '.$user->date_of_birth->format('Y-m-d');		
		$str .= ' '.$user->phone;
		$str .= ' '.$user->mobile_num;		
		$str .= ' '.$user->getGender('gender');
		$str .= ' '.$user->getJobExperience('job_experience');
		$str .= ' '.$user->current_salary.' - '.$user->expected_salary;
		$str .= ' '.$user->getCareerLevel('career_level');
		$str .= ' '.$user->getIndustry('industry');
		$str .= ' '.$user->getFunctionalArea('functional_area');
		$str .= ' '.$user->street_address;
		$str .= ' '.$user->getProfileSkillsStr();
		
		$user->search = $str;
		$user->update();
	
	}
	
	public static function countNumJobSeekers($field = 'country_id', $value = '')
	{
		if(!empty($value))
		{
			
			if($field == 'industry_id')
			{
				return User::where('industry_id', $value)->active()->count('id');
			}
			if($field == 'job_skill_id')
			{
				$job_seeker_ids = ProfileSkill::where('job_skill_id','=',$value)->pluck('user_id')->toArray();
				return User::whereIn('id', array_unique($job_seeker_ids))->active()->count('id');
			}
			if($field == 'functional_area_id')
			{
				return User::where('functional_area_id','=',$value)->active()->count('id');
			}
			if($field == 'careel_level_id')
			{
				return User::where('careel_level_id','=',$value)->active()->count('id');
			}
			if($field == 'gender_id')
			{
				return User::where('gender_id','=',$value)->active()->count('id');
			}
			if($field == 'job_experience_id')
			{
				return User::where('job_experience_id','=',$value)->active()->count('id');
			}
			if($field == 'country_id')
			{
				return User::where('country_id','=',$value)->active()->count('id');
			}
			if($field == 'state_id')
			{
				return User::where('state_id','=',$value)->active()->count('id');
			}
			if($field == 'city_id')
			{
				return User::where('city_id','=',$value)->active()->count('id');
			}
		}
	}

}
