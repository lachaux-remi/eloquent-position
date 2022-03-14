# Eloquent Position

Position logic for Eloquent models with minimum setup. Before saving it will check if the position has changed and updates the other entries based on the models position value.

[![Build Status](https://travis-ci.com/lachaux-remi/eloquent-position.svg?token=uGgobxsLgjyHsLYYLyPt&branch=master)](https://travis-ci.com/lachaux-remi/eloquent-position)
[![License: MIT](https://img.shields.io/badge/License-MIT-brightgreen.svg?style=flat-square)](https://opensource.org/licenses/MIT)

* [Installation](#installation)
* [Usage](#usage)
    * [Migration example](#migration-example)
    * [Model example](#model-example)
    * [Command](#command)

## Installation

**Install via composer**

```
composer require lachaux-remi/eloquent-position
```

## Usage

1. Add a `position` (can be custom) column in your table (model)
2. Add `Position` traits into your model (if you are using custom column set the `$positionColumn` property)
3. If you are using grouped entries (like parent_id and etc), you can set the `$positionGroup` with the column name
4. Add to form the position input (can be input[type=number] and etc) and fill/set the position on save
5. When position is null or empty string, the last position will be used.

**Then you can get your entries sorted:**

```php
// ASC
YourModel::sorted()->get()

// DESC
YourModel::sortedByDESC()->get()
```

If using default column name (position), the value will be converted to numeric value (if not null or empty string).

**Get the position**
Use the `$model->getPosition()` or use the standard way by using the column name `$model->position`

### Migration example

```php
public function up()
    {
    Schema::table('pages', function (Blueprint $table) {
        $table->smallInteger('position')->default(0)->after('id');
    });

    // Update the order pages
    Artisan::call('model:position', [
        'model'=> \App\Models\Page\Page::class
    ]);
}
```

### Model example

```php
class Page extends Model
{
    use Position;

    public $table = 'pages';
    public $positionGroup = 'parent_id';

    protected $fillable = [
        'title', 'slug', 'parent_id', 'content', 'description', 'position'
    ];
    
}
```

### Command

#### Reposition command

This command will help you to fix the order of your models.

```bash
php artisan model:position App\\Models\\YourModel
```

## Copyright and License

[eloquent-position](https://github.com/lachaux-remi/eloquent-position)
was written by [Lachaux Rémi](http://www.remi-lachaux.fr) and is released under the
[MIT License](LICENSE.md).

Copyright (c) 2022 Lachaux Rémi