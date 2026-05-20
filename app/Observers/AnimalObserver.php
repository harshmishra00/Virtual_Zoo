<?php

namespace App\Observers;

use App\Models\Animal;
use App\Models\ActivityLog;

class AnimalObserver
{
    public function created(Animal $animal): void
    {
        $this->log('created', $animal, "Animal '{$animal->name}' was added to the zoo.");
    }

    public function updated(Animal $animal): void
    {
        $this->log('updated', $animal, "Animal '{$animal->name}' details were updated.");
    }

    public function deleted(Animal $animal): void
    {
        $this->log('deleted', $animal, "Animal '{$animal->name}' was archived.");
    }

    public function restored(Animal $animal): void
    {
        $this->log('restored', $animal, "Animal '{$animal->name}' was restored from archive.");
    }

    private function log(string $action, Animal $animal, string $description): void
    {
        ActivityLog::create([
            'user_id'    => auth()->id(),
            'action'     => $action,
            'model_type' => Animal::class,
            'model_id'   => $animal->id,
            'description'=> $description,
            'ip_address' => request()->ip(),
        ]);
    }
}
