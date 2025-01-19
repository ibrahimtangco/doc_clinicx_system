<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\ActivityLogger;

class MedicalHistory extends Model
{
    use HasFactory;

    protected $table = 'medical_history';

    protected $fillable = [
        'patient_id',
        'condition',
        'description',
        'diagnosed_date',
        'treatment',
        'status',
    ];

    protected $casts = [
        'diagnosed_date' => 'date',
    ];

    public function getDiagnosedDateFormattedAttribute()
    {
        return $this->diagnosed_date->format('F j, Y');
    }

    public function storeMedicalHistory($data)
    {
        return MedicalHistory::create($data);
    }

    public function updateMedicalHistory($data)
    {
        $id = $data['edit_id'];

        $medicalHistory = MedicalHistory::find($id);
        if ($medicalHistory) {
            $medicalHistory->update([
                'condition' => $data['edit_condition'],
                'diagnosed_date' => $data['edit_diagnosed_date'],
                'treatment' => $data['edit_treatment'],
                'status' => $data['edit_status'],
                'description' => $data['edit_description']
            ]);
            $medicalHistory->save();
            return true; // Indicate success
        }
        return false; // Indicate failure if not found
    }

    public function showUserMedicalHistory($patient)
    {
        return MedicalHistory::where('patient_id', $patient->id)->paginate(5);
    }
}
