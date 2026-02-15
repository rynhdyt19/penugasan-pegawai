<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Tugas extends Model
{
    use HasFactory;

    protected $table = 'tugas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_tugas',
        'tanggal',
        'lokasi',
        'durasi',
        'prioritas',
        'status',
        'keterangan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tanggal' => 'date',
    ];

    // ============================================
    // RELATIONSHIPS
    // ============================================

    /**
     * Get all penugasan untuk tugas ini
     */
    public function penugasan()
    {
        return $this->hasMany(Penugasan::class);
    }

    /**
     * Get all pegawai yang ditugaskan
     */
    public function pegawai()
    {
        return $this->belongsToMany(User::class, 'penugasan')
            ->withPivot('assigned_at', 'completed_at', 'catatan')
            ->withTimestamps();
    }

    /**
     * Get pegawai yang ditugaskan (singular)
     */
    public function assignedPegawai()
    {
        return $this->penugasan()->with('user')->first()?->user;
    }

    // ============================================
    // SCOPES
    // ============================================

    /**
     * Scope untuk tugas pending
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope untuk tugas assigned
     */
    public function scopeAssigned($query)
    {
        return $query->where('status', 'assigned');
    }

    /**
     * Scope untuk tugas selesai
     */
    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }

    /**
     * Scope untuk tugas dibatalkan
     */
    public function scopeDibatalkan($query)
    {
        return $query->where('status', 'dibatalkan');
    }

    /**
     * Scope berdasarkan prioritas
     */
    public function scopePrioritas($query, $prioritas)
    {
        return $query->where('prioritas', $prioritas);
    }

    /**
     * Scope untuk tugas urgent
     */
    public function scopeUrgent($query)
    {
        return $query->where('prioritas', 'urgent');
    }

    /**
     * Scope untuk tugas hari ini
     */
    public function scopeHariIni($query)
    {
        return $query->whereDate('tanggal', Carbon::today());
    }

    /**
     * Scope untuk tugas minggu ini
     */
    public function scopeMingguIni($query)
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        
        return $query->whereBetween('tanggal', [$startOfWeek, $endOfWeek]);
    }

    /**
     * Scope untuk tugas bulan ini
     */
    public function scopeBulanIni($query)
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        
        return $query->whereBetween('tanggal', [$startOfMonth, $endOfMonth]);
    }

    /**
     * Scope untuk tugas mendatang
     */
    public function scopeMendatang($query)
    {
        return $query->where('tanggal', '>=', Carbon::today());
    }

    /**
     * Scope untuk tugas yang sudah lewat
     */
    public function scopeLewat($query)
    {
        return $query->where('tanggal', '<', Carbon::today());
    }

    // ============================================
    // ACCESSORS & MUTATORS
    // ============================================

    /**
     * Get warna badge prioritas
     */
    public function getPrioritasColorAttribute()
    {
        return match($this->prioritas) {
            'rendah' => 'bg-green-100 text-green-800',
            'sedang' => 'bg-yellow-100 text-yellow-800',
            'tinggi' => 'bg-orange-100 text-orange-800',
            'urgent' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get warna badge status
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-gray-100 text-gray-800',
            'assigned' => 'bg-blue-100 text-blue-800',
            'selesai' => 'bg-green-100 text-green-800',
            'dibatalkan' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get formatted tanggal
     */
    public function getTanggalFormattedAttribute()
    {
        return $this->tanggal->format('d F Y');
    }

    /**
     * Check apakah tugas sudah lewat
     */
    public function getIsLewatAttribute()
    {
        return $this->tanggal->isPast();
    }

    /**
     * Check apakah tugas hari ini
     */
    public function getIsHariIniAttribute()
    {
        return $this->tanggal->isToday();
    }

    /**
     * Get sisa hari
     */
    public function getSisaHariAttribute()
    {
        $now = Carbon::now()->startOfDay();
        $tanggal = $this->tanggal->startOfDay();
        
        return $tanggal->diffInDays($now, false);
    }

    // ============================================
    // HELPER METHODS
    // ============================================

    /**
     * Check apakah tugas sudah ditugaskan
     */
    public function isAssigned()
    {
        return $this->status === 'assigned' && $this->penugasan()->exists();
    }

    /**
     * Check apakah tugas bisa ditugaskan
     */
    public function canBeAssigned()
    {
        return $this->status === 'pending';
    }

    /**
     * Assign tugas ke pegawai
     */
    public function assignTo(User $user)
    {
        if (!$this->canBeAssigned()) {
            return false;
        }

        if (!$user->canReceiveTask()) {
            return false;
        }

        Penugasan::create([
            'tugas_id' => $this->id,
            'user_id' => $user->id,
            'assigned_at' => Carbon::now(),
        ]);

        $this->update(['status' => 'assigned']);

        return true;
    }

    /**
     * Tandai tugas sebagai selesai
     */
    public function markAsCompleted()
    {
        $this->update(['status' => 'selesai']);
        
        $this->penugasan()->update([
            'completed_at' => Carbon::now(),
        ]);
    }

    /**
     * Batalkan tugas
     */
    public function cancel()
    {
        $this->update(['status' => 'dibatalkan']);
    }
}