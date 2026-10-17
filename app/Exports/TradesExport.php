<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TradesExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $trades;

    public function __construct($trades)
    {
        $this->trades = $trades;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->trades;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Trade ID',
            'User Name',
            'User Email',
            'Asset',
            'Symbol',
            'Trade Type',
            'Amount ($)',
            'Leverage',
            'Profit/Loss ($)',
            'Status',
            'Created Date',
            'Expiry Date',
            'Updated Date'
        ];
    }

    /**
     * @param mixed $trade
     * @return array
     */
    public function map($trade): array
    {
        return [
            $trade->id,
            $trade->user->name ?? 'N/A',
            $trade->user->email ?? 'N/A',
            $trade->assets,
            $trade->symbol ?? 'N/A',
            $trade->type,
            number_format($trade->amount, 2),
            $trade->leverage ?? 'N/A',
            $trade->profit_earned ? number_format($trade->profit_earned, 2) : '0.00',
            ucfirst($trade->active),
            $trade->created_at ? $trade->created_at->format('Y-m-d H:i:s') : 'N/A',
            $trade->expire_date ? \Carbon\Carbon::parse($trade->expire_date)->format('Y-m-d H:i:s') : 'N/A',
            $trade->updated_at ? $trade->updated_at->format('Y-m-d H:i:s') : 'N/A'
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true]],
        ];
    }
}
