<?php

namespace App\Models;

class UploadStatus
{
    public const STAT_PENDING = 'pending';

    public const STAT_PROCESSING = 'processing';

    public const STAT_COMPLETED = 'completed';

    public const STAT_FAILED = 'failed';

    public const STAT_SENT = 'sent';

    public const STAT_BOOKEND = 'booked';

    public const STAT_SALES = 'sales';

    public const STAT_CLOSE = 'close';

    public const FOLDER_INVENTORY = 'inventory';

    public const FOLDER_INQUIRIES = 'inquiries';

    public const FOLDER_LEADS = 'leads';

    public const FOLDER_TEST_DRIVE = 'test-drive';

    public const FOLDER_TEST_DRIVE_UNIT = 'test-drive-unit';

    public const FOLDER_QUOTATION = 'quotation';

    public const FOLDER_SALES_CONSULTANT = 'sales_consultants';
}
