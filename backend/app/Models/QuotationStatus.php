<?php

namespace App\Models;

class QuotationStatus
{
    public const STAT_PENDING = 'pending';

    public const STAT_QUOTATION_SENT = 'quotation_sent';

    public const STAT_CLOSED_BOOKED = 'closed_booked';

    public const STAT_CLOSED_SALES = 'closed_sales';

    public const STAT_CLOSED_CONVERT_FALSE = 'closed_convert_false';

    /**
     * @var $statusTexts
     */
    public static $statusTexts = [
        self::STAT_PENDING => 'Pending',
        self::STAT_QUOTATION_SENT => 'Quotation sent',
        self::STAT_CLOSED_BOOKED => 'Closed (booked)',
        self::STAT_CLOSED_SALES => 'Closed (sales)',
        self::STAT_CLOSED_CONVERT_FALSE => 'Closed (didn’t convert)',
    ];

    /**
     * @var $statusDescriptions
     */
    public static $statusDescriptions = [
        self::STAT_PENDING => 'Quotation is pending.',
        self::STAT_QUOTATION_SENT => 'Quotation sent for inquiry.',
        self::STAT_CLOSED_BOOKED => 'Quotation is closed for booked.',
        self::STAT_CLOSED_SALES => 'Quotation is closed for sales.',
        self::STAT_CLOSED_CONVERT_FALSE => "Quotation is closed (didn’t convert).",
    ];

    /**
     * @var $statusSequence
     */
    public static $statusSequence = [
        self::STAT_PENDING => 1,
        self::STAT_QUOTATION_SENT => 2,
        self::STAT_CLOSED_BOOKED => 3,
        self::STAT_CLOSED_SALES => 4,
        self::STAT_CLOSED_CONVERT_FALSE => 5,
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
