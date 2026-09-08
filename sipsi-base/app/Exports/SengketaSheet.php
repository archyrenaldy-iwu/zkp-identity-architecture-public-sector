<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SengketaSheet implements FromArray, WithEvents, WithHeadings, WithStyles, WithTitle
{
    protected $data;

    protected $nama_ki;

    protected $tanggal_string;

    public function __construct(array $data, $nama_ki, $tanggal_string)
    {
        $this->data = $data;
        $this->nama_ki = $nama_ki;
        $this->tanggal_string = $tanggal_string;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function title(): string
    {
        return 'Sengketa';
    }

    public function headings(): array
    {
        return [
            ['Data Sengketa '.$this->nama_ki],
            [$this->tanggal_string],
            [],
            ['No', 'No. Sengketa', 'Nama Pemohon', 'Alamat Pemohon', 'Email Pemohon', 'No. Hp Pemohon', 'Nama Termohon', 'Alamat Termohon', 'Email Termohon', 'No. Hp Termohon', 'Tgl Permohonan', 'Tgl Keberatan', 'Tgl Jawaban', 'Tgl Tanggapan', 'Alasan Permohonan', 'Ketua MK', 'Anggota MK', 'Anggota MK', 'Mediator', 'Panitera', 'Panitera Pengganti', 'Komisi Informasi', 'Tgl Pengajuan', 'Tgl Tolak', 'Tgl Terima', 'Tgl Selesai', 'Status', 'Durasi Sengketa'],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['name' => 'Arial', 'size' => 12, 'bold' => true]],
            2 => ['font' => ['name' => 'Arial', 'size' => 11, 'bold' => false]],
            4 => ['font' => ['name' => 'Arial', 'size' => 11, 'bold' => true],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]],
        ];
    }

    public static function afterSheet(AfterSheet $event)
    {
        $sheet = $event->sheet->getDelegate();
        $headings = [
            'No', 'No. Sengketa', 'Nama Pemohon', 'Alamat Pemohon', 'Email Pemohon',
            'No. Hp Pemohon', 'Nama Termohon', 'Alamat Termohon', 'Email Termohon',
            'No. Hp Termohon', 'Tgl Permohonan',
            'Tgl Keberatan', 'Tgl Jawaban', 'Tgl Tanggapan', 'Alasan Permohonan',
            'Ketua MK', 'Anggota MK', 'Anggota MK', 'Mediator', 'Panitera',
            'Panitera Pengganti', 'Komisi Informasi', 'Tgl Pengajuan', 'Tgl Tolak',
            'Tgl Terima', 'Tgl Selesai', 'Status', 'Durasi Sengketa',
        ];

        foreach ($headings as $index => $heading) {
            $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
            $sheet->getColumnDimension($columnLetter)->setWidth(strlen($heading) + 10);
        }
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => [self::class, 'afterSheet'],
        ];
    }
}
