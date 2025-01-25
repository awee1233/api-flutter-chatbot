<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatbotProvider extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'api_key',
        'endpoint',
        'config',
        'is_active'
    ];

    protected $casts = [
        'config' => 'array',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    /**
     * Get the chats associated with the provider
     */
    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class, 'provider_id');
    }

    /**
     * Encrypt API key when saving
     */
    public function setApiKeyAttribute($value)
    {
        $this->attributes['api_key'] = encrypt($value);
    }

    /**
     * Decrypt API key when retrieving
     */
    public function getApiKeyAttribute($value)
    {
        try {
            return decrypt($value);
        } catch (\Exception $e) {
            return $value;
        }
    }

    /**
     * Scope a query to only include active providers
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Check if provider has any chats
     */
    public function hasChats(): bool
    {
        return $this->chats()->exists();
    }

    /**
     * Toggle provider active status
     */
    public function toggleActive(): bool
    {
        $this->is_active = !$this->is_active;
        return $this->save();
    }
}
