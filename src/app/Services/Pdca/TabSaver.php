<?php

namespace App\Services\Pdca;

use App\Models\User;

interface TabSaver
{
    public function save(User $user, int $testId, int $subjectId, array $payload): void;
}
