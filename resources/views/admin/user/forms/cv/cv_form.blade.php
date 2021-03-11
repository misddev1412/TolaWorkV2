<div class="modal-body">
    <div class="form-body">
        <div class="form-group" id="div_title">
            <label for="name" class="bold">CV Title</label>
            <input class="form-control" id="title" placeholder="Cv title" name="title" type="text" value="{{(isset($profileCv)? $profileCv->title:'')}}">
            <span class="help-block title-error"></span> </div>

        @if(isset($profileCv))
        <div class="form-group">
            {{ImgUploader::print_doc("cvs/$profileCv->cv_file", $profileCv->title, $profileCv->title)}}
        </div>
        @endif

        <div class="form-group" id="div_cv_file">
            <label for="cv_file" class="bold">CV File</label>
            <input name="cv_file" id="cv_file" type="file" />
            <span class="help-block cv_file-error"></span> </div>

        <div class="form-group" id="div_is_default">
            <label for="is_default" class="bold">Is default?</label>
            <div class="radio-list" style="margin-left:22px;">
                <?php
                $val_1_checked = '';
                $val_2_checked = 'checked="checked"';

                if (isset($profileCv) && $profileCv->is_default == 1) {
                    $val_1_checked = 'checked="checked"';
                    $val_2_checked = '';
                }
                ?>

                <label class="radio-inline"><input id="default" name="is_default" type="radio" value="1" {{$val_1_checked}}> Yes </label>
                <label class="radio-inline"><input id="not_default" name="is_default" type="radio" value="0" {{$val_2_checked}}> No </label>
            </div>
            <span class="help-block is_default-error"></span>
        </div>
    </div>