<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Scopes\OrderColumn;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Str;

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
 *
 * @method static \Database\Factories\BookmarkGroupFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|BookmarkGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookmarkGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookmarkGroup onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BookmarkGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|BookmarkGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookmarkGroup whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookmarkGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookmarkGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookmarkGroup whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookmarkGroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookmarkGroup whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookmarkGroup withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BookmarkGroup withoutTrashed()
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
    //endregion Relations

    //region Scopes
    //endregion Scopes

    //region Methods
    //endregion Methods
}
