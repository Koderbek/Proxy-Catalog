<?php
/**
 * Created by PhpStorm.
 * User: Юрий
 * Date: 25.09.2019
 * Time: 11:02
 */

namespace App\Helper;


class UserRoles
{
    const EDITOR = 'ROLE_EDITOR';
    const ADMIN = 'ROLE_ADMIN';

    protected static $statusNames = [
        self::EDITOR => 'Редактор',
        self::ADMIN => 'Администратор'
    ];

    public static function getRoleName($key)
    {
        if (array_key_exists($key, self::$statusNames)) {
            return self::$statusNames[$key];
        }

        return '';
    }

    public static function getRoleNames()
    {
        return static::$statusNames;
    }
}