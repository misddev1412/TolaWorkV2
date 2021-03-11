<div class="modal-body">
    <div class="form-body">
        <div class="form-group" id="div_language_id">
            <label for="language_id" class="bold">Language</label>
            <?php
            $language_id = (isset($profileLanguage) ? $profileLanguage->language_id : null);
            ?>
            {!! Form::select('language_id', [''=>'Select language']+$languages, $language_id, array('class'=>'form-control', 'id'=>'language_id')) !!} <span class="help-block language_id-error"></span> </div>
        <div class="form-group" id="div_language_level_id">
            <label for="language_level_id" class="bold">Language Level</label>
            <?php
            $language_level_id = (isset($profileLanguage) ? $profileLanguage->language_level_id : null);
            ?>
            {!! Form::select('language_level_id', [''=>'Select Language Level']+$languageLevels, $language_level_id, array('class'=>'form-control', 'id'=>'language_level_id')) !!} <span class="help-block language_level_id-error"></span> </div>
    </div>
</div>
