<?php

namespace App\Modules;


class Helper
{
    public static function makeId($length, $onlyInt = false)
    {
        $result = '';
        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $numbers = '123456789'; // Başlangıç ve bitiş karakteri olarak 0'ı hariç tutmak için 1-9
        $numbersAll = '0123456789'; // Ortadaki karakterler için tam sayı kümesi
        $characterSet = $onlyInt ? $numbersAll : $characters;
        $charactersLength = strlen($characterSet);

        if ($onlyInt && $length > 1) {
            $result .= $numbers[rand(0, strlen($numbers) - 1)];

            for ($i = 1; $i < $length - 1; $i++) {
                $result .= $numbersAll[rand(0, strlen($numbersAll) - 1)];
            }

            $result .= $numbers[rand(0, strlen($numbers) - 1)];
        } else {
            for ($i = 0; $i < $length; $i++) {
                $result .= $characterSet[rand(0, $charactersLength - 1)];
            }
        }

        return $result;
    }

    public static function intval($id)
    {
        if (!is_numeric($id) || (int)$id != $id) {
            abort(response()->json(['error' => 'id değeri integer olmalıdır!'], 400));
        }

        return (int) $id;
    }

    public static function getFileName(string $separator,  string $path, string $newExtension, string $prefix = "")
    {
        $fileNameOldExtension = explode($separator, $path)[1];
        if ($fileNameOldExtension) {
            $removeExtension = Helper::removeExtension($fileNameOldExtension);
        }

        return [
            "fileName" => $removeExtension["name"],
            "fileNameNewExtension" => $removeExtension["name"] . "." . $newExtension,
            "fileNameOldExtension" => $fileNameOldExtension,
            "filePath" => $prefix . $fileNameOldExtension,
            "isExtensionEqual" => $newExtension === $removeExtension["extension"]
        ];
    }

    public static function removeExtension(string $filename)
    {
        $lastDotPosition = strrpos($filename, '.');
        if ($lastDotPosition === false) {
            return [
                'name' => $filename,
                'extension' => ''
            ];
        }
        $name = substr($filename, 0, $lastDotPosition);
        $extension = substr($filename, $lastDotPosition + 1);

        return [
            'name' => $name,
            'extension' => $extension
        ];
    }
}
