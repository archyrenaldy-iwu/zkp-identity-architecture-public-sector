<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExportSengketa implements WithMultipleSheets
{
    protected $data1;

    protected $data2;

    protected $nama_ki;

    protected $tanggal_string;

    public function __construct($data1, $data2, $nama_ki, $tanggal_string)
    {
        $this->data1 = $data1;
        $this->data2 = $data2;
        $this->nama_ki = $nama_ki;
        $this->tanggal_string = $tanggal_string;
    }

    public function sheets(): array
    {
        return [
            new SengketaSheet($this->data1, $this->nama_ki, $this->tanggal_string),
            new SidangSheet($this->data2, $this->nama_ki, $this->tanggal_string),
        ];
    }
}
