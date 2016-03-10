<?php
namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\db\Query;

/**
 * Class ExcelExportUsers provides logic for export users and masters to Excel file
 *
 * @package app\modules\admin\models
 */
class ExcelExportUsers extends Model
{
    /**
     * Load users to Excel
     * Return .xlsx file
     */
    public function loadUsersToExcel()
    {
        $users = $this->getAllUsers();
        $data  = $this->getData('Пользователи');

        // Headers
        $headings = [
            'ID',
            'НИК',
            'email',
            'Имя',
            'Роль'
        ];

        $countFields = 'E'; // Number of fields, it is need for styles

        // Row width
        $data['ews']->getColumnDimension('A')
            ->setWidth(7);
        $data['ews']->getColumnDimension('B')
            ->setWidth(18);
        $data['ews']->getColumnDimension('C')
            ->setWidth(25);
        $data['ews']->getColumnDimension('D')
            ->setWidth(35);
        $data['ews']->getColumnDimension('E')
            ->setWidth(18);

        $data['rowNumber'] = $this->insertHeadings($headings, $data, $countFields);

        // Insert data
        if (! empty($users)) {
            foreach ($users as $user) {
                $col = 'A';
                if (! empty($user)) {
                    foreach ($user as $userKey => $userVal) {
                        if ($userKey == 'role') {
                            ($userVal == 2) ? $userVal = 'Администратор' : $userVal = 'Пользователь';
                        }
                        $data['ews']->setCellValue($col . $data['rowNumber'], $userVal);
                        $col++;
                    }
                }
                $data['rowNumber']++;
            }
        }

        $this->getFile($data, $countFields);
        exit;
    }

    /**
     * Load masters to Excel
     * Return .xlsx file
     */
    public function loadMastersToExcel()
    {
        $masters = $this->getAllMasters();
        $data    = $this->getData('Мастера');

        // Headers
        $headings    = [
            'ID',
            'Имя',
            'Город',
            'Телефон',
            'Email',
            'Адрес регистрации',
            'Опыт',
            'Бригада',
            'Статус',
            'Форма оплаты'
        ];
        $countFields = 'J'; // Number of fields, it is need for styles

        // Row width
        $data['ews']->getColumnDimension('A')
            ->setWidth(7);
        $data['ews']->getColumnDimension('B')
            ->setWidth(30);
        $data['ews']->getColumnDimension('C')
            ->setWidth(20);
        $data['ews']->getColumnDimension('D')
            ->setWidth(23);
        $data['ews']->getColumnDimension('E')
            ->setWidth(23);
        $data['ews']->getColumnDimension('F')
            ->setWidth(25);
        $data['ews']->getColumnDimension('G')
            ->setWidth(8);
        $data['ews']->getColumnDimension('H')
            ->setWidth(8);
        $data['ews']->getColumnDimension('I')
            ->setWidth(24);
        $data['ews']->getColumnDimension('J')
            ->setWidth(20);

        $data['rowNumber'] = $this->insertHeadings($headings, $data, $countFields);

        // Insert data
        if (! empty($masters)) {
            foreach ($masters as $master) {
                $col = 'A';
                if (! $master['id']) {
                    continue;
                }
                if (! empty($master)) {
                    foreach ($master as $mKey => $mVal) {
                        $data['ews']->setCellValue($col . $data['rowNumber'], $mVal);
                        $col++;
                    }
                }
                $data['rowNumber']++;
            }
        }

        $this->getFile($data, $countFields);
        exit;
    }

    /**
     * Get all users
     *
     * @return array
     */
    public function getAllUsers()
    {
        $queryBuilder = new Query();
        $users        = $queryBuilder
            ->select([
                'id',
                'username',
                'email',
                'fio',
                'role'
            ])
            ->from('users')
            ->all();

        return $users;
    }

    /**
     * Get all masters
     *
     * @return array
     */
    public function getAllMasters()
    {
        $queryBuilder = new Query();
        $masters      = $queryBuilder
            ->select([
                'id',
                'name',
                'city',
                'tel',
                'email',
                'location',
                'expirience',
                'friends',
                'status',
                'money'
            ])
            ->from('masters')
            ->all();

        return $masters;
    }

    /**
     * Prepare data
     *
     * @param string $forWho Users or masters, need for filename and header
     * @return array
     * @throws \PHPExcel_Exception
     */
    protected function getData($forWho)
    {
        $data                = [];
        $data['objPHPExcel'] = new \PHPExcel();

        // Set document properties
        $data['objPHPExcel']->getProperties()
            ->setCreator("Alex Petrov")
            ->setLastModifiedBy("Alex Petrov");

        // Around
        $ews                    = $data['ews'] = $data['objPHPExcel']->getActiveSheet();
        $data['nameFile']       = $forWho . ' - ' . date("d.m.Y"); // filename
        $data['col']            = 'A';
        $defaultFont            = 'Calibri';
        $data['rowNumberFirst'] = $data['rowNumber'] = 5; // headers starting
        $ews->setTitle('Мастера'); // sheet name

        // Top
        $headerMergeFrom  = 'A';
        $headerMergeTo    = 'C';
        $contentFirstRow  = $forWho;
        $contentSecondRow = 'fpbuilders.ru';
        $contentThirdRow  = date("d.m.Y");
        $styleHead        = [
            'font'      => [
                'bold' => true,
                'size' => 11,
                'name' => $defaultFont,
            ],
            'alignment' => [
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $data['style'] = [
            'font'      => [
                'bold'  => true,
                'size'  => 10,
                'name'  => $defaultFont,
                'color' => [
                    'argb' => '4a3297',
                ],
            ],
            'alignment' => [
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'   => \PHPExcel_Style_Alignment::VERTICAL_CENTER
            ],
            'borders'   => [
                'allborders' => [
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                ],
            ],
            'fill'      => [
                'type'       => \PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => [
                    'argb' => 'a6caf0'
                ],
            ]
        ];

        // Data
        $data['styleForData'] = [
            'font'      => [
                'size'   => 10,
                'name'   => $defaultFont,
                'italic' => true,
            ],
            'alignment' => [
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical'   => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ],
            'borders'   => [
                'allborders' => [
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                ],
            ],
        ];

        $data['rowHeight'] = 18; // height row with header


        // Merge cell for top
        $ews->mergeCells($headerMergeFrom . '1:' . $headerMergeTo . '1')
            ->mergeCells($headerMergeFrom . '2:' . $headerMergeTo . '2')
            ->mergeCells($headerMergeFrom . '3:' . $headerMergeTo . '3');

        // Insert content and apply styles
        $ews->setCellValue($headerMergeFrom . '1', $contentFirstRow)
            ->setCellValue($headerMergeFrom . '2', $contentSecondRow)
            ->setCellValue($headerMergeFrom . '3', $contentThirdRow)
            ->getStyle($headerMergeFrom . '1:' . $headerMergeFrom . '3')
            ->applyFromArray($styleHead);

        $ews->getStyle($headerMergeFrom . '1')
            ->getFont()
            ->setSize(18)
            ->setUnderline(\PHPExcel_Style_Font::UNDERLINE_SINGLE);

        return $data;
    }

    /**
     * Insert headers
     *
     * @param array $headings    Array with headers
     * @param array $data        Preparing data
     * @param int   $countFields Number of fields in file
     * @return int
     */
    protected function insertHeadings($headings, $data, $countFields)
    {
        // Insert headers
        if (! empty($headings)) {
            foreach ($headings as $heading) {
                $data['ews']->setCellValue($data['col'] . $data['rowNumber'], $heading);
                $data['col']++;
            }
        }
        $headerSize = "A{$data['rowNumber']}:{$countFields}{$data['rowNumber']}";

        $data['ews']->getStyle($headerSize)
            ->applyFromArray($data['style']);

        $data['ews']->getRowDimension($data['rowNumber'])
            ->setRowHeight($data['rowHeight']);

        $data['rowNumber']++;

        return $data['rowNumber'];
    }

    /**
     * Get Excel file
     *
     * @param array $data        Preparing data
     * @param int   $countFields Number of fields in file
     * @throws \PHPExcel_Reader_Exception
     */
    protected function getFile($data, $countFields)
    {
        // Style for data
        $rowNumberEnd = $data['rowNumber'] - 1;
        $headerSize   = "A{$data['rowNumberFirst']}:{$countFields}{$rowNumberEnd}";
        $data['ews']->getStyle($headerSize)
            ->applyFromArray($data['styleForData']);

        // Style for ID
        $idField = 'A' . ($data['rowNumberFirst']) . ':' . 'A' . $rowNumberEnd;

        $data['ews']->getStyle($idField)
            ->getAlignment()
            ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        // Save as an Excel2007 file. Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $data['nameFile'] . '.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($data['objPHPExcel'], 'Excel2007');
        $objWriter->save('php://output');
    }
}
