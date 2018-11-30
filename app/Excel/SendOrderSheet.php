<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/11/28
 * Time: 11:51 AM
 */

namespace App\Excel;


use App\Entities\Order;
use App\Entities\OrderItem;
use App\Entities\Shop;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Files\NewExcelFile;
use Maatwebsite\Excel\Readers\LaravelExcelReader;

/**
 * @method LaravelExcelReader sheet($sheetId, $callback)
 * */
class SendOrderSheet extends NewExcelFile
{
    protected $headers = [];

    protected $date = null;

    protected $endAt = null;
//    protected $shops = null;

    public function getFilename()
    {
        // TODO: Implement getFilename() method.
        return "{$this->date}配送订单";
    }

    public function __construct(Excel $excel, string $date = null)
    {
        parent::__construct(app(), $excel);
        $date = $date ? $date : Carbon::now()->format('Y-m-d');
        $this->headers = [
            ['配送订单'],
            ['', '', '', '日期：', $date],
            ['餐车/自提点编号', '序号', '产品名称', '产品数量', '配送批次']
        ];
        $this->date = $date;
//        $this->shops = $shops;
    }

    /**
     * @return array
     * @throws
     * */
    protected function getSheetData() {
        $data = $this->headers;
        return $data;
    }

    public function download()
    {
        $sheet = $this->sheet("{$this->date}配送订单", function (LaravelExcelWorksheet $sheet) {
            $sheet->rows($this->getSheetData());
            $sheet->mergeCells('A1:E1');
        });

        $sheet->download();
    }
}