<?php

namespace Prexto\Utils;

class Config
{
    /**
     * @var array $fileContent
     */
    private static $fileContent = [];

    /**
     * @return array
     */
    protected static function getFileContent()
    {
        if (static::$fileContent) {
            return static::$fileContent;
        }

        $configFile = __DIR__ . '/../../config/params.json';

        if (!file_exists($configFile)) {
            throw new \Exception(sprintf('The file %s doesn\'t exists', $configFile));
        }

        return static::$fileContent = Json::decode(file_get_contents($configFile));
    }

    /**
     * @param string $key
     *
     * @return array
     */
    public static function getParameter($key)
    {
        $fileContent = static::getFileContent();
        $values = explode('.', $key);
        $array  = '$fileContent["' . implode('"]["', array_values($values)) . '"]';
        $isset  = eval('return isset(' . $array . ');');

        if (!$isset) {
            throw new \Exception(sprintf('The %s key doesn\'t exist!', $key));
        }

        return eval('return ' . $array . ';');
    }
}
