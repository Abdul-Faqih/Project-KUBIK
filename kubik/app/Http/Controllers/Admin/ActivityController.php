<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityController extends Controller
{
    public function revert($id)
    {
        $activity = Activity::findOrFail($id);

        // Hanya bisa undo update (paling aman)
        if ($activity->event === 'updated') {
            $model = $activity->subject;

            if ($model) {
                // Ambil data lama (old values)
                $oldAttributes = $activity->properties['old'];

                // Update model dengan data lama
                $model->update($oldAttributes);

                return back()->with('success', 'Perubahan berhasil dibatalkan (Undo success).');
            }
        }

        return back()->with('error', 'Undo gagal atau tipe event tidak didukung.');
    }
}