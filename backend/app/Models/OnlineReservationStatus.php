<?php

namespace App\Models;

class OnlineReservationStatus
{
    public const STAT_PAID = 'paid';

    public const STAT_UNPAID = 'unpaid';

    public const STAT_CANCELLED = 'cancelled';

    public const STAT_DELIVERED = 'delivered';

    /**
     * @var $statusTexts
     */
    public static $statusTexts = [
        self::STAT_PAID => 'Paid',
        self::STAT_UNPAID => 'Unpaid',
        self::STAT_CANCELLED => 'Cancelled',
        self::STAT_DELIVERED => 'Delivered',
    ];

    /**
     * @var $statusDescriptions
     */
    public static $statusDescriptions = [
        self::STAT_PAID => 'Online Reserviation is paid.',
        self::STAT_UNPAID => 'Online Reserviation is unpaid.',
        self::STAT_CANCELLED => 'Online Reserviation is cancelled.',
        self::STAT_DELIVERED => 'Online Reserviation is delivered.',
    ];

    /**
     * @var $statusSequence
     */
    public static $statusSequence = [
        self::STAT_PAID => 1,
        self::STAT_UNPAID => 2,
        self::STAT_CANCELLED => 3,
        self::STAT_DELIVERED => 4,
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
