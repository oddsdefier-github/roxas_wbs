<?php

use Admin\Database\DatabaseConnection;
use Dompdf\Dompdf;
use Dompdf\Options;

require './database_queries.php';

class QueryReportsData extends BaseQuery
{
    public function retrieveRevenueData($dataParam)
    {
        $type = $dataParam['type'];
        $table = $dataParam['table'];
        $column = $dataParam['column'];
        $value = $dataParam['value'];
        $startDate = isset($dataParam['startDate']) ? $dataParam['startDate'] : "";
        $endDate = isset($dataParam['endDate']) ? $dataParam['endDate'] : "";

        $sql = "SELECT * FROM $table";

        if ($type !== 'all') {
            $sql .= " WHERE $column = ?";
        }

        if ($startDate !== "" && $endDate !== "") {
            if ($type !== 'all') {
                $sql .= " AND date BETWEEN ? AND ?";
            } else {
                $sql .= " WHERE date BETWEEN ? AND ?";
            }
        }

        $stmt = $this->conn->prepareStatement($sql);

        if (!$stmt) {
            return [];
        }

        if ($type !== 'all' && $startDate !== "" && $endDate !== "") {
            $stmt->bind_param('sss', $value, $startDate, $endDate);
        } elseif ($type !== 'all') {
            $stmt->bind_param('s', $value);
        } elseif ($startDate !== "" && $endDate !== "") {
            $stmt->bind_param('ss', $startDate, $endDate);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $stmt->close();

        return $data;
    }



    public function generateApplicationRevenuePDF($data, $dataParam)
    {
        $dompdf = new Dompdf();
        $options = new Options();

        // Set Dompdf options
        $options->setChroot(__DIR__);
        $options->setIsHtml5ParserEnabled(true);
        $options->set('defaultFont', 'Helvetica');

        $dompdf = new Dompdf($options);

        $revenueType = $dataParam['type'];
        $startDate = date('F d, Y', strtotime($dataParam['startDate']));
        $endDate = date('F d, Y', strtotime($dataParam['endDate']));
        $currentDate = date('F d, Y');
        $title = '';
        if ($revenueType === 'application') {
            $title = 'Application';
        } elseif ($revenueType === 'billing') {
            $title = 'Billing';
        } elseif ($revenueType === 'all') {
            $title = 'All';
        }
        $title .= ' Revenue Report';
        $html = '<html><body>';
        $html .= '<style>
        // * {
        //     outline: 1px solid red;
        // }
                body {
                    font-family: "Helvetica"; 
                }
                table {
                    border-collapse: collapse;
                    width: 100%;
                }
                th, td {
                    border: 0.728px solid black;
                    padding: 5px;
                    text-align: left;
                    font-size: 10px;
                }
                .header {
                    border: none;
                    font-size: 12px;
                }
                .total-revenue {
                    font-size: 13px; 
                    font-weight: bold; 
                    text-align: right;
                }
                </style>';
        $html .= '<table width="100%" cellspacing="0" cellpadding="0" class="header">
                    <tr>
                        <td class="header" style="text-align: left; vertical-align: middle; width: 30%;">
                            <h3 style="margin: 0;">Water Billing System Inc.</h3>
                            <h6 style="margin: 0;">Odiong, Roxas, Oriental Mindoro</h6>
                            <h6 style="margin: 0;">Tel No.(043)289-7056 Email: waterbillingsystem@gmail.com</h6>
                        </td>
                        <td class="header" style="text-align: left; vertical-align: middle; width: 30%;">
                        </td>
                        <table>
                            <tr>
                                <td style="width: 78%; border: none;">
                                    <p style="margin: 0; text-align: right; font-size: 11px">' . $currentDate . '</p>
                                </td>
                            </tr>
                        </table>
                    </tr>
                    </table>';
        $html .= '<table width="100%" cellspacing="0" cellpadding="0" class="header">
                    <tr>
                            <td style="border: none; text-align: left; vertical-align: middle; width: 50%;">
                                <h2>' . $title . '</h2>
                            </td>
                            <td style="border: none;">
                                <table width="100%" cellspacing="0" cellpadding="0" class="header">
                                    <tr style="width: 40%; border: none;">
                                        <td style="width: 25%; border: none;">
                                            <h3 style="margin: 0; text-align: right;">Period</h3>
                                        </td>
                                        <td style="width: 3%; border: none;">
                                            <h3 style="margin: 0; text-align: center;">:</h3>
                                        </td>
                                        <td style="width: 72%; border: none;">
                                            <h3 style="margin: 0; text-align: right;">
                                                <span>' . $startDate . '</span>
                                                <span> - </span>
                                                <span>' . $endDate . '</span>
                                            </h3>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>';
        $html .= '<table>';
        $html .= '<tr>
                    <th>Transaction ID</th>
                    <th>Reference ID</th>
                    <th>Type</th>
                    <th>Revenue</th>
                    <th>Time</th>
                    <th>Date</th>
                </tr>';
        $totalRevenue = 0;

        foreach ($data as $row) {

            $type = '';
            if ($row['transaction_type'] === 'application_payment') {
                $type .= 'application';
            } else {
                $type .= 'billing';
            }

            $html .= '<tr>';
            $html .= '<td>' . $row['transaction_id'] . '</td>';
            $html .= '<td>' . $row['reference_id'] . '</td>';
            $html .= '<td>' . $type . '</td>';
            $html .= '<td>Php ' . number_format($row['amount_due'], 2, '.', ',') . '</td>';
            $html .= '<td>' . date("h:i A", strtotime($row['time'])) . '</td>';
            $html .= '<td>' . $row['date'] . '</td>';
            $html .= '</tr>';

            $totalRevenue += $row['amount_due'];
        }

        $html .= '</table>';
        $html .= '<p class="total-revenue">Total Revenue: Php ' . number_format($totalRevenue, 2, '.', ',') . '</p>';
        $html .= '</body></html>';


        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();
        $outputDirectory = 'temp/reports/';
        $currentDateTime = time();
        $outputFilename = $revenueType . '_revenue_report_' . date('Ymd_His', $currentDateTime) . '.pdf';
        $outputFilePath = $outputDirectory . $outputFilename;

        if (!is_dir($outputDirectory)) {
            mkdir($outputDirectory, 0755, true);
        }

        file_put_contents($outputFilePath, $dompdf->output());
        return [
            'status' => 'success',
            'path' => $outputFilePath,
            'filename' => basename($outputFilePath)
        ];
    }


    public function generateRevenueReports($dataParam)
    {
        $data = $this->retrieveRevenueData($dataParam);
        $response = $this->generateApplicationRevenuePDF($data, $dataParam);
        return $response;
    }
}
