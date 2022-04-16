<?php

namespace App\Models;

class TestDriveAction
{
    public const STAT_SC_CONTACT = 'sc_contact';

    public const STAT_FOLLOW_UP = 'follow_up';

    /**
     * @var $statusTexts
     */
    public static $statusTexts = [
        self::STAT_SC_CONTACT => 'SC to contact',
        self::STAT_FOLLOW_UP => 'Follow up',
    ];

    /**
     * @var $statusDescriptions
     */
    public static $statusDescriptions = [
        self::STAT_SC_CONTACT => 'Test Drive is set for SC to contact.',
        self::STAT_FOLLOW_UP => 'Test Drive is set for Follow up.',
    ];

    /**
     * @var $statusSequence
     */
    public static $statusSequence = [
        self::STAT_SC_CONTACT => 1,
        self::STAT_FOLLOW_UP => 2,
    ];

    /**
     * Checks if the status is valid
     *
     * @param string $status
     * @return boolean
     */
    public static function valid($status)
    {
        $statuses = (array) self::$statusTexts;

        return (array_key_exists($status, $statuses));
    }
}
