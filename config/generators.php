<?php

use App\Excel\generators\ConsumeRecordGenerator;
use App\Excel\generators\ShopTurnoverGenerator;

return [
    'deposit_records' => ConsumeRecordGenerator::class,
    'shop_turnover' => ShopTurnoverGenerator::class,
];
