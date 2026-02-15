<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Penugasan extends Model
{
    use HasFactory;

    protected $table = 'penugasan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tugas_id',
        'user_id',
        'assigned_at',
        'completed_at',
        'catatan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'assigned_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // ============================================
    // RELATIONSHIPS
    // ============================================

    /**
     * Get tugas yang terkait
     */
    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }

    /**
     * Get user/pegawai yang ditugaskan
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ============================================
    // SCOPES
    // ============================================

    /**
     * Scope untuk penugasan aktif
     */
    public function scopeAktif($query)
    {
        return $query->whereHas('tugas', function($q) {
            $q->whereIn('status', ['pending', 'assigned']);
        });
    }

    /**
     * Scope untuk penugasan selesai
     */
    public function scopeSelesai($query)
    {
        return $query->whereNotNull('completed_at')
            ->orWhereHas('tugas', function($q) {
                $q->where('status', 'selesai');
            });
    }

    /**
     * Scope untuk penugasan bulan ini
     */
    public function scopeBulanIni($query)
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        
        return $query->whereBetween('assigned_at', [$startOfMonth, $endOfMonth]);
    }

    /**
     * Scope untuk penugasan minggu ini
     */
    public function scopeMingguIni($query)
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        
        return $query->whereBetween('assigned_at', [$startOfWeek, $endOfWeek]);
    }

    // ============================================
    // ACCESSORS
    // ============================================

    /**
     * Check apakah penugasan sudah selesai
     */
    public function getIsSelesaiAttribute()
    {
        return $this->completed_at !== null || $this->tugas->status === 'selesai';
    }

    /**
     * Get durasi pengerjaan dalam hari
     */
    public function getDurasiPengerjaanAttribute()
    {
        if (!$this->completed_at) {
            return null;
        }

        return $this->assigned_at->diffInDays($this->completed_at);
    }

    /**
     * Get formatted assigned date
     */
    public function getAssignedDateFormattedAttribute()
    {
        return $this->assigned_at->format('d F Y H:i');
    }

    /**
     * Get formatted completed date
     */
    public function getCompletedDateFormattedAttribute()
    {
        return $this->completed_at ? $this->completed_at->format('d F Y H:i') : '-';
    }

    // ============================================
    // HELPER METHODS
    // ============================================

    /**
     * Tandai sebagai selesai
     */
    public function markAsCompleted($catatan = null)
    {
        $this->update([
            'completed_at' => Carbon::now(),
            'catatan' => $catatan ?? $this->catatan,
        ]);

        $this->tugas->update(['status' => 'selesai']);
    }

    /**
     * Tambah catatan
     */
    public function addNote($catatan)
    {
        $this->update([
            'catatan' => $this->catatan ? $this->catatan . "\n" . $catatan : $catatan,
        ]);
    }
}