<?php

include_once 'ZenginCode.php';
// include_once 'ZenginCode/Bank.php';
// include_once 'ZenginCode/BankBranch.php';

$zc = new \ZenginCode\Data();
// $zc = new \ZenginCode\Bank();
// $zc = new \ZenginCode\BankBranch();
// $data = $zc->bankData();
// echo sprintf("bankData          = %s\n", count(array_keys($zc->bankData()), COUNT_RECURSIVE));
// echo sprintf("bankBranchData    = %s\n", count(array_keys($zc->bankBranchData()), COUNT_RECURSIVE));
$data = $zc->all();
foreach (array_keys($data) as $bank_code) {
    // echo sprintf("bank_code = %s\n", $bank_code);
    foreach (array_keys($data[$bank_code]['branches']) as $branch_code) {
        echo sprintf("bankCode = %s : branchCode = %s : %s : %s\n",
            $bank_code,
            $branch_code,
            $data[$bank_code]['name'],
            $data[$bank_code]['branches'][$branch_code]['name']);
    }
}

?>
