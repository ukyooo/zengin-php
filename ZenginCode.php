<?php

/**
 * Class ZenginCode\Data
 *
 * @package ZenginCode
 */

namespace ZenginCode;

class Data
{
    const BANK_DATA_FILE_PATH   = 'source-data/data/banks.json';
    const BRANCH_DATA_DIR       = 'source-data/data/branches';

    private static $data_path_list  = array(
        './',
        './vendor/zengin-code',
        './../vendor/zengin-code',
        './../../vendor/zengin-code',
        './../../../vendor/zengin-code',
    );
    private static $data_path       = null;
    private static $data_bank       = array();
    private static $data_branch     = array();

    public function __construct()
    {
        // init

        // find data path
        foreach (self::$data_path_list as $path) {
            $path = sprintf('%s/%s', __DIR__, $path);
            $file = sprintf('%s/%s', $path, self::BANK_DATA_FILE_PATH);
            if (file_exists($file)) {
                self::$data_path = $path;
                break;
            }
        }
        if (is_null(self::$data_path)) throw new \Exception('data does not exists.');

        // load bank data
        if (!count(self::$data_bank)) {
            self::$data_bank = self::loadBankData();
        }

        // load bank branch data
        foreach (array_keys(self::$data_bank) as $bank_code) {
            self::$data_branch[$bank_code] = self::loadBranchData($bank_code);
        }
    }
    private static function loadBankData()
    {
        $file_path = sprintf('%s/%s', self::$data_path, self::BANK_DATA_FILE_PATH);
        return json_decode(file_get_contents($file_path), true);
    }
    private static function loadBranchData($bank_code)
    {
        $file_path = sprintf('%s/%s/%s.json', self::$data_path, self::BRANCH_DATA_DIR, $bank_code);
        return json_decode(file_get_contents($file_path), true);
    }

    /** bankData()
     *
     */
    public function bankData()
    {
        return self::$data_bank;
    }

    /** branchData()
     *
     */
    public function branchData()
    {
        return self::$data_branch;
    }

    /** all()
     *
     */
    public function all()
    {
        $data = self::$data_bank;
        foreach (array_keys($data) as $bank_code) {
            $data[$bank_code]['branches'] = self::$data_branch[$bank_code];
        }
        return $data;
    }

    /** lookupBank()
     *
     */
    public function lookupBank($bank_code, $with_branches = false)
    {
        $row = self::$data_bank[$bank_code];
        if ($with_branches === true) {
            $row['branches'] = self::$data_branch[$bank_code];
        }
        return $row;
    }

    /** lookupBranch()
     *
     */
    public function lookupBranch($bank_code, $branch_code)
    {
        return self::$data_branch[$bank_code][$branch_code];
    }

    /** findBranch()
     *
     */
    public function findBranch($bank_code)
    {
        return self::$data_branch[$bank_code][$branch_code];
    }
}
