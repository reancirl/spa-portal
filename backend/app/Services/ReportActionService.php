<?php

namespace App\Services;

use App\Models\InquiryAction;
use App\Models\QuotationAction;
use App\Models\TestDriveAction;
use App\Models\OnlineReservationAction;

class ReportActionService
{
    /**
     * Get model collection based on the selected filter
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
                $model = InquiryAction::class;
                break;
            case 'quotation':
                $model = QuotationAction::class;
                break;
            case 'testdrive':
                $model = TestDriveAction::class;
                break;
            case 'onlinereservation':
                $model = OnlineReservationAction::class;
                break;
            default:
                throw new \ErrorException("Invalid action type.");
                break;
        }

        $statusTexts = $model::$statusTexts;

        //Format setatus
        foreach ($statusTexts as $key => $text) {
            $actions[] = (object) [
                'title' => $text,
                'slug' => $key,
                'description' => $model::$statusDescriptions[$key],
                'sequence' => $model::$statusSequence[$key],
            ];
        }

        return $actions;
    }
}
