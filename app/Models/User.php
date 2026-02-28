<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nip',
        'name',
        'email',
        'password',
        'role',
        'jabatan',
        'seksi',
        'kontak',
        'photo',
        'max_tugas_mingguan',
        'max_tugas_bulanan',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ============================================
    // RELATIONSHIPS
    // ============================================

    /**
     * Get all penugasan untuk user ini
     */
    public function penugasan()
    {
        return $this->hasMany(Penugasan::class);
    }

    /**
     * Get round robin queue untuk user ini
     */
    public function roundRobinQueue()
    {
        return $this->hasOne(RoundRobinQueue::class);
    }

    /**
     * Get all tugas yang ditugaskan ke user ini
     */
    public function tugas()
    {
        return $this->belongsToMany(Tugas::class, 'penugasan')
            ->withPivot('assigned_at', 'completed_at', 'catatan')
            ->withTimestamps();
    }

    // ============================================
    // ROLE CHECKERS
    // ============================================

    /**
     * Check apakah user adalah admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check apakah user adalah pegawai
     */
    public function isPegawai()
    {
        return $this->role === 'pegawai';
    }

    // ============================================
    // TASK CALCULATIONS
    // ============================================

    /**
     * Hitung jumlah tugas minggu ini
     */
    public function tugasMingguan()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        return $this->penugasan()
            ->whereBetween('assigned_at', [$startOfWeek, $endOfWeek])
            ->count();
    }

    /**
     * Hitung jumlah tugas bulan ini
     */
    public function tugasBulanan()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        return $this->penugasan()
            ->whereBetween('assigned_at', [$startOfMonth, $endOfMonth])
            ->count();
    }

    /**
     * Hitung jumlah tugas dalam periode tertentu
     */
    public function tugasPeriode($startDate, $endDate)
    {
        return $this->penugasan()
            ->whereBetween('assigned_at', [$startDate, $endDate])
            ->count();
    }

    /**
     * Hitung total jam kerja minggu ini
     */
    public function jamKerjaMingguan()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        return $this->penugasan()
            ->whereBetween('assigned_at', [$startOfWeek, $endOfWeek])
            ->with('tugas')
            ->get()
            ->sum(function ($penugasan) {
                return $penugasan->tugas->durasi ?? 0;
            });
    }

    /**
     * Hitung total jam kerja bulan ini
     */
    public function jamKerjaBulanan()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        return $this->penugasan()
            ->whereBetween('assigned_at', [$startOfMonth, $endOfMonth])
            ->with('tugas')
            ->get()
            ->sum(function ($penugasan) {
                return $penugasan->tugas->durasi ?? 0;
            });
    }

    // ============================================
    // AVAILABILITY CHECKS
    // ============================================

    /**
     * Check apakah pegawai bisa menerima tugas baru
     */
    public function canReceiveTask()
    {
        return $this->tugasMingguan() < $this->max_tugas_mingguan
            && $this->tugasBulanan() < $this->max_tugas_bulanan;
    }

    /**
     * Check apakah pegawai available di minggu ini
     */
    public function availableThisWeek()
    {
        return $this->tugasMingguan() < $this->max_tugas_mingguan;
    }

    /**
     * Check apakah pegawai available di bulan ini
     */
    public function availableThisMonth()
    {
        return $this->tugasBulanan() < $this->max_tugas_bulanan;
    }

    /**
     * Get sisa slot tugas minggu ini
     */
    public function sisaSlotMingguan()
    {
        return max(0, $this->max_tugas_mingguan - $this->tugasMingguan());
    }

    /**
     * Get sisa slot tugas bulan ini
     */
    public function sisaSlotBulanan()
    {
        return max(0, $this->max_tugas_bulanan - $this->tugasBulanan());
    }

    /**
     * Get persentase beban kerja mingguan
     */
    public function persentaseBebanMingguan()
    {
        if ($this->max_tugas_mingguan == 0) {
            return 0;
        }
        return round(($this->tugasMingguan() / $this->max_tugas_mingguan) * 100, 2);
    }

    /**
     * Get persentase beban kerja bulanan
     */
    public function persentaseBebanBulanan()
    {
        if ($this->max_tugas_bulanan == 0) {
            return 0;
        }
        return round(($this->tugasBulanan() / $this->max_tugas_bulanan) * 100, 2);
    }

    // ============================================
    // SCOPES
    // ============================================

    /**
     * Scope untuk pegawai saja
     */
    public function scopePegawai($query)
    {
        return $query->where('role', 'pegawai');
    }

    /**
     * Scope untuk admin saja
     */
    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope untuk pegawai yang available
     */
    public function scopeAvailable($query)
    {
        return $query->where('role', 'pegawai')
            ->whereHas('penugasan', function ($q) {
                $startOfWeek = Carbon::now()->startOfWeek();
                $endOfWeek = Carbon::now()->endOfWeek();
                $q->whereBetween('assigned_at', [$startOfWeek, $endOfWeek]);
            }, '<', DB::raw('max_tugas_mingguan'));
    }

    // ============================================
    // ACCESSORS & MUTATORS
    // ============================================

    /**
     * Get status ketersediaan pegawai
     */
    public function getStatusKetersediaanAttribute()
    {
        if (!$this->isPegawai()) {
            return null;
        }

        $persenMingguan = $this->persentaseBebanMingguan();

        if ($persenMingguan >= 100) {
            return 'penuh';
        } elseif ($persenMingguan >= 80) {
            return 'hampir_penuh';
        } elseif ($persenMingguan >= 50) {
            return 'sedang';
        } else {
            return 'tersedia';
        }
    }

    /**
     * Get warna badge status
     */
    public function getStatusColorAttribute()
    {
        $status = $this->status_ketersediaan;

        return match ($status) {
            'penuh' => 'bg-red-100 text-red-800',
            'hampir_penuh' => 'bg-orange-100 text-orange-800',
            'sedang' => 'bg-yellow-100 text-yellow-800',
            'tersedia' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
