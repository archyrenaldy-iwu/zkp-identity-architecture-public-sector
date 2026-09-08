<?php

namespace App\Services;

use App\Models\KiConfig;
use App\Models\Pemohon;
use App\Models\Sengketa;
use App\Models\Termohon;
use App\Models\UserInternal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\TemplateProcessor;
use TypeDocConstant;

class DocGeneratorService
{
    protected $templateProcessor;

    public function __construct() {}

    public function genDocFormModul($sengketa, $termohon)
    {
        //get ki name by id
        $ki = KiConfig::find($sengketa->id_ki);
        $pemohon = Pemohon::find($sengketa->id_pemohon);
        $jk = $pemohon->jenis_kelamin;
        $data = [
            'ki' => $ki->nama,
            'ki_upper' => strtoupper($ki->nama),
            'nomor' => $sengketa->no_registrasi,
            'alamat_ki' => $ki->alamat,
            'no_hp_ki' => $ki->no_hp,
            'email_ki' => $ki->email,
            'nama_pemohon' => $pemohon->nama,
            'alamat_pemohon' => $pemohon->alamat,
            'pekerjaan_pemohon' => $pemohon->pekerjaan,
            'agama_pemohon' => $pemohon->agama,
            'kewarganegaraan_pemohon' => $pemohon->kewarganegaraan,
            'jenis_kelamin_pemohon' => $jk == 'L' ? 'Laki-laki' : ($jk == 'P' ? 'Perempuan' : 'Badan Hukum'),
            'kuasa_pemohon_jk' => $sengketa->kuasa_pemohon_jk == 'L' ? 'Laki-laki' : ($sengketa->kuasa_pemohon_jk == 'P' ? 'Perempuan' : ''),
            'no_hp_pemohon' => $pemohon->no_hp,
            'tempat_lahir_pemohon' => $pemohon->tempat_lahir,
            'tanggal_lahir_pemohon' => $pemohon->tanggal_lahir,
            'email_pemohon' => $pemohon->email,
            'jenis_identitas_pemohon' => $pemohon->jenis_identitas,
            'no_identitas_pemohon' => $pemohon->nomor_identitas,
            'kuasa_pemohon_nama' => $sengketa->kuasa_pemohon_nama,
            'kuasa_pemohon_alamat' => $sengketa['kuasa_pemohon_alamat'],
            'nama_termohon' => $termohon->nama,
            'alamat_termohon' => $termohon->alamat,
            'tanggal_permohonan' => $sengketa->tanggal_permohonan,
            'tanggal_jawaban' => $sengketa->tanggal_jawaban,
            'tanggal_keberatan' => $sengketa->tanggal_keberatan,
            'tanggal_tanggapan' => $sengketa->tanggal_tanggapan,
            'tanggal_sekarang' => Carbon::now()->translatedFormat('l, d F Y'),
            'alasan_pemohon' => $sengketa->alasan_permohonan,
            'file_identitas' => $sengketa->file_identitas ? '√' : '×',
            'file_formulir_permohonan' => $sengketa->file_formulir_permohonan ? '√' : '×',
            'file_formulir_keberatan' => $sengketa->file_formulir_keberatan ? '√' : '×',
            'file_surat_kuasa' => $sengketa->file_surat_kuasa ? '√' : '×',
            'file_pemberitahuan_tertulis' => $sengketa->file_pemberitahuan_tertulis ? '√' : '×',
            'file_jawaban_ppid' => $sengketa->file_jawaban_ppid ? '√' : '×',
            'file_tanggapan_atasan_ppid' => $sengketa->file_tanggapan_atasan_ppid ? '√' : '×',
            'file_pendukung1' => $sengketa->file_pendukung1 ? $this->getFileNameFromPath($sengketa->file_pendukung1) : '..................................',
            'file_pendukung2' => $sengketa->file_pendukung2 ? $this->getFileNameFromPath($sengketa->file_pendukung2) : '..................................',
        ];
        $type = 'formulir_modul';
        $outputPath = $this->generateDoc($data, $type);

        return $outputPath;
    }

    public function genDocAktaRegistrasi($sengketa)
    {
        //get pemohon by id
        $pemohon = Pemohon::find($sengketa->id_pemohon);
        //get termohon by id
        $termohon = Termohon::find($sengketa->id_termohon);
        //get ki name by id
        $ki = KiConfig::find($sengketa->id_ki);
        //get panitra by id
        $panitra = UserInternal::find($sengketa->id_panitera_utama);
        $data = [
            'no_registrasi' => $sengketa->no_registrasi,
            'no_sengketa' => $sengketa->no_sengketa,
            'hari' => Carbon::now()->translatedFormat('l'),
            'tanggal' => Carbon::now()->translatedFormat('d'),
            'bulan' => Carbon::now()->translatedFormat('F'),
            'tahun' => Carbon::now()->translatedFormat('Y'),
            'jam' => Carbon::now()->translatedFormat('H:i'),
            'nama_pemohon' => $pemohon->nama,
            'nama_termohon' => $termohon->nama,
            'ki' => $ki->nama,
            'ki_upper' => strtoupper($ki->nama),
            'nama_panitra' => $panitra->nama,
        ];
        $type = 'akta_registrasi';
        $outputPath = $this->generateDoc($data, $type);

        return $outputPath;
    }

    public function genDocSPKD($sengketa, $informasi_yang_dimohon, $checklist, $no_spkd)
    {
        //get pemohon by id
        $pemohon = Pemohon::find($sengketa->id_pemohon);
        //get termohon by id
        $termohon = Termohon::find($sengketa->id_termohon);
        //get ki name by id
        $ki = KiConfig::find($sengketa->id_ki);
        //get panitra by id
        $panitra = UserInternal::find($sengketa->id_panitera_utama);

        //replace \n with <w:br/>
        $informasi_yang_dimohon = str_replace("\n", '</w:t><w:br/><w:t>', $informasi_yang_dimohon);
        $data = [
            'nomor' => $no_spkd,
            'nama_pemohon' => $pemohon->nama,
            'alamat_pemohon' => $pemohon->alamat,
            'nama_termohon' => $termohon->nama,
            'alamat_termohon' => $termohon->alamat,
            'tanggal_permohonan' => $sengketa->tanggal_permohonan,
            'informasi_yang_dimohon' => $informasi_yang_dimohon,
            'checklist' => $checklist,
            'tanggal_sekarang' => Carbon::now()->translatedFormat('l, d F Y'),
            'ki' => $ki->nama,
            'ki_upper' => strtoupper($ki->nama),
            'nama_panitra' => $panitra->nama,
        ];
        $type = 'spkd';

        $outputPath = $this->generateDoc($data, $type);

        return $outputPath;
    }

    public function genDocRelaas($no_relaas, $sengketa_history)
    {
        //get sengketa
        $sengketa = Sengketa::find($sengketa_history->id_sengketa);
        //get pemohon by id
        $pemohon = Pemohon::find($sengketa->id_pemohon);
        //get termohon by id
        $termohon = Termohon::find($sengketa->id_termohon);
        //get ki name by id
        $ki = KiConfig::find($sengketa->id_ki);
        //get panitra by id
        $panitra = UserInternal::find($sengketa->id_panitera_pengganti);

        $date = Carbon::parse($sengketa_history->sidang_waktu);
        $data_relaas_pemohon = [
            'no_relaas' => $no_relaas,
            'hari' => $date->translatedFormat('l'),
            'tanggal' => $date->translatedFormat('d F Y'),
            'nama_pemohon_termohon' => $pemohon->nama,
            'alamat_pemohon_termohon' => $pemohon->alamat,
            'pemohon_termohon' => 'Pemohon',
            'tanggal_sekarang' => Carbon::now()->translatedFormat('d F Y'),
            'jam' => $date->translatedFormat('H:i').' '.$ki->timezone,
            'agenda' => $sengketa_history->sidang_agenda,
            'alamat_sidang' => $sengketa_history->sidang_alamat,
            'no_sengketa' => $sengketa->no_sengketa,
            'nama_pemohon' => $pemohon->nama,
            'nama_termohon' => $termohon->nama,
            'nama_panitra' => $panitra->nama,
            'no_hp_panitra' => $panitra->no_hp,
            'ki' => $ki->nama,
            'ki_upper' => strtoupper($ki->nama),
        ];
        $data_relaas_termohon = [
            'no_relaas' => $no_relaas,
            'hari' => $date->translatedFormat('l'),
            'tanggal' => $date->translatedFormat('d F Y'),
            'nama_pemohon_termohon' => $termohon->nama,
            'alamat_pemohon_termohon' => $termohon->alamat,
            'pemohon_termohon' => 'Termohon',
            'tanggal_sekarang' => Carbon::now()->translatedFormat('d F Y'),
            'jam' => $date->translatedFormat('H:i').' '.$ki->timezone,
            'agenda' => $sengketa_history->sidang_agenda,
            'alamat_sidang' => $sengketa_history->sidang_alamat,
            'no_sengketa' => $sengketa->no_sengketa,
            'nama_pemohon' => $pemohon->nama,
            'nama_termohon' => $termohon->nama,
            'nama_panitra' => $panitra->nama,
            'no_hp_panitra' => $panitra->no_hp,
            'ki' => $ki->nama,
            'ki_upper' => strtoupper($ki->nama),
        ];
        $type = 'relaas';

        $outputPathPemohon = $this->generateDoc($data_relaas_pemohon, $type);
        $outputPathTermohon = $this->generateDoc($data_relaas_termohon, $type);

        //return array[]
        return [$outputPathPemohon, $outputPathTermohon];

    }

    private function getFileNameFromPath($path)
    {
        //with extension
        return basename($path);
    }

    private function generateDoc($data, $type)
    {
        if ($type == 'formulir_modul') {
            $templateName = TypeDocConstant::TEMPLATE_FORMULIR_MODUL;
            $generatedName = TypeDocConstant::GENERATED_FORMULIR_MODUL;
        } elseif ($type == 'akta_registrasi') {
            $templateName = TypeDocConstant::TEMPLATE_AKTA_REGISTRASI;
            $generatedName = TypeDocConstant::GENERATED_AKTA_REGISTRASI;
        } elseif ($type == 'spkd') {
            $templateName = TypeDocConstant::TEMPLATE_SPKD;
            $generatedName = TypeDocConstant::GENERATED_SPKD;
        } elseif ($type == 'relaas') {
            $templateName = TypeDocConstant::TEMPLATE_RELAAS;
            $generatedName = TypeDocConstant::GENERATED_RELAAS;
        }

        // Path ke template DOC
        $templatePath = resource_path('templates/'.$templateName);

        // Path untuk menyimpan file DOC yang sudah digenerate
        $generatedName = str_replace('{uuid-time}', Str::uuid().'_'.time(), $generatedName);
        $storagePath = 'sengketa/file_document_pdf/';
        $outputPath = $storagePath.$generatedName;

        // Create directory if it doesn't exist
        if (! Storage::disk('sensitive')->exists($storagePath)) {
            Storage::disk('sensitive')->makeDirectory($storagePath);
        }
        $outputPath = Storage::disk('sensitive')->path($outputPath);

        // Membuat instance TemplateProcessor
        $this->templateProcessor = new TemplateProcessor($templatePath);

        //if have key alasan_pemohon
        if (array_key_exists('alasan_pemohon', $data)) {
            // Data alasan pemohon
            $alasan_pemohon = $data['alasan_pemohon'];

            // Menggabungkan array alasan menjadi satu string dengan bullet points dan newline
            $alasan_string = '';
            foreach ($alasan_pemohon as $alasan) {
                $alasan_string .= '• '.$alasan.' </w:t><w:br/><w:t>';
            }

            // Mengganti placeholder dalam template dengan alasan_string
            $this->templateProcessor->setValue('alasan_pemohon', $alasan_string);
            unset($data['alasan_pemohon']);
        }
        //if have key checklist
        if (array_key_exists('checklist', $data)) {
            // Data checklist
            $checklist = $data['checklist'];

            // Menggabungkan array checklist menjadi satu string dengan bullet points dan newline
            $checklist_string = '';
            foreach ($checklist as $check) {
                $checklist_string .= '• '.$check.' </w:t><w:br/><w:t>';
            }

            // Mengganti placeholder dalam template dengan checklist_string
            $this->templateProcessor->setValue('checklist', $checklist_string);
            unset($data['checklist']);
        }

        $this->templateProcessor->setValues($data);

        // Simpan file DOC yang sudah digenerate
        $this->templateProcessor->saveAs($outputPath);

        // Log lokasi file output
        Log::info('Generated DOC saved at: '.$outputPath);

        // Convert DOC ke PDF
        $pdfPath = $this->convertDocxToPdfLibre($outputPath, $storagePath);

        // unlink docx
        unlink($outputPath);

        return $pdfPath;
    }

    private function convertDocxToPdfLibre($filePath, $destinationDirectory)
    {
        $outputFileName = basename($filePath, '.docx').'.pdf';
        $outputFile = Storage::disk('sensitive')->path($destinationDirectory.$outputFileName);

        try {
            $os = strtoupper(substr(PHP_OS, 0, 3));
            if ($os === 'WIN') {
                $path_win_libre = config('app.path_win_libre');
                $command = "\"$path_win_libre\" --headless --convert-to pdf \"$filePath\" --outdir \"".dirname($outputFile).'"';
            } elseif ($os === 'DAR') {
                $command = "soffice --headless --convert-to pdf \"$filePath\" --outdir \"".dirname($outputFile).'"';
            } else {
                $command = "export HOME=/tmp && /usr/bin/soffice --headless --convert-to pdf \"$filePath\" --outdir \"".dirname($outputFile).'"';
            }

            Log::info('Executing command: '.$command);

            // Capture standard error output as well
            exec($command.' 2>&1', $output, $return_var);

            if ($return_var !== 0) {
                throw new \Exception('Error converting file: '.implode("\n", $output));
            }

            Log::info('Converted PDF saved at: '.$outputFile);

            //return path start from sengketa
            return $destinationDirectory.$outputFileName;

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
