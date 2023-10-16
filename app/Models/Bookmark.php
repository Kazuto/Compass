<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Scopes\OrderColumn;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * App\Models\Bookmark
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string $url
 * @property string|null $icon
 * @property int $order
 * @property int $bookmark_group_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\BookmarkGroup|null $bookmarkGroup
 *
 * @method static \Database\Factories\BookmarkFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark whereBookmarkGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Bookmark extends Model
{
    //region Traits
    use HasFactory;
    use SoftDeletes;
    //endregion Traits

    //region Constants
    //endregion Constants

    //region ORM
    protected $table = 'bookmarks';

    protected $fillable = [
        'name',
        'url',
        'icon',
        'order',
        'bookmark_group_id',
    ];

    protected static function boot()
    {
        self::creating(function (Bookmark $model) {
            $model->uuid = Str::uuid();

            $model->order = Bookmark::where('bookmark_group_id', '=', $model->bookmark_group_id)->max('order') + 1;
        });

        static::addGlobalScope(new OrderColumn);

        parent::boot();
    }
    //endregion ORM

    //region Relations
    public function bookmarkGroup(): BelongsTo
    {
        return $this->belongsTo(BookmarkGroup::class, 'bookmark_group_id', 'id');
    }
    //endregion Relations

    //region Scopes
    //endregion Scopes

    //region Methods
    //endregion Methods
}
