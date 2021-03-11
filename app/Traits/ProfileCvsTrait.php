<?php

namespace App\Traits;

use File;
use ImgUploader;
use Auth;
use DB;
use Input;
use Carbon\Carbon;
use Redirect;
use App\User;
use App\ProfileCv;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\ProfileCvFormRequest;
use App\Http\Requests\ProfileCvFileFormRequest;

trait ProfileCvsTrait
{
	
	public function showProfileCvs(Request $request, $user_id)
    {
        $user = User::find($user_id);
		$html = '<div class="col-mid-12"><table class="table table-bordered table-condensed">';
		if(isset($user) && count($user->profileCvs)):
			$cvCounter = 0;		
            foreach ($user->profileCvs as $cv):
				$default = 'Not Default';
				if($cv->is_default == 1)
					$default = 'Default';
		
					$html .= '<tr id="cv_'.$cv->id.'">
									<td>'.ImgUploader::get_doc("cvs/$cv->cv_file", $cv->title, $cv->title).'</td>
									<td><span class="text text-success">'.$default.'</span></td>
									<td><a href="javascripr:;" onclick="showProfileCvEditModal('.$cv->id.');" class="text text-warning">'.__('Edit').'</a>&nbsp;|&nbsp;<a href="javascripr:;" onclick="delete_profile_cv('.$cv->id.');" class="text text-danger">'.__('Delete').'</a></td>
								</tr>';
		endforeach;
		endif;
		
		echo $html.'</table></div>';
    }

	public function uploadCvFile($request)
    {
		$fileName = '';
        if ($request->hasFile('cv_file')) {
            $cv_file = $request->file('cv_file');
            $fileName = ImgUploader::UploadDoc('cvs', $cv_file, $request->input('title'));
        }
		return $fileName;
    }
	
	public function getFrontProfileCvForm(Request $request, $user_id)
    {
        $user = User::find($user_id);
        $returnHTML = view('user.forms.cv.cv_modal')->with('user', $user)->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }
	
	public function getProfileCvForm(Request $request, $user_id)
    {
        $user = User::find($user_id);
        $returnHTML = view('admin.user.forms.cv.cv_modal')->with('user', $user)->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function storeProfileCv(ProfileCvFormRequest $request, $user_id)
    {
        
		$profileCv = new ProfileCv();
        $profileCv = $this->assignValues($profileCv, $request, $user_id);
		$profileCv->save();
		
		$returnHTML = view('admin.user.forms.cv.cv_thanks')->render();
        return response()->json(array('success' => true, 'status' => 200, 'html' => $returnHTML), 200);
    }
	
	public function storeFrontProfileCv(ProfileCvFormRequest $request, $user_id)
    {
        
		$profileCv = new ProfileCv();
        $profileCv = $this->assignValues($profileCv, $request, $user_id);
		$profileCv->save();
		
		$returnHTML = view('user.forms.cv.cv_thanks')->render();
        return response()->json(array('success' => true, 'status' => 200, 'html' => $returnHTML), 200);
    }
	
	private function assignValues($profileCv, $request, $user_id)
	{
		$profileCv->user_id = $user_id;
        $profileCv->title = $request->input('title');
		$profileCv->is_default = $request->input('is_default');
		
		/*         * ************************************ */
        if ((int) $request->input('is_default') == 1) {
            $this->updateDefaultCv($profileCv->id);
        }
        /*         * ************************************ */
        
		if ($request->hasFile('cv_file') && $profileCv->id > 0) {
			$this->deleteCv($profileCv->id);
		}
		$profileCv->cv_file = $this->uploadCvFile($request);
		
		return $profileCv;
	}
	
	public function getProfileCvEditForm(Request $request, $user_id)
    {
		$cv_id = $request->input('cv_id');
        $profileCv = ProfileCv::find($cv_id);
		$user = User::find($user_id);
        $returnHTML = view('admin.user.forms.cv.cv_edit_modal')
							->with('user', $user)
							->with('profileCv', $profileCv)
							->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }
	
	public function getFrontProfileCvEditForm(Request $request, $user_id)
    {
		$cv_id = $request->input('cv_id');
        $profileCv = ProfileCv::find($cv_id);
		$user = User::find($user_id);
        $returnHTML = view('user.forms.cv.cv_edit_modal')
							->with('user', $user)
							->with('profileCv', $profileCv)
							->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }
	
	public function updateProfileCv(ProfileCvFormRequest $request, $cv_id, $user_id)
    {
        
		$profileCv = ProfileCv::find($cv_id);
        $profileCv = $this->assignValues($profileCv, $request, $user_id);
		$profileCv->update();
		
		$returnHTML = view('admin.user.forms.cv.cv_edit_thanks')->render();
        return response()->json(array('success' => true, 'status' => 200, 'html' => $returnHTML), 200);
    }
	
	public function updateFrontProfileCv(ProfileCvFormRequest $request, $cv_id, $user_id)
    {
        
		$profileCv = ProfileCv::find($cv_id);
        $profileCv = $this->assignValues($profileCv, $request, $user_id);
		$profileCv->update();
		
		$returnHTML = view('user.forms.cv.cv_edit_thanks')->render();
        return response()->json(array('success' => true, 'status' => 200, 'html' => $returnHTML), 200);
    }
	
	public function makeDefaultCv(Request $request)
    {
        $id = $request->input('id');
        try {
            $profileCv = ProfileCv::findOrFail($id);
            $profileCv->is_default = 1;
            $profileCv->update();
            $this->updateDefaultCv($id);
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

	private function updateDefaultCv($cv_id)
    {
        ProfileCv::where('is_default', '=', 1)->where('id', '<>', $cv_id)->update(['is_default' => 0]);
    }
	
	public function deleteAllProfileCvs($user_id)
    {
		$profileCvs = ProfileCv::where('user_id','=',$user_id)->get();
		foreach($profileCvs as $profileCv){
			echo $this->removeProfileCv($profileCv->id);
		}
    }
	
	public function deleteProfileCv(Request $request)
    {

        $id = $request->input('id');
        echo $this->removeProfileCv($id);
    }
	
	private function removeProfileCv($id)
    {
		try {

            $this->deleteCv($id);
            $profileCv = ProfileCv::findOrFail($id);
            $profileCv->delete();

            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }
	
	private function deleteCv($id)
    {
        try {
            $profileCv = ProfileCv::findOrFail($id);
            $file = $profileCv->cv_file;
            if (!empty($file)) {
                File::delete(ImgUploader::real_public_path() . 'cvs/' . $file);
            }
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }
}
