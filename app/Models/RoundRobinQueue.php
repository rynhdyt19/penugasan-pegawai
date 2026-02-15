<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class RoundRobinQueue extends Model
{
    use HasFactory;

    protected $table = 'round_robin_queue';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'position',
        'total_assigned',
        'last_assigned_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'last_assigned_at' => 'datetime',
    ];

    // ============================================
    // RELATIONSHIPS
    // ============================================

    /**
     * Get user yang terkait
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ============================================
    // STATIC METHODS
    // ============================================

    /**
     * Initialize atau reset queue untuk semua pegawai
     */
    public static function initialize()
    {
        $pegawai = User::where('role', 'pegawai')->get();
        
        // Hapus queue yang sudah ada
        self::truncate();
        
        // Buat queue baru
        foreach ($pegawai as $index => $user) {
            self::create([
                'user_id' => $user->id,
                'position' => $index,
                'total_assigned' => 0,
                'last_assigned_at' => null,
            ]);
        }

        return self::count();
    }

    /**
     * Get pegawai berikutnya yang available
     */
    public static function getNextAvailable()
    {
        $queues = self::with('user')
            ->orderBy('position')
            ->get();

        // Cari pegawai yang bisa menerima tugas
        foreach ($queues as $queue) {
            if ($queue->user && $queue->user->canReceiveTask()) {
                return $queue;
            }
        }

        // Jika semua penuh, return null
        return null;
    }

    /**
     * Get pegawai dengan beban paling ringan
     */
    public static function getLeastLoaded()
    {
        return self::with('user')
            ->whereHas('user', function($q) {
                $q->where('role', 'pegawai');
            })
            ->orderBy('total_assigned')
            ->orderBy('position')
            ->first();
    }

    /**
     * Get statistik queue
     */
    public static function getStatistics()
    {
        $queues = self::with('user')->get();
        
        return [
            'total_pegawai' => $queues->count(),
            'total_assigned' => $queues->sum('total_assigned'),
            'avg_assigned' => $queues->avg('total_assigned'),
            'max_assigned' => $queues->max('total_assigned'),
            'min_assigned' => $queues->min('total_assigned'),
        ];
    }

    // ============================================
    // INSTANCE METHODS
    // ============================================

    /**
     * Rotate position ke akhir queue
     */
    public function rotate()
    {
        $maxPosition = self::max('position');
        
        // Update position ke akhir
        $this->position = $maxPosition + 1;
        $this->save();

        // Reorder semua position
        $queues = self::orderBy('position')->get();
        foreach ($queues as $index => $queue) {
            $queue->position = $index;
            $queue->save();
        }
    }

    /**
     * Increment total assigned
     */
    public function incrementAssigned()
    {
        $this->increment('total_assigned');
        $this->update(['last_assigned_at' => Carbon::now()]);
    }

    /**
     * Reset statistics
     */
    public function resetStats()
    {
        $this->update([
            'total_assigned' => 0,
            'last_assigned_at' => null,
        ]);
    }

    // ============================================
    // SCOPES
    // ============================================

    /**
     * Scope untuk pegawai yang available
     */
    public function scopeAvailable($query)
    {
        return $query->whereHas('user', function($q) {
            $q->where('role', 'pegawai');
        })->whereHas('user', function($q) {
            // Custom logic untuk check availability
        });
    }

    /**
     * Order by position
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('position');
    }

    // ============================================
    // ACCESSORS
    // ============================================

    /**
     * Get formatted last assigned
     */
    public function getLastAssignedFormattedAttribute()
    {
        return $this->last_assigned_at ? $this->last_assigned_at->format('d M Y H:i') : 'Belum pernah';
    }

    /**
     * Get days since last assigned
     */
    public function getDaysSinceLastAssignedAttribute()
    {
        if (!$this->last_assigned_at) {
            return null;
        }

        return Carbon::now()->diffInDays($this->last_assigned_at);
    }
}