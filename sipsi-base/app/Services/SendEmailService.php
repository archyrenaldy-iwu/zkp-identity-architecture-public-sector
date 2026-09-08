<?php

namespace App\Services;

use App\Models\KiConfig;
use App\Models\Pemohon;
use App\Models\Termohon;
use App\Models\UserInternal;
use App\Notifications\CustomEmailNotification;
use Carbon\Carbon;

class SendEmailService
{
    public function sendReelasEmail($sengketa_history, $user)
    {
        try {
            $subject = 'Panggilan Sidang atau Relaas No. Registrasi '.$sengketa_history->sengketa->no_sengketa;
            $date = Carbon::parse($sengketa_history->sidang_waktu);
            $hari = $date->translatedFormat('l');
            $tgl = $date->translatedFormat('d F Y');
            $pukul = $date->translatedFormat('H:i');
            //get ki
            $ki = KiConfig::find($sengketa_history->sengketa->id_ki);
            //get pemohon
            $pemohon = Pemohon::find($sengketa_history->sengketa->id_pemohon);
            //get termohon
            $termohon = Termohon::find($sengketa_history->sengketa->id_termohon);
            //get panitera pengganti
            $panitera_pengganti = UserInternal::find($sengketa_history->sengketa->id_panitera_pengganti);

            //get site url
            $site_url = config('app.url');

            $body = 'Kami informasikan bahwa Anda dipanggil untuk menghadiri sidang sengketa informasi publik di '.$ki->nama.'. Berikut adalah rincian panggilan sidang tersebut:<br><br>';
            $body .= 'Hari/tanggal : '.$hari.'/'.$tgl.'<br>';
            $body .= 'Pukul : '.$pukul.' '.$ki->timezone.'<br>';
            $body .= 'Agenda : '.$sengketa_history->sidang_agenda.'<br>';
            $body .= 'Alamat : '.$sengketa_history->sidang_alamat.'<br>';
            $body .= 'Sidang ini terkait dengan perkara yang terdaftar di '.$ki->nama.' dengan nomor register '.$sengketa_history->sengketa->no_sengketa.' antara:<br>';
            $body .= 'Pemohon: '.$pemohon->nama.'<br>';
            $body .= 'Termohon: '.$termohon->nama.'<br><br>';
            $body .= 'Untuk informasi lebih lanjut, Anda dapat menghubungi Sdr. '.$panitera_pengganti->nama.' Panitera Pengganti di nomor HP '.$panitera_pengganti->no_hp.'.<br>';
            $body .= 'Demikian Panggilan Sidang ini kami sampaikan. Untuk melihat dokumen Reelas silahkan buka Menu Sengketa atau Jadwal Sidang pada <a href="'.$site_url.'">'.$site_url.'</a><br><br>';
            $body .= 'Terima kasih atas perhatian dan kerjasamanya.<br>';
            $body .= 'Hormat Kami,<br>';
            $body .= $panitera_pengganti->nama;

            $user->notify(new CustomEmailNotification($subject, $body));

            return true;
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
