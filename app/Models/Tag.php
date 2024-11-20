<?php

namespace App\Models;

use Spatie\Tags\Tag as SpatieTag;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Builder;

class Tag extends SpatieTag
{
    public function items()
    {
        return $this->morphedByMany(Item::class, 'taggable');
    }

    public function scopeForChangelog(Builder $query, Changelog $changelog): Builder
    {
        return $query
            ->where('changelog', '=', true)
            ->whereHas('items', function (Builder $query) use ($changelog) {
                return $query->whereHas('changelogs', function (Builder $query) use ($changelog) {
                    return $query->where('changelogs.id', $changelog->id);
                });
            });
    }
}
