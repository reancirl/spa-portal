<?php

namespace App\Services;

use App\Models\InquiryStatus;
use App\Models\QuotationStatus;
use App\Models\TestDriveStatus;
use App\Models\OnlineReservationStatus;

class StatusesService
{
    /**
     * Get statuses based on the selected type
     *
     * @param string $type
     * @return Array
     */
    public function execute($type)
    {
        $statuses = [];
        $model = null;

        switch ($type) {
            case 'inquiry':
                $model = InquiryStatus::class;
                break;
            case 'quotation':
                $model = QuotationStatus::class;
                break;
            case 'testdrive':
                $model = TestDriveStatus::class;
                break;
            case 'onlinereservation':
                $model = OnlineReservationStatus::class;
                break;
            default:
                throw new \ErrorException("Invalid status type.");
                break;
        }

        $statusTexts = $model::$statusTexts;

        //Format setatus
        foreach ($statusTexts as $key => $text) {
            $statuses[] = (object) [
                'title' => $text,
                'slug' => $key,
                'description' => $model::$statusDescriptions[$key],
                'sequence' => $model::$statusSequence[$key],
            ];
        }

        return $statuses;
    }
}
