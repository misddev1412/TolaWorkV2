<?php

namespace App\Helpers;

use Request;
use Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
class ImageUploadingHelper
{

    private static $mainImgWidth = 700;
    private static $mainImgHeight = 700;
    private static $midImgWidth = 400;
    private static $midImgHeight = 400;
    private static $thumbImgWidth = 200;
    private static $thumbImgHeight = 200;
    private static $tinyMCEImgWidth = 500;
    private static $tinyMCEImgHeight = 500;
    private static $midFolder = '/mid';
    private static $thumbFolder = '/thumb';

    public static function UploadImage($destinationPath, $field, $newName = '', $width = 0, $height = 0, $makeOtherSizesImages = true)
    {
        if ($width > 0 && $height > 0) {
            self::$mainImgWidth = $width;
            self::$mainImgHeight = $height;
        }
        $destinationPath = ImageUploadingHelper::real_public_path() . $destinationPath;
        $midImagePath = $destinationPath . self::$midFolder;
        $thumbImagePath = $destinationPath . self::$thumbFolder;
        $extension = $field->getClientOriginalExtension();
        $fileName = Str::slug($newName, '-') . '-' . time() . '-' . rand(1, 999) . '.' . $extension;
        $field->move($destinationPath, $fileName);
        /*         * **** Resizing Images ******** */
        $imageToResize = Image::make($destinationPath . '/' . $fileName);
        $imageToResize->resize(self::$mainImgWidth, self::$mainImgHeight, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save($destinationPath . '/' . $fileName);
        if ($makeOtherSizesImages === true) {
            $imageToResize->resize(self::$midImgWidth, self::$midImgHeight, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($midImagePath . '/' . $fileName);
            $imageToResize->resize(self::$thumbImgWidth, self::$thumbImgHeight, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($thumbImagePath . '/' . $fileName);
            /*             * **** End Resizing Images ******** */
        }
        return $fileName;
    }

    public static function UploadDoc($destinationPath, $field, $newName = '')
    {
        $destinationPath = ImageUploadingHelper::real_public_path() . $destinationPath;
        $extension = $field->getClientOriginalExtension();
        $fileName = Str::slug($newName, '-') . '-' . time() . '-' . rand(1, 999) . '.' . $extension;
        $field->move($destinationPath, $fileName);
        return $fileName;
    }

    public static function getFileName($fileName)
    {
        $fileName = Str::slug($fileName, '-');
        $fileName = (strlen($fileName) > 85) ? substr($fileName, 0, 85) : $fileName;
        return $fileName . '-' . rand(1, 999);
    }

    public static function MoveImage($fileName, $newFileName, $tempPath, $newPath)
    {
        $newFileName = self::getFileName($newFileName);
        $ret = false;
        $tempPath = ImageUploadingHelper::real_public_path() . $tempPath;
        $newPath = ImageUploadingHelper::real_public_path() . $newPath;
        $tempMidImagePath = $tempPath . self::$midFolder;
        $tempThumbImagePath = $tempPath . self::$thumbFolder;
        $newMidImagePath = $newPath . self::$midFolder;
        $newThumbImagePath = $newPath . self::$thumbFolder;
        if (file_exists($tempPath . '/' . $fileName)) {
            $ext = pathinfo($tempPath . '/' . $fileName, PATHINFO_EXTENSION);
            $newFileName = $newFileName . '.' . $ext;
            rename($tempPath . '/' . $fileName, $newPath . '/' . $newFileName);
            rename($tempMidImagePath . '/' . $fileName, $newMidImagePath . '/' . $newFileName);
            rename($tempThumbImagePath . '/' . $fileName, $newThumbImagePath . '/' . $newFileName);
            $ret = $newFileName;
        }
        return $ret;
    }

    public static function MoveDoc($fileName, $newFileName, $tempPath, $newPath)
    {
        $newFileName = self::getFileName($newFileName);
        $ret = false;
        $tempPath = ImageUploadingHelper::real_public_path() . $tempPath;
        $newPath = ImageUploadingHelper::real_public_path() . $newPath;
        if (file_exists($tempPath . '/' . $fileName)) {
            $ext = pathinfo($tempPath . '/' . $fileName, PATHINFO_EXTENSION);
            $newFileName = $newFileName . '.' . $ext;
            rename($tempPath . '/' . $fileName, $newPath . '/' . $newFileName);
            $ret = $newFileName;
        }
        return $ret;
    }

    public static function UploadImageTinyMce($destinationPath, $field, $newName = '')
    {
        $destinationPath = ImageUploadingHelper::real_public_path() . $destinationPath;
        $extension = $field->getClientOriginalExtension();
        $fileName = Str::slug($newName, '-') . '-' . time() . '-' . rand(1, 999) . '.' . $extension;
        $field->move($destinationPath, $fileName);
        /*         * **** Resizing Images ******** */
        $imageToResize = Image::make($destinationPath . '/' . $fileName);
        $imageToResize->resize(self::$tinyMCEImgWidth, self::$tinyMCEImgHeight, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save($destinationPath . '/' . $fileName);
        /*         * **** End Resizing Images ******** */
        return $fileName;
    }

    public static function print_image($image_path, $width = 0, $height = 0, $default_image = '/admin_assets/no-image.png', $alt_title_txt = '')
    {
        echo self::get_image($image_path, $width, $height, $default_image, $alt_title_txt);
    }

    public static function print_doc($doc_path, $doc_title, $alt_title_txt = '')
    {
        echo self::get_doc($doc_path, $doc_title, $alt_title_txt);
    }

    public static function get_image($image_path, $width = 0, $height = 0, $default_image = '/admin_assets/no-image.png', $alt_title_txt = '')
    {
		$dimensions = '';
        if ($width > 0 && $height > 0) {
            $dimensions = 'style="max-width=' . $width . 'px; max-height:' . $height . 'px;"';
        } elseif ($width > 0 && $height == 0) {
            $dimensions = 'style="max-width=' . $width . 'px;"';
        } elseif ($width == 0 && $height > 0) {
            $dimensions = 'style="max-height:' . $height . 'px;"';
        }
		$image_src = self::print_image_src($image_path, $width, $height, $default_image, $alt_title_txt);
        return '<img src="' . $image_src . '" ' . $dimensions . ' alt="' . $alt_title_txt . '" title="' . $alt_title_txt . '">';
    }
	
	public static function print_image_src($image_path, $width = 0, $height = 0, $default_image = '/admin_assets/no-image.png', $alt_title_txt = '')
    {
        
        if (!empty($image_path) && file_exists(ImageUploadingHelper::real_public_path() . $image_path)) {
            return ImageUploadingHelper::public_path() . $image_path;
        } else {
            return asset($default_image);
        }
    }

    public static function get_doc($doc_path, $doc_title, $alt_title_txt = '')
    {
        if (!empty($doc_path) && file_exists(ImageUploadingHelper::real_public_path() . $doc_path)) {
            return '<a href="' . ImageUploadingHelper::public_path() . $doc_path . '" ' . ' alt="' . $alt_title_txt . '" title="' . $alt_title_txt . '">' . $doc_title . '</a>';
        } else {
            return 'No Doc Available';
        }
    }

    public static function print_image_relative($image_path, $width = 0, $height = 0, $default_image = '/admin_assets/no-image.png', $alt_title_txt = '')
    {
        $dimensions = '';
        if ($width > 0 && $height > 0) {
            $dimensions = 'style="max-width=' . $width . 'px; max-height:' . $height . 'px;"';
        } elseif ($width > 0 && $height == 0) {
            $dimensions = 'style="max-width=' . $width . 'px;"';
        } elseif ($width == 0 && $height > 0) {
            $dimensions = 'style="max-height:' . $height . 'px;"';
        }
        if (!empty($image_path)) {
            echo '<img src="' . $image_path . '" ' . $dimensions . ' alt="' . $alt_title_txt . '" title="' . $alt_title_txt . '">';
        } else {
            echo '<img src="' . asset($default_image) . '" ' . $dimensions . ' alt="' . $alt_title_txt . '" title="' . $alt_title_txt . '">';
        }
    }

    public static function public_path()
    {
        return url('/') . DIRECTORY_SEPARATOR;
    }

    public static function real_public_path()
    {
        return public_path() . DIRECTORY_SEPARATOR;
    }

}
