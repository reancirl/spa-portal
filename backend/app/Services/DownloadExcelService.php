<?php

namespace App\Services;

use App\Models\ReportTypes;
use Box\Spout\Common\Entity\Style\Border;
use Box\Spout\Common\Entity\Style\CellAlignment;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Writer\Common\Creator\Style\BorderBuilder;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

class DownloadExcelService
{

    /**
     * Download any leads excel .
     *
     * @param  $collection
     * @param $array_header - excel header
     *
     *
     * @return object
     */
    public function downloadExcel($collection, $array_header, $type)
    {
        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToBrowser($type . '.xlsx'); // stream data directly to the browser

        $border = (new BorderBuilder())
            ->setBorderBottom(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
            ->setBorderLeft(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
            ->setBorderTop(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
            ->setBorderRight(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
            ->build();
        /** Create a style with the StyleBuilder */
        $style = (new StyleBuilder())
            ->setShouldWrapText()
            ->setFontBold()
            ->setBorder($border)
            ->setFontColor(Color::BLACK)
            ->setCellAlignment(CellAlignment::CENTER)
            ->setBackgroundColor(Color::GRAY)
            ->build();

        $header = WriterEntityFactory::createRowFromArray(
            $array_header,
            $style
        );
        $writer->addRow($header);

        if ($type === ReportTypes::LEADS) {
            foreach ($collection as $lead) {
                $row = WriterEntityFactory::createRowFromArray(
                    [
                        $lead->activity_source,
                        $lead->first_name,
                        $lead->last_name,
                        $lead->province,
                        $lead->municipality,
                        $lead->zipcode,
                        $lead->barangay,
                        $lead->street,
                        $lead->mobile,
                        $lead->preferred_communication,
                        $lead->email,
                        $lead->model_name,
                        $lead->variant_name,
                        $lead->color,
                        $lead->sc_assigned_at,
                    ],
                );
                $writer->addRow($row);
            }
        }
        if ($type === ReportTypes::QUOTATIONS) {
            foreach ($collection as $quo) {
                $row = WriterEntityFactory::createRowFromArray(
                    [
                        $quo->customer_id,
                        $quo->first_name,
                        $quo->last_name,
                        $quo->province,
                        $quo->municipality,
                        $quo->zipcode,
                        $quo->barangay,
                        $quo->street,
                        $quo->mobile,
                        $quo->title,
                        $quo->email,
                        $quo->model_name,
                        $quo->variant_name,
                        $quo->color,
                        $quo->assignedSC->first_name . ' ' . $quo->assignedSC->last_name,
                        $quo->sc_assigned_at,
                    ],
                );
                $writer->addRow($row);
            }
        }
        if ($type === ReportTypes::TEST_DRIVES) {
            foreach ($collection as $tDrive) {
                $row = WriterEntityFactory::createRowFromArray(
                    [
                        $tDrive->title,
                        $tDrive->first_name,
                        $tDrive->last_name,
                        $tDrive->birthdate,
                        $tDrive->province,
                        $tDrive->municipality,
                        $tDrive->barangay,
                        $tDrive->street,
                        $tDrive->zipcode,
                        $tDrive->mobile,
                        $tDrive->preferred_communication,
                        $tDrive->email,
                        $tDrive->dealer->name,
                        $tDrive->model_name,
                        $tDrive->variant_name,
                        $tDrive->color_name,
                        $tDrive->test_drive_date,
                        // $tDrive->assignedSC->first_name . ' ' . $quo->assignedSC->last_name,
                        // $tDrive->sc_assigned_at,
                    ],
                );
                $writer->addRow($row);
            }
        }
        if ($type === ReportTypes::RESERVATIONS) {
            foreach ($collection as $reserve) {
                $row = WriterEntityFactory::createRowFromArray(
                    [
                        $reserve->customer_id,
                        $reserve->first_name,
                        $reserve->last_name,
                        $reserve->title,
                        $reserve->province,
                        $reserve->municipality,
                        $reserve->barangay,
                        $reserve->street,
                        $reserve->zipcode,
                        $reserve->mobile,
                        $reserve->email,
                        $reserve->model_name,
                        $reserve->variant_name,
                        $reserve->color,
                        $reserve->status,
                        $reserve->preferred_communication,
                        $reserve->dealer->name,
                        $tDrive->assignedSC->first_name . ' ' . $quo->assignedSC->last_name,
                        $tDrive->sc_assigned_at,

                    ],
                );
                $writer->addRow($row);
            }
        }

        if ($type === ReportTypes::BRAND_ASSETS) {
            foreach ($collection as $tDrive) {
                $row = WriterEntityFactory::createRowFromArray(
                    [
                        $tDrive->name,
                        $tDrive->file,
                        $tDrive->description,
                        $tDrive->extension,
                        $tDrive->size,
                        $tDrive->height,
                        $tDrive->width,
                        $tDrive->published_at,
                        $tDrive->expired_at,
                        $tDrive->status,
                        $tDrive->precedence,
                    ],
                );
                $writer->addRow($row);
            }
        }

        if ($type === ReportTypes::USER_ACTIVITIES) {
            foreach ($collection as $user) {
                $row = WriterEntityFactory::createRowFromArray(
                    [
                        $user->user->first_name . ' ' . $user->user->last_name,
                        $user->action,
                        $user->message,
                        $user->data,

                    ],
                );
                $writer->addRow($row);
            }
        }

        if ($type === ReportTypes::SALES_CONSULTANTS) {
            foreach ($collection as $user) {
                $row = WriterEntityFactory::createRowFromArray(
                    [
                        $user->first_name,
                        $user->last_name,
                        $user->email,
                        $user->crm_id,
                        $user->dealer->first_name . ' ' . $user->dealer->last_name,
                    ],
                );
                $writer->addRow($row);
            }
        }



        $writer->close();
    }
}
