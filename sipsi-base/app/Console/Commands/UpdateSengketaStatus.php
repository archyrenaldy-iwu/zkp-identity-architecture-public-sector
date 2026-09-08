<?php

namespace App\Console\Commands;

use App\Models\Sengketa;
use App\Models\SengketaHistory;
use Carbon\Carbon;
use Constant;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateSengketaStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sengketa:update-status';

    protected $description = 'Update sengketa status to set is_selesai to true for status 2 older than 7 days';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $sevenDaysAgo = Carbon::now()->subDays(7);

        try {
            DB::transaction(function () use ($sevenDaysAgo) {
                // Fetch records as Eloquent models
                $sengketaList = Sengketa::where('status', Constant::STATUS_SENGKETA_DITOLAK)
                    ->where('updated_at', '<', $sevenDaysAgo)
                    ->get();

                foreach ($sengketaList as $sengketa) {
                    if (updateHistoryIsCurrent($sengketa->id)) {
                        $sengketaHistory = SengketaHistory::where('status', Constant::STATUS_SENGKETA_DITOLAK)
                            ->where('id_sengketa', $sengketa->id)
                            ->orderBy('id', 'DESC')
                            ->first();

                        if ($sengketaHistory) {
                            $sengketaHistory->update([
                                'is_current' => true,
                                'is_selesai' => true,
                            ]);
                        }

                        $sengketa->is_selesai = true;
                        $sengketa->save();
                    } else {
                        Log::error('Terjadi kegagalan saat mengupdate status sengketa secara otomatis. ID Sengketa: '.$sengketa->id);
                    }
                }
            });

            Log::info('Sukses mengupdate otomatis status sengketa');
            $this->info('Sengketa status updated successfully.');

        } catch (Exception $e) {
            Log::error('Exception caught in '.__CLASS__.'::'.__FUNCTION__.': '.$e->getMessage(), [
                'class' => get_class($e),
                'code' => $e->getCode(),
                // 'trace' => $e->getTrace(),
            ]);
            $this->info('Exception caught. Sengketa status update failed.');
        }
    }
}
