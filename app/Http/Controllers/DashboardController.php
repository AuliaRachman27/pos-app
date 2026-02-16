<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $period     = $request->period;
        $startDate  = $request->start_date;
        $endDate    = $request->end_date;


        if($period === 'today'){
            $startDate = now()->toDateString();
            $endDate = now()->toDateString();
        }

        if($period === '7days'){
            $startDate = now()->subDays(6)->toDateString();
            $endDate = now()->toDateString();
        }

        if($period === 'month'){
            $startDate = now()->startOfMonth()->toDateString();
            $endDate = now()->toDateString();
        }

        // Default jika semua kosong

        if(!$startDate && !$endDate){
            $startDate = now()->toDateString();
            $endDate = now()->toDateString();
        }

        // Kalau pilih 1 tanggal
        if($startDate && !$endDate){
            $endDate = $startDate;
        }

        $query = \App\Models\Transaction::whereBetween('created_at', [
            $startDate . ' 00:00:00',
            $endDate . ' 23:59:59'
        ]);

        $totalItemsSold = TransactionItem::whereHas('transaction', function($query) use ($startDate, $endDate){
            $query->whereBetween('created_at', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59'
            ]);
        })->sum('qty');

        $totalOmzet = $query->sum('total');
        $totalTransactions = $query->count();
        $transactionsToday = $query->latest()->get();

        return view('dashboard', compact(
            'totalOmzet',
            'totalTransactions',
            'totalItemsSold',
            'transactionsToday',
            'startDate',
            'endDate',
            'period'
        ));
    }

    public function export(Request $request)
    {
        $period = $request->period;
        $startDate = $request->start_date;
        $endDate   = $request->end_date;

        if ($period === 'today') {
            $startDate = now()->toDateString();
            $endDate   = now()->toDateString();
        }

        if ($period === '7days') {
            $startDate = now()->subDays(6)->toDateString();
            $endDate   = now()->toDateString();
        }

        if ($period === 'month') {
            $startDate = now()->startOfMonth()->toDateString();
            $endDate   = now()->toDateString();
        }

        if (!$startDate && !$endDate) {
            $startDate = now()->toDateString();
            $endDate   = now()->toDateString();
        }

        if ($startDate && !$endDate) {
            $endDate = $startDate;
        }

        $transactions = Transaction::whereBetween('created_at', [
            $startDate . ' 00:00:00',
            $endDate . ' 23:59:59'
        ])->orderBy('created_at', 'desc')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'Kode Transaksi');
        $sheet->setCellValue('B1', 'Total');
        $sheet->setCellValue('C1', 'Tanggal');
        $sheet->setCellValue('D1', 'Jam');

        $row = 2;

        foreach ($transactions as $trx) {
            $sheet->setCellValue('A' . $row, $trx->transaction_code);
            $sheet->setCellValue('B' . $row, $trx->total);
            $sheet->setCellValue('C' . $row, $trx->created_at->format('Y-m-d'));
            $sheet->setCellValue('D' . $row, $trx->created_at->format('H:i:s'));
            $row++;
        }

        // Tambah total omzet
        $sheet->setCellValue('A' . $row, 'TOTAL');
        $sheet->setCellValue('B' . $row, $transactions->sum('total'));

        $filename = 'laporan-transaksi-' . $startDate . '-to-' . $endDate . '.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename);
    }

}
