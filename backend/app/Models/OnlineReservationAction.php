<?php

namespace App\Models;

class OnlineReservationAction
{
    public const STAT_SC_CONTACT = 'sc_contact';

    public const STAT_PENDING = 'pending';

    public const STAT_DELIVERED = 'delivered';

    /**
     * @var $statusTexts
     */
    public static $statusTexts = [
        self::STAT_SC_CONTACT => 'SC to contact',
        self::STAT_PENDING => 'Pending',
        self::STAT_DELIVERED => 'Delivered',
    ];

    /**
     * @var $statusDescriptions
     */
    public static $statusDescriptions = [
        self::STAT_SC_CONTACT => 'Online Reservation is set for SC to contact.',
        self::STAT_PENDING => 'Online Reservation is set for pending.',
        self::STAT_DELIVERED => 'Online Reservation is set for delivered.',
    ];

    /**
     * @var $statusSequence
     */
    public static $statusSequence = [
        self::STAT_SC_CONTACT => 1,
        self::STAT_PENDING => 2,
        self::STAT_DELIVERED => 3,
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
