<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SidangSheet implements FromArray, WithEvents, WithHeadings, WithStyles, WithTitle
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
        return 'Sidang';
    }

    public function headings(): array
    {
        return [
            ['Data Sidang Sengketa '.$this->nama_ki],
            [$this->tanggal_string],
            [],
            ['No', 'Hari/Tanggal Sidang', 'Agenda', 'Alamat', 'No. Sengketa', 'No. Relaas', 'Nama Pemohon', 'Nama Termohon', 'Ketua MK', 'Anggota MK', 'Anggota MK', 'Mediator', 'Panitera', 'Panitera Pengganti', 'Komisi Informasi', 'Jenis Sidang'],
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
        $headings = ['No', 'Hari/Tanggal Sidang', 'Agenda', 'Alamat', 'No. Sengketa', 'No. Relaas', 'Nama Pemohon', 'Nama Termohon', 'Ketua MK', 'Anggota MK', 'Anggota MK', 'Mediator', 'Panitera', 'Panitera Pengganti', 'Komisi Informasi', 'Jenis Sidang'];

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
