<?php

namespace ZenginCode;

class Data {
    const BANK_DATA_FILE_PATH = 'source-data/data/banks.json';
    const BRANCH_DATA_DIR = 'source-data/data/branches';

    private static $_base_path      = __DIR__;
    private static $_data_bank      = array();
    private static $_data_branch    = array();

    public function __construct() {
        // load bank data
        if (!count(self::$_data_bank)) {
            self::$_data_bank = self::loadBankData();
        }

        // load bank branch data
        foreach (array_keys(self::$_data_bank) as $bank_code) {
            self::$_data_branch[$bank_code] = self::loadBranchData($bank_code);
        }
    }
    private static function loadBankData() {
        $file_path = sprintf('%s/%s', self::$_base_path, self::BANK_DATA_FILE_PATH);
        return json_decode(file_get_contents($file_path), true);
    }
    private static function loadBranchData($bank_code) {
        $file_path = sprintf('%s/%s/%s.json', self::$_base_path, self::BRANCH_DATA_DIR, $bank_code);
        return json_decode(file_get_contents($file_path), true);
    }

    /**
     *
     */
    public function bankData() {
        return self::$_data_bank;
    }

    /**
     *
     */
    public function branchData() {
        return self::$_data_branch;
    }

    /**
     *
     */
    public function all() {
        $data = self::$_data_bank;
        foreach (array_keys($data) as $bank_code) {
            $data[$bank_code]['branches'] = self::$_data_branch[$bank_code];
        }
        return $data;
    }

    /**
     *
     */
    public function lookupBank($bank_code, $with_branches=false) {
        $row = self::$_data_bank[$bank_code];
        if ($with_branches === true) {
            $row['branches'] = self::$_data_branch[$bank_code];
        }
        return $row;
    }

    /**
     *
     */
    public function lookupBranch($bank_code, $branch_code) {
        return self::$_data_branch[$bank_code][$branch_code];
    }

    /**
     *
     */
    public function findBranch($bank_code) {
        return self::$_data_branch[$bank_code][$branch_code];
    }
}

?>
