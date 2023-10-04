<?php

namespace App;

use App\Dto\AddLogDto;
use App\Models\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class LogsService
{
    public function getLogs(): Collection
    {
        return Log::query()->orderBy('created_at', 'desc')->get();
    }
    public function addLog(AddLogDto $dto): Model|Log
    {
        return Log::query()->create($dto->toArray());
    }
}
