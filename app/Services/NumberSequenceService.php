<?php

namespace App\Services;

use App\Models\NumberSequence;
use Illuminate\Support\Facades\DB;

class NumberSequenceService
{
    public function next(string $prefix): int
    {
        return DB::transaction(function () use ($prefix) {
            $seq = NumberSequence::lockForUpdate()->firstOrCreate(
                ['prefix' => $prefix],
                ['last_number' => 0]
            );
            $seq->last_number++;
            $seq->save();

            return $seq->last_number;
        });
    }

    public static function toRoman(int $month): string
    {
        $map = [1=>'I',2=>'II',3=>'III',4=>'IV',5=>'V',6=>'VI',7=>'VII',8=>'VIII',9=>'IX',10=>'X',11=>'XI',12=>'XII'];
        return $map[$month] ?? (string)$month;
    }
}
