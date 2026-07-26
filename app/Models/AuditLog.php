<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class AuditLog extends Model
{
    protected $fillable = ['user_id', 'action', 'description', 'model', 'model_id', 'ip_address', 'old_values', 'new_values'];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        if (!empty($filters['action'])) {
            $query->where('action', $filters['action']);
        }

        if (!empty($filters['model'])) {
            $query->where('model', $filters['model']);
        }

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function (Builder $q) use ($search) {
                $q->where('description', 'LIKE', "%{$search}%")
                  ->orWhere('model', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function (Builder $uq) use ($search) {
                      $uq->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        return $query;
    }

    public function getDiffTextAttribute(): string
    {
        $parts = [];
        if ($this->old_values && $this->new_values) {
            $allKeys = array_unique(array_merge(array_keys($this->old_values), array_keys($this->new_values)));
            foreach ($allKeys as $key) {
                $old = $this->old_values[$key] ?? '(empty)';
                $new = $this->new_values[$key] ?? '(empty)';
                if ($old != $new) {
                    $parts[] = ucfirst(str_replace('_', ' ', $key)) . ': ' . $old . ' → ' . $new;
                }
            }
        } elseif ($this->new_values) {
            foreach ($this->new_values as $key => $value) {
                $parts[] = ucfirst(str_replace('_', ' ', $key)) . ': ' . $value;
            }
        }
        return implode(' | ', $parts);
    }

    public function getActionColorAttribute(): string
    {
        return match($this->action) {
            'created' => 'success',
            'updated' => 'info',
            'deleted' => 'danger',
            'logged_in' => 'success',
            'logged_out' => 'warning',
            default => 'info',
        };
    }

    public function getActionIconAttribute(): string
    {
        return match($this->action) {
            'created' => '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>',
            'updated' => '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>',
            'deleted' => '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>',
            default => '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>',
        };
    }
}
