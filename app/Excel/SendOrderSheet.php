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
use Illuminate\Foundation\Application;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Exceptions\LaravelExcelException;
use Maatwebsite\Excel\Files\NewExcelFile;
use Maatwebsite\Excel\Readers\LaravelExcelReader;
use Maatwebsite\Excel\Writers\CellWriter;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;

class SendOrderSheet
{
    protected $headers = [];

    protected $excel = null;

    protected $date = null;

    protected $endAt = null;
    protected $mergeRows = [
        'A' => [],
        'E' => []
    ];
//    protected $shops = null;

    public function getFilename()
    {
        // TODO: Implement getFilename() method.
        return "{$this->date}配送订单";
    }

    public function __construct(Excel $excel, string $date = null)
    {
        $this->excel = $excel;
        $date = $date ? $date : Carbon::now()->format('Y-m-d');
        $this->headers = [
            ['配送订单'],
            ['', '', '', '日期：', $date],
            ['餐车/自提点编号', '序号', '产品名称', '产品数量', '配送批次']
        ];
        $this->date = $date;
    }

    /**
     * @return \Illuminate\Support\Collection
     * @throws
     * */
    protected function getSheetData() {
        $data = $this->headers;
        return collect($data);
    }

    public function download()
    {
        try {
            $this->excel->create($this->getFilename(), function (LaravelExcelWriter $sheet) {
                $sheet->sheet($this->date, function (LaravelExcelWorksheet $sheet) {
                    $rows = $this->getSheetData();
                    $sheet->setStyle([
                        'font' => [
                            'size' => 14
                        ]
                    ]);
                    $sheet->rows($rows)
                        ->row(1, function (CellWriter $row) {
                            $row->setFont(array(
                                'family' => 'Calibri',
                                'size' => 18,
                                'bold' => true
                            ));
                            $row->setAlignment('center');
                            $row->setValignment('center');
                            $row->sheet->mergeCells($row->cells);
                        });

                    foreach ($this->mergeRows as $column => $rows) {
                        if(count($rows) > 0) {
                            $sheet->setMergeColumn([
                                'columns' => (array)$column,
                                'rows' => $rows
                            ]);
                        }

                    }
                    // 设置每一列的宽度
                    $sheet->setWidth('A', 20);
                    $sheet->setWidth('B', 10);
                    $sheet->setWidth('C', 15);
                    $sheet->setWidth('D', 15);
                    $sheet->setWidth('E', 20);
                });
            })->export();
        } catch (LaravelExcelException $e) {
        }
    }
}