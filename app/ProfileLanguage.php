<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileLanguage extends Model
{

    protected $table = 'profile_languages';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function getUser($field = '')
    {
        if (null !== $user = $this->user()->first()) {
            if (empty($field))
                return $user;
            else
                return $user->$field;
        } else {
            return '';
        }
    }

    public function language()
    {
        return $this->belongsTo('App\Language', 'language_id', 'id');
    }

    public function getLanguage($field = '')
    {
        if (null !== $language = $this->language()->first()) {
            if (empty($field))
                return $language;
            else
                return $language->$field;
        } else {
            return '';
        }
    }

    public function languageLevel()
    {
        return $this->belongsTo('App\LanguageLevel', 'language_level_id', 'language_level_id');
    }

    public function getLanguageLevel($field = '')
    {
        $languageLevel = $this->languageLevel()->lang()->first();
        if (null === $languageLevel) {
            $languageLevel = $this->languageLevel()->first();
        }
        if (null !== $languageLevel) {
            if (empty($field))
                return $languageLevel;
            else
                return $languageLevel->$field;
        } else {
            return '';
        }
    }

}
