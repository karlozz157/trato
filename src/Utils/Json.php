<?php

namespace Prexto\Utils;

use InvalidArgumentException;
use LogicException;

class Json
{
    /**
     * @param mixed $data
     *
     * @throws LogicException If encoding fails
     *
     * @return string
     */
    public static function encode($data)
    {
        if (is_resource($data)) {
            throw new InvalidArgumentException('Resource types cannot be encoded');
        }

        $result = json_encode($data);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new LogicException(self::getLastJsonError());
        }

        return $result;
    }

    /**
     * @param mixed $data
     *
     * @throws LogicException If decoding fails
     *
     * @return mixed
     */
    public static function decode($data)
    {
        if (empty($data)) {
            return;
        }

        $result = json_decode($data, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new LogicException(self::getLastJsonError());
        }

        return $result;
    }

    /**
     * @return string
     */
    public static function getLastJsonError()
    {
        switch (json_last_error()) {
            case JSON_ERROR_DEPTH:
                return 'Invalid JSON: Maximum stack depth exceeded';

            case JSON_ERROR_STATE_MISMATCH:
                return 'Invalid JSON: Underflow or modes mismatch';

            case JSON_ERROR_CTRL_CHAR:
                return 'Invalid JSON: Unexpected control character found';

            case JSON_ERROR_SYNTAX:
                return 'Invalid JSON: Syntax error';

            case JSON_ERROR_UTF8:
                return 'Invalid JSON: Malformed UTF-8 characters, possibly incorrectly encoded';

            default:
                return 'Invalid JSON: Unknown error';
        }
    }
}
