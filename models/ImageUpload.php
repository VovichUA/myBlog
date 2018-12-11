<?php
/**
 * Created by PhpStorm.
 * User: vovichua
 * Date: 09.12.18
 * Time: 17:58
 */

namespace app\models;


use yii\base\Model;
use yii\web\UploadedFile;

class ImageUpload extends Model
{
    public $image;

    public function rules()
    {
        return [
            [['image'], 'required'],
            [['image'], 'file', 'extensions' => 'jpg,png']
        ];
    }

    public function uploadFile(UploadedFile $file, $currentImage)
    {
        $this->image = $file;
        if ($this->validate()) {
            $this->deleteCurrentImage($currentImage);

            return $this->saveImage();
        }
    }

    private function getFolder()
    {
        return 'uploads/';
    }

    public function deleteCurrentImage($currentImage)
    {
        if (!empty($currentImage) && $currentImage != null) {
            unlink($this->getFolder().$currentImage);
        }
    }

    public function saveImage()
    {
        $filename = md5(uniqid($this->image->baseName)).'.'.$this->image->extension;
        $this->image->saveAs($this->getFolder() . $filename);
        return $filename;
    }

}