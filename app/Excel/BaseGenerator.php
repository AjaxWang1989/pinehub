<?php

namespace App\Excel;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

/**
 * Class BaseGenerator
 * excel生成类基类
 * @package App\Excel
 */
abstract class BaseGenerator
{
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

        return $modelFieldHeaders;
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

            $headers = $this->getHeaderDesc();

            $spreadSheet = new Spreadsheet();

            $workSheet = $spreadSheet->getActiveSheet();
        } catch (Exception $e) {
            Log::error('数据导出错误：', $e->getTrace());
        }
    }
}