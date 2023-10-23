<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Scopes\OrderColumn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Bookmark> $bookmarks
 * @property-read int|null $bookmarks_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Team> $teams
 * @property-read int|null $teams_count
 *
 * @method static Builder|BookmarkGroup accessible()
 * @method static \Database\Factories\BookmarkGroupFactory factory($count = null, $state = [])
 * @method static Builder|BookmarkGroup newModelQuery()
 * @method static Builder|BookmarkGroup newQuery()
 * @method static Builder|BookmarkGroup onlyTrashed()
 * @method static Builder|BookmarkGroup query()
 * @method static Builder|BookmarkGroup whereCreatedAt($value)
 * @method static Builder|BookmarkGroup whereDeletedAt($value)
 * @method static Builder|BookmarkGroup whereId($value)
 * @method static Builder|BookmarkGroup whereName($value)
 * @method static Builder|BookmarkGroup whereOrder($value)
 * @method static Builder|BookmarkGroup whereUpdatedAt($value)
 * @method static Builder|BookmarkGroup whereUuid($value)
 * @method static Builder|BookmarkGroup withTrashed()
 * @method static Builder|BookmarkGroup withoutTrashed()
 *
 * @mixin \Eloquent
 */
class BookmarkGroup extends Model
{
    //region Traits
    use HasFactory;
    use SoftDeletes;
    //endregion Traits

    //region Constants
    //endregion Constants

    //region ORM
    protected $table = 'bookmark_groups';

    protected $fillable = [
        'name',
        'uuid',
        'order',
    ];

    protected static function boot()
    {
        self::creating(function (BookmarkGroup $model) {
            $model->uuid = Str::uuid();

            $model->order = BookmarkGroup::max('order') + 1;
        });

        static::addGlobalScope(new OrderColumn);

        parent::boot();
    }
    //endregion ORM

    //region Relations
    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class, 'bookmark_group_id', 'id');
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(
            Team::class,
            'bookmark_group_team',
            'bookmark_group_id',
            'team_id',
            'id',
            'id'
        );
    }
    //endregion Relations

    //region Scopes
    public function scopeAccessible(Builder $builder): Builder
    {
        return $builder->where(function (Builder $builder) {
            $builder->whereDoesntHave('teams')
                ->orWhereHas('teams', fn (Builder $builder) => $builder->isMember(Auth::user()));
        });
    }
    //endregion Scopes

    //region Methods
    //endregion Methods
}
