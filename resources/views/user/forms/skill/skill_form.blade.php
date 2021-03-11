<div class="modal-body">
    <div class="form-body">
        <div class="formrow" id="div_job_skill_id">
            <?php
            $job_skill_id = (isset($profileSkill) ? $profileSkill->job_skill_id : null);
            ?>
            {!! Form::select('job_skill_id', [''=>__('Select skill')]+$jobSkills, $job_skill_id, array('class'=>'form-control', 'id'=>'job_skill_id')) !!} <span class="help-block job_skill_id-error"></span> </div>
        <div class="formrow" id="div_job_experience_id">
            <?php
            $job_experience_id = (isset($profileSkill) ? $profileSkill->job_experience_id : null);
            ?>
            {!! Form::select('job_experience_id', [''=>__('Select experience')]+$jobExperiences, $job_experience_id, array('class'=>'form-control', 'id'=>'job_experience_id')) !!} <span class="help-block job_experience_id-error"></span> </div>
    </div>
</div>
