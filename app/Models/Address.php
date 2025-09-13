<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'addressable_type',
        'addressable_id',
        'type',
        'name',
        'company',
        'phone',
        'line1',
        'line2',
        'city',
        'state',
        'postal_code',
        'country',
        'is_default',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'meta' => 'array',
            'is_default' => 'boolean',
        ];
    }

    /**
     * Get the parent addressable model
     */
    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get full address as string
     */
    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->line1,
            $this->line2,
            $this->city,
            $this->state,
            $this->postal_code,
            $this->country,
        ]);

        return implode(', ', $parts);
    }

    /**
     * Create address from form data
     */
    public static function createFromForm(array $data, Model $addressable, string $type): self
    {
        return static::create([
            'addressable_type' => get_class($addressable),
            'addressable_id' => $addressable->id,
            'type' => $type,
            'name' => $data['name'] ?? null,
            'company' => $data['company'] ?? null,
            'phone' => $data['phone'] ?? null,
            'line1' => $data['line1'],
            'line2' => $data['line2'] ?? null,
            'city' => $data['city'],
            'state' => $data['state'] ?? null,
            'postal_code' => $data['postal_code'] ?? null,
            'country' => $data['country'],
        ]);
    }

    /**
     * Set as default address for this type
     */
    public function setAsDefault(): void
    {
        // Remove default from other addresses of same type
        static::where('addressable_type', $this->addressable_type)
            ->where('addressable_id', $this->addressable_id)
            ->where('type', $this->type)
            ->where('id', '!=', $this->id)
            ->update(['is_default' => false]);

        // Set this as default
        $this->update(['is_default' => true]);
    }

    /**
     * Get country name from code
     */
    public function getCountryNameAttribute(): string
    {
        $countries = [
            'US' => 'United States',
            'CA' => 'Canada',
            'GB' => 'United Kingdom',
            'AU' => 'Australia',
            'DE' => 'Germany',
            'FR' => 'France',
            'IT' => 'Italy',
            'ES' => 'Spain',
            'NL' => 'Netherlands',
            'BE' => 'Belgium',
            'CH' => 'Switzerland',
            'AT' => 'Austria',
            'SE' => 'Sweden',
            'NO' => 'Norway',
            'DK' => 'Denmark',
            'FI' => 'Finland',
            'PL' => 'Poland',
            'CZ' => 'Czech Republic',
            'HU' => 'Hungary',
            'SK' => 'Slovakia',
            'SI' => 'Slovenia',
            'HR' => 'Croatia',
            'BG' => 'Bulgaria',
            'RO' => 'Romania',
            'GR' => 'Greece',
            'PT' => 'Portugal',
            'IE' => 'Ireland',
            'LU' => 'Luxembourg',
            'MT' => 'Malta',
            'CY' => 'Cyprus',
            'EE' => 'Estonia',
            'LV' => 'Latvia',
            'LT' => 'Lithuania',
        ];

        return $countries[$this->country] ?? $this->country;
    }
}
