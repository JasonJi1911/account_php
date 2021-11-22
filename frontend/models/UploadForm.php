<?php
namespace frontend\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $uploadDir = uploadDir;
            if( !file_exists($uploadDir) ) {
                if( !mkdir( $uploadDir ) ) {
                    getjson('创建目录失败:'.$uploadDir);
                    return;
                }
            }
            $this->imageFile->saveAs($uploadDir . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}