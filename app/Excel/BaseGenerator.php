<?php

namespace App\Excel;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Class BaseGenerator
 * excel生成类基类
 * 简单工厂模式^_^
 * @package App\Excel
 */
abstract class BaseGenerator
{
    const START_COLUMN = 65;

    const START_ROW = 1;

    /**
     * 表头
     * @return mixed
     */
    abstract public function header();

    /**
     * 表数据
     * @param array $params 查询参数
     * @return mixed
     */
    abstract public function bodyData(array $params);

    /**
     * 表名
     * @return mixed
     */
    abstract public function fileName();

    /**
     * 数据整合
     * @param Collection $data
     * @return array
     */
    public function integrate($data)
    {
        $result = [];

        $i = 0;
        foreach ($data as $row) {
            foreach ($this->header() as $header) {
                $method = "get" . ucfirst($header['key']);
                $result[$i][$header['key']] = method_exists($this, $method) ? $this->$method($row) : $row->{$header['key']};
            }
            $i++;
        }

        return $result;
    }

    /**
     * 仅获取头部描述信息
     * @return mixed
     */
    public function getHeaderDesc()
    {
        $modelFieldHeaders = $this->header();

        $headers = [];
        foreach ($modelFieldHeaders as $header) {
            $headers[] = $header['desc'];
        }

        return $headers;
    }

    /**
     * 数据导出
     * @param array $params 查询参数
     */
    public function export(array $params)
    {
        try {
            $bodyData = $this->bodyData($params);

            $bodyData = $this->integrate($bodyData);

            if (count($bodyData) <= 0) {
                // TODO
            }

            $modelFieldHeaders = $this->header();

            $headers = $this->getHeaderDesc();

            array_unshift($bodyData, $headers);

            $columnCount = count($headers);

            $spreadSheet = new Spreadsheet();

            $workSheet = $spreadSheet->getActiveSheet();

            foreach ($bodyData as $key => $item) {
                for ($i = 0; $i < $columnCount; $i++) {
                    $column = strtoupper(chr($i + self::START_COLUMN));// 行 A,B,C,D,E...
                    if (isset($modelFieldHeaders[$i]['type'])) {
                        $workSheet->setCellValueExplicit($column . ($key + self::START_ROW), isset($item[$modelFieldHeaders[$i]['key']]) ? $item[$modelFieldHeaders[$i]['key']] : $item[$i], $modelFieldHeaders[$i]['type']);
                    } else {
                        $workSheet->setCellValue($column . ($key + self::START_ROW), isset($item[$modelFieldHeaders[$i]['key']]) ? $item[$modelFieldHeaders[$i]['key']] : $item[$i]);
                    }
                    // 设置列宽
                    if ($key === 0 && !empty($modelFieldHeaders[$i]['width'])) {
                        $workSheet->getColumnDimension($column)->setWidth($modelFieldHeaders[$i]['width']);
                    }
                }
            }

            $fileName = date("YmdHis", time()) . '-xlsx-' . $this->fileName() . '.xlsx';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $fileName . '"');
            header('Cache-Control: max-age=0');
            $writer = new Xlsx($spreadSheet);
            $writer->save("php://output");

            $spreadSheet->disconnectWorksheets();
            unset($spreadSheet);
            exit;

        } catch (Exception $e) {
            Log::error('数据导出错误：', [$e->getTraceAsString()]);
        }
    }
}