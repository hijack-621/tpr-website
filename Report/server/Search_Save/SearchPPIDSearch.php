<?php
session_start();
$flag = $_POST['flag'];
switch ($flag) {
    // user
    case '1':
        if ($_SESSION["uname"] != "Peter" && $_SESSION["uname"] != "compalsod" && $_SESSION["uname"] != "Bruce") {
            echo "0";
        } else {
            echo "1";
        }
        break;
    case '2':
        $bgtime = $_POST['bgtime'];
        $edtime = $_POST['edtime'];
        $model = $_POST['model'];
        $pn = $_POST['pn'];
        $tpr = $_POST['tpr'];
        $table = $tpr . '_testlog';
        $connID = "";
        include '../db/link_db.php';
        if ($model == 0 && $pn == 0) {
            $data_arr[] = array(
                "TPR",
                "PPID",
                "Station",
                "Date"
            );
            $result = mysqli_query($connID, "select TPR,PPID,Station,Date from $table where Date>='$bgtime' and Date<='$edtime' ");
        } else
            if ($model == 1 && $pn == 0) {
                $data_arr[] = array(
                    "TPR",
                    "PPID",
                    "Station",
                    "Date",
                    "Model"
                );
                $result = mysqli_query($connID, "select TPR,PPID,Station,Date,Model from $table where Date>='$bgtime' and Date<='$edtime' ");
            } else
                if ($model == 0 && $pn == 1) {
                    $data_arr[] = array(
                        "TPR",
                        "PPID",
                        "Station",
                        "Date",
                        "PN"
                    );
                    $result = mysqli_query($connID, "select TPR,PPID,Station,Date,PN from $table where Date>='$bgtime' and Date<='$edtime' ");
                } else
                    if ($model == 1 && $pn == 1) {
                        $data_arr[] = array(
                            "TPR",
                            "PPID",
                            "Station",
                            "Date",
                            "Model",
                            "PN"
                        );
                        $result = mysqli_query($connID, "select TPR,PPID,Station,Date,Model,PN from $table where Date>='$bgtime' and Date<='$edtime' ");
                    }
        $nums = mysqli_num_rows($result); // 记录数
        if ($nums != 0) {
            while (($row = mysqli_fetch_array($result, MYSQLI_NUM)) !== false && $row > 0) {
                $data_arr[] = $row;
            }
        }
        include '../db/close_db.php';
        echo json_encode($data_arr); // 传给前端
        break;

    case '3':

        $bgtime = $_POST['bgtime'];
        $edtime = $_POST['edtime'];
        $model = $_POST['model'];
        $pn = $_POST['pn'];
        $tpr = $_POST['tpr'];
        $table = $tpr . '_testlog';
        $connID = "";
        include '../db/link_db.php';
        require_once '../../Tool/PHPExcel-1.8/Classes/PHPExcel.php';

        // $data_arrs = array();

        if ($model == 0 && $pn == 0) {
            set_time_limit(0);
            /*
             * $objPHPExcel = new PHPExcel();
             * $data_arr[] = array(
             * "TPR",
             * "PPID",
             * "Station",
             * "Date"
             * ); // 第一行
             * $result = mysqli_query($connID, "select TPR,PPID,Station,Date from $table where Date>='$bgtime' and Date<='$edtime' ");
             *
             * $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'TPR');
             * $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'PPID');
             * $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Station');
             * $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'Date');
             *
             * $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('10');
             * $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('27');
             * $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('10');
             * $objPHPExcel->getActiveSheet()->getColumnDimension('d')->setWidth('15');
             *
             *
             * $nums = mysqli_num_rows($result); // 记录数
             * $data_arrs=array();
             * if ($nums != 0) {
             * while (($row = mysqli_fetch_array($result, MYSQLI_NUM)) !== false && $row > 0) {
             * // $row 是每一行数据
             * $data_arrs[] = $row;
             * }
             * }
             * foreach ($data_arrs as $k => $v) {
             * $num = $k + 2;
             *
             * for ($i = 0; $i < count($v); $i ++) {
             *
             * $A1 = $v[0];
             * $A2 = $v[1];
             * $A3 = $v[2];
             * $A4 = $v[3];
             *
             * $objPHPExcel->setActiveSheetIndex(0)
             * ->
             * // Excel的第A列，uid是你查出数组的键值，下面以此类推
             * setCellValue('A' . $num, $A1)
             * ->setCellValue('B' . $num, $A2)
             * ->setCellValue('C' . $num, $A3)
             * ->setCellValue('D' . $num, $A4);
             * }
             * }
             *
             * $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
             * $objWriter->save('Testlog.xls');
             */

            $rs = array();
            $result = mysqli_query($connID, "select TPR,PPID,Station,Date from $table where Date>='$bgtime' and Date<='$edtime' ");

            $nums = mysqli_num_rows($result);

            if ($nums != 0) {
                $arr = array();
                while (($row = mysqli_fetch_array($result, MYSQLI_NUM)) !== false && $row > 0) {
                    $arr[] = $row;
                }
                $rs[0] = '1111';
            } else {
                $rs[0] = '0000';
            }

            $file = fopen('Testlog.csv', 'w');

            $title = array(
                "TPR",
                "PPID",
                "Station",
                "Date"
            );

            fputcsv($file, $title);
            for ($i = 0; $i < count($arr); $i ++) {

                $arr[$i] = preg_replace('/\\\\/', '\\\\\\', $arr[$i]);

                fputcsv($file, $arr[$i], ",", "\"");
            }
            $rs[1] = 'Testlog.csv';
            include '../db/close_db.php';
            echo json_encode($rs);
        } else
            if ($model == 1 && $pn == 0) {
                set_time_limit(0);
                /*
                 * $objPHPExcel = new PHPExcel();
                 * $data_arr[] = array(
                 * "TPR",
                 * "PPID",
                 * "Station",
                 * "Date",
                 * "Model"
                 * );
                 *
                 *
                 * $result = mysqli_query($connID, "select TPR,PPID,Station,Date,Model from $table where Date>='$bgtime' and Date<='$edtime' ");
                 *
                 * $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'TPR');
                 * $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'PPID');
                 * $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Station');
                 * $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'Date');
                 * $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'Model');
                 *
                 * $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('10');
                 * $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('27');
                 * $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('10');
                 * $objPHPExcel->getActiveSheet()->getColumnDimension('d')->setWidth('15');
                 * $objPHPExcel->getActiveSheet()->getColumnDimension('e')->setWidth('15');
                 * $nums = mysqli_num_rows($result); // 记录数
                 * if ($nums != 0) {
                 * while (($row = mysqli_fetch_array($result, MYSQLI_NUM)) !== false && $row > 0) {
                 * // $row 是每一行数据
                 * $data_arrs[] = $row;
                 * }
                 * }
                 *
                 * foreach ($data_arrs as $k => $v) {
                 * $num = $k + 2;
                 *
                 * for ($i = 0; $i < count($v); $i ++) {
                 *
                 * $A1 = $v[0];
                 * $A2 = $v[1];
                 * $A3 = $v[2];
                 * $A4 = $v[3];
                 * $A5 = $v[4];
                 *
                 * $objPHPExcel->setActiveSheetIndex(0)
                 * ->
                 * // Excel的第A列，uid是你查出数组的键值，下面以此类推
                 * setCellValue('A' . $num, $A1)
                 * ->setCellValue('B' . $num, $A2)
                 * ->setCellValue('C' . $num, $A3)
                 * ->setCellValue('D' . $num, $A4)
                 * ->setCellValue('E' . $num, $A5);
                 * }
                 * }
                 *
                 * $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                 * $objWriter->save('Testlog.xls');
                 */

                $rs = array();
                $result = mysqli_query($connID, "select TPR,PPID,Station,Date,Model from $table where Date>='$bgtime' and Date<='$edtime' ");

                $nums = mysqli_num_rows($result);

                if ($nums != 0) {
                    $arr = array();
                    while (($row = mysqli_fetch_array($result, MYSQLI_NUM)) !== false && $row > 0) {
                        $arr[] = $row;
                    }
                    $rs[0] = '1111';
                } else {
                    $rs[0] = '0000';
                }

                $file = fopen('Testlog.csv', 'w');

                $title = array(
                    "TPR",
                    "PPID",
                    "Station",
                    "Date",
                    "Model"
                );

                fputcsv($file, $title);
                for ($i = 0; $i < count($arr); $i ++) {

                    $arr[$i] = preg_replace('/\\\\/', '\\\\\\', $arr[$i]);

                    fputcsv($file, $arr[$i], ",", "\"");
                }
                $rs[1] = 'Testlog.csv';
                include '../db/close_db.php';
                echo json_encode($rs);

                include '../db/close_db.php';
            } else
                if ($model == 0 && $pn == 1) {

                    set_time_limit(0);
                    /*
                     * $objPHPExcel = new PHPExcel();
                     * $data_arr[] = array(
                     * "TPR",
                     * "PPID",
                     * "Station",
                     * "Date",
                     * "PN"
                     * );
                     * $result = mysqli_query($connID, "select TPR,PPID,Station,Date,PN from $table where Date>='$bgtime' and Date<='$edtime' ");
                     * $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'TPR');
                     * $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'PPID');
                     * $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Station');
                     * $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'Date');
                     * $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'PN');
                     *
                     * $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('10');
                     * $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('27');
                     * $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('10');
                     * $objPHPExcel->getActiveSheet()->getColumnDimension('d')->setWidth('15');
                     * $objPHPExcel->getActiveSheet()->getColumnDimension('e')->setWidth('15');
                     * $nums = mysqli_num_rows($result); // 记录数
                     *
                     *
                     *
                     * if ($nums != 0) {
                     * while (($row = mysqli_fetch_array($result, MYSQLI_NUM)) !== false && $row > 0) {
                     * // $row 是每一行数据
                     * $data_arrs[] = $row;
                     * }
                     * }
                     *
                     * foreach ($data_arrs as $k => $v) {
                     * $num = $k + 2;
                     *
                     * for ($i = 0; $i < count($v); $i ++) {
                     *
                     * $A1 = $v[0];
                     * $A2 = $v[1];
                     * $A3 = $v[2];
                     * $A4 = $v[3];
                     * $A5 = $v[4];
                     *
                     * $objPHPExcel->setActiveSheetIndex(0)
                     * ->
                     * // Excel的第A列，uid是你查出数组的键值，下面以此类推
                     * setCellValue('A' . $num, $A1)
                     * ->setCellValue('B' . $num, $A2)
                     * ->setCellValue('C' . $num, $A3)
                     * ->setCellValue('D' . $num, $A4)
                     * ->setCellValue('E' . $num, $A5);
                     * }
                     * }
                     *
                     * $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                     * $objWriter->save('Testlog.xls');
                     */

                    $rs = array();
                    $result = mysqli_query($connID, "select TPR,PPID,Station,Date,PN from $table where Date>='$bgtime' and Date<='$edtime' ");

                    $nums = mysqli_num_rows($result);

                    if ($nums != 0) {
                        $arr = array();
                        while (($row = mysqli_fetch_array($result, MYSQLI_NUM)) !== false && $row > 0) {
                            $arr[] = $row;
                        }
                        $rs[0] = '1111';
                    } else {
                        $rs[0] = '0000';
                    }

                    $file = fopen('Testlog.csv', 'w');

                    $title = array(
                        "TPR",
                        "PPID",
                        "Station",
                        "Date",
                        "PN"
                    );

                    fputcsv($file, $title);
                    for ($i = 0; $i < count($arr); $i ++) {

                        $arr[$i] = preg_replace('/\\\\/', '\\\\\\', $arr[$i]);

                        fputcsv($file, $arr[$i], ",", "\"");
                    }
                    $rs[1] = 'Testlog.csv';
                    include '../db/close_db.php';
                    echo json_encode($rs);

                    include '../db/close_db.php';
                } else
                    if ($model == 1 && $pn == 1) {
                        set_time_limit(0);
                        /*
                         * $objPHPExcel = new PHPExcel();
                         * $data_arr[] = array(
                         * "TPR",
                         * "PPID",
                         * "Station",
                         * "Date",
                         * "Model",
                         * "PN"
                         * );
                         * $result = mysqli_query($connID, "select TPR,PPID,Station,Date,Model,PN from $table where Date>='$bgtime' and Date<='$edtime' ");
                         *
                         * $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'TPR');
                         * $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'PPID');
                         * $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Station');
                         * $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'Date');
                         * $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'Model');
                         * $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'PN');
                         *
                         * $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('10');
                         * $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('27');
                         * $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('10');
                         * $objPHPExcel->getActiveSheet()->getColumnDimension('d')->setWidth('15');
                         * $objPHPExcel->getActiveSheet()->getColumnDimension('e')->setWidth('15');
                         * $objPHPExcel->getActiveSheet()->getColumnDimension('f')->setWidth('15');
                         * $nums = mysqli_num_rows($result); // 记录数
                         * if ($nums != 0) {
                         * while (($row = mysqli_fetch_array($result, MYSQLI_NUM)) !== false && $row > 0) {
                         * // $row 是每一行数据
                         * $data_arrs[] = $row;
                         * }
                         * }
                         *
                         * foreach ($data_arrs as $k => $v) {
                         * $num = $k + 2;
                         *
                         * for ($i = 0; $i < count($v); $i ++) {
                         *
                         * $A1 = $v[0];
                         * $A2 = $v[1];
                         * $A3 = $v[2];
                         * $A4 = $v[3];
                         * $A5 = $v[4];
                         * $A6 = $v[5];
                         *
                         *
                         * $objPHPExcel->setActiveSheetIndex(0)
                         * ->
                         * // Excel的第A列，uid是你查出数组的键值，下面以此类推
                         * setCellValue('A' . $num, $A1)
                         * ->setCellValue('B' . $num, $A2)
                         * ->setCellValue('C' . $num, $A3)
                         * ->setCellValue('D' . $num, $A4)
                         * ->setCellValue('E' . $num, $A5)
                         * ->setCellValue('F' . $num, $A6);
                         * }
                         * }
                         *
                         * $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                         * $objWriter->save('Testlog.xls');
                         */
                        $rs = array();
                        $result = mysqli_query($connID, "select TPR,PPID,Station,Date,Model,PN from $table where Date>='$bgtime' and Date<='$edtime' ");

                        $nums = mysqli_num_rows($result);

                        if ($nums != 0) {
                            $arr = array();
                            while (($row = mysqli_fetch_array($result, MYSQLI_NUM)) !== false && $row > 0) {
                                $arr[] = $row;
                            }
                            $rs[0] = '1111';
                        } else {
                            $rs[0] = '0000';
                        }

                        $file = fopen('Testlog.csv', 'w');

                        $title = array(
                            "TPR",
                            "PPID",
                            "Station",
                            "Date",
                            "Model",
                            "PN"
                        );

                        fputcsv($file, $title);
                        for ($i = 0; $i < count($arr); $i ++) {

                            $arr[$i] = preg_replace('/\\\\/', '\\\\\\', $arr[$i]);

                            fputcsv($file, $arr[$i], ",", "\"");
                        }
                        $rs[1] = 'Testlog.csv';

                        echo json_encode($rs);

                        include '../db/close_db.php';
                    }

        break;
}
?>