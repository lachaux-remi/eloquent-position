<?php

namespace EloquentPosition\Test\Models;

use Closure;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * Class Model
 *
 * @method static $this whereKey( mixed $id )
 * @method static $this whereKeyNot( mixed $id )
 * @method static $this where( string|array|Closure $column, mixed $operator = null, mixed $value = null, string $boolean = 'and' )
 * @method static $this orWhere( string|array|Closure $column, mixed $operator = null, mixed $value = null )
 * @method static $this latest( string $column = null )
 * @method static $this oldest( string $column = null )
 * @method static $this|Collection|static[]|static|null find( mixed $id, array $columns = [ '*' ] )
 * @method static Collection findMany( Arrayable|array $ids, array $columns = [ '*' ] )
 * @method static $this|Collection|static[]|static|null findOrFail( mixed $id, array $columns = [ '*' ] )
 * @method static $this|static findOrNew( mixed $id, array $columns = [ '*' ] )
 * @method static $this|static firstOrNew( array $attributes, array $values = [] )
 * @method static $this|static firstOrCreate( array $array, array $array = [] )
 * @method static $this|static updateOrCreate( array $attributes, array $values = [] )
 * @method static $this|static firstOrFail( array $columns = [ '*' ] )
 * @method static $this|static|mixed firstOr( Closure|array $columns = [ '*' ], Closure|null $callback = null )
 * @method static mixed value( string $column )
 * @method static Collection|static[] get( array $columns = [ '*' ] )
 * @method static $this[]|static[] getModels( array $columns = [ '*' ] )
 * @method static $this create( array $attributes = [] )
 * @method static $this forceCreate( array $attributes )
 * @method static int update( array $values )
 * @method static int increment( string $column, float|int $amount = 1, array $extra = [] )
 * @method static int decrement( string $column, float|int $amount = 1, array $extra = [] )
 * @method mixed $this delete()
 * @method static mixed forceDelete()
 * @method static $this with( mixed $relations )
 * @method static $this without( mixed $relations )
 */
class Model extends BaseModel
{
    //
}