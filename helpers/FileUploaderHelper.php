<?php

namespace app\helpers;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

/**
 *
 * @author Bokorok
 */
class FileUploaderHelper {

    /**
     * Save image file. Crop function will be work only if isset $thumbnail parameter.
     *
     * @param UploadedFile $instance
     * @param string $dirPath
     * @param array $thumbnail
     * @param array $crop
     *
     * @return array
     */
    public static function saveAs(UploadedFile $instance, $dirPath, $thumbnail = false, $crop = null, $cropCenter = false) {
        $fileName = md5($instance->name . time());
        $subDirPath = substr($fileName, 0, 2) . DIRECTORY_SEPARATOR . substr($fileName, 2, 2);
        $data = [
            'basePath' => Yii::getAlias('@webroot'),
        ];

        if (FileHelper::createDirectory(Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . $dirPath . DIRECTORY_SEPARATOR . $subDirPath, 0777, true)) {

            $filePath = Yii::getAlias('@webroot') .
                DIRECTORY_SEPARATOR . $dirPath .
                DIRECTORY_SEPARATOR . $subDirPath .
                DIRECTORY_SEPARATOR . $fileName . '.' . $instance->extension;
//            dd($filePath);
            if ($instance->saveAs($filePath)) {
                $data['imgSrc'] = DIRECTORY_SEPARATOR . $dirPath .
                    DIRECTORY_SEPARATOR . $subDirPath .
                    DIRECTORY_SEPARATOR . $fileName . '.' . $instance->extension;

                if (is_array($thumbnail) && isset($thumbnail[0], $thumbnail[1])) {
                    if (is_array($crop) && isset($crop['w'], $crop['h'], $crop['x'], $crop['y'])) {
                        $cropedFilePath = self::crop($filePath, $crop);
                    }

                    if (self::resize($cropedFilePath, $thumbnail[0], $thumbnail[1], NULL, $cropCenter)) {
                        $data['thumbSrc'] = DIRECTORY_SEPARATOR . $dirPath .
                            DIRECTORY_SEPARATOR . $subDirPath .
                            DIRECTORY_SEPARATOR . $fileName . '_thumb.' . $instance->extension;
                    }
                }
            }else{
                dd($instance->getHasError());
            }
        }

        return $data;
    }

    /**
     * Delete file
     *
     * @param string $filePath
     *
     * @return boolen
     */
    public static function removeFile($filePath) {
        if (file_exists($filePath)) {
            return unlink($filePath);
        }

        return true;
    }

    /**
     * Move file
     *
     * @param string $oldPath
     * @param string $newPath
     *
     * @return array
     */
    public static function moveFile($oldPath, $newPath) {

        if (file_exists($oldPath)) {
            $fileDetails = pathinfo($oldPath);
            $subDirPath = substr($fileDetails['filename'], 0, 2) . DIRECTORY_SEPARATOR . substr($fileDetails['filename'], 2, 2);
            $data = [
                'basePath' => Yii::getAlias('@webroot')
            ];

            try {

                if (FileHelper::createDirectory(Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . $newPath . DIRECTORY_SEPARATOR . $subDirPath, 0777, true)) {

                    $filePath = Yii::getAlias('@webroot') .
                        DIRECTORY_SEPARATOR . $newPath .
                        DIRECTORY_SEPARATOR . $subDirPath .
                        DIRECTORY_SEPARATOR . $fileDetails['filename'] . '.' . $fileDetails['extension'];

                    if (rename($oldPath, $filePath)) {
                        $data['imgSrc'] = DIRECTORY_SEPARATOR . $newPath .
                            DIRECTORY_SEPARATOR . $subDirPath .
                            DIRECTORY_SEPARATOR . $fileDetails['filename'] . '.' . $fileDetails['extension'];
                    }
                }
            } catch (\Exception $e) {
                //TODO
            }

            return $data;
        }

        return false;
    }

    public static function resize($filePath, $width, $height, $suffix = null, $cropCenter = false) {

        $fileDetails = pathinfo($filePath);
        list($originalWidth, $originalHeight, $sourceType) = getimagesize($filePath);

        if (!$cropCenter) {
            if ($height <= $width && $originalHeight > $originalWidth) {
                list($width, $height) = [$height, $width];
            }
        }

        switch ($sourceType) {
            case IMAGETYPE_GIF:
                $original = imagecreatefromgif($filePath);
                break;
            case IMAGETYPE_JPEG:
                $original = imagecreatefromjpeg($filePath);
                break;
            case IMAGETYPE_PNG:
                $original = imagecreatefrompng($filePath);
                break;
        }

        if (!$original) {
            return false;
        }

        $sourceAspectRatio = $originalWidth / $originalHeight;
        $desiredAspectRatio = $width / $height;

        if ($sourceAspectRatio > $desiredAspectRatio) {
            $tempHeight = (int) $height;
            $tempWidth = (int) ($height * $sourceAspectRatio);
        } else {
            $tempWidth = (int) $width;
            $tempHeight = (int) ($width / $sourceAspectRatio);
        }

        $tempImg = imagecreatetruecolor($tempWidth, $tempHeight);

        if (!imagecopyresampled($tempImg, $original, 0, 0, 0, 0, $tempWidth, $tempHeight, $originalWidth, $originalHeight)) {
            return false;
        }

        if ($cropCenter) {
            $x0 = ($tempWidth - $width) / 2;
            $y0 = ($tempHeight - $height) / 2;
            $desiredImg = imagecreatetruecolor($width, $height);
            if (!imagecopy($desiredImg, $tempImg, 0, 0, $x0, $y0, $width, $height)) {
                return false;
            }
        } else {
            $desiredImg = $tempImg;
        }

        return imagejpeg($desiredImg, $fileDetails['dirname'] . DIRECTORY_SEPARATOR . $fileDetails['filename'] . $suffix . '.' . $fileDetails['extension'], 80);
    }

    /**
     * Crop file
     *
     * @param string $filePath
     * @param array $params
     * @param array $suffix
     *
     * @return mixed
     */
    public static function crop($filePath, $params, $suffix = '_thumb') {

        $fileDetails = pathinfo($filePath);

        switch ($fileDetails['extension']) {
            case 'gif':
                $original = imagecreatefromgif($filePath);
                break;
            case 'png':
                $original = imagecreatefrompng($filePath);
                break;
            case 'jpeg':
            default:
                $original = imagecreatefromjpeg($filePath);
                break;
        }

        $cropParams = [
            'x' => $params['x'],
            'y' => $params['y'],
            'width' => $params['w'],
            'height' => $params['h'],
        ];

        $resultImage = imagecrop($original, $cropParams);

        switch ($fileDetails['extension']) {
            case 'gif':
                $result = imagegif($resultImage, $fileDetails['dirname'] . DIRECTORY_SEPARATOR . $fileDetails['filename'] . $suffix . '.' . $fileDetails['extension']);
                break;
            case 'png':
                $result = imagepng($resultImage, $fileDetails['dirname'] . DIRECTORY_SEPARATOR . $fileDetails['filename'] . $suffix . '.' . $fileDetails['extension'], 9);
                break;
            case 'jpeg':
            default:
                $result = imagejpeg($resultImage, $fileDetails['dirname'] . DIRECTORY_SEPARATOR . $fileDetails['filename'] . $suffix . '.' . $fileDetails['extension'], 100);
                break;
        }

        return $result ? $fileDetails['dirname'] . DIRECTORY_SEPARATOR . $fileDetails['filename'] . $suffix . '.' . $fileDetails['extension'] : $result;
    }

}