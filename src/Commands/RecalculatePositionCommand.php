<?php

namespace LachauxRemi\EloquentPosition\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use LachauxRemi\EloquentPosition\Tests\Models\Model;
use LachauxRemi\EloquentPosition\Traits\Position;

class RecalculatePositionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'model:position {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculates given model position. You must provide full model class';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /** @var Model|Position $modelClass */
        $modelClass = $this->argument('model');

        /** @var Model|Position $model */
        $model = new $modelClass();
        if (!method_exists($model, 'newPositionQuery')) {
            $this->error("Model {$modelClass} is not using Position trait");
            return false;
        }

        $positionsByGroup = [];
        $group = $model->getPositionGroup();

        $modelClass::sorted()->chunk(200, function (Collection $collection) use ($group, &$positionsByGroup) {
            /** @var Model|Position $model */
            foreach ($collection as $model) {
                $groupKey = $this->buildGroupKeyForPosition($model, $group);
                $model->setPosition($this->getPositionForGroup($groupKey, $positionsByGroup))
                    ->save();
            }
        });

        $this->table([
            'Group', 'Last position'
        ], collect($positionsByGroup)->map(function ($value, $key) {
            return [$key, $value];
        }));
        return true;
    }

    /**
     * Stores/updates the next position
     *
     * @param string $groupKey
     * @param array  $positionsByGroup referenced array of currently stores positions
     * @return mixed
     */
    protected function getPositionForGroup(string $groupKey, array &$positionsByGroup)
    {
        if (!isset($positionsByGroup[$groupKey])) {
            $positionsByGroup[$groupKey] = 0;
        }

        $positionsByGroup[$groupKey]++;

        return $positionsByGroup[$groupKey];
    }

    /**
     * Builds the group key from the group columns and the values form the model
     *
     * @param Model|Position $model  The eloquent model
     * @param string|null    $group
     * @return string
     */
    protected function buildGroupKeyForPosition($model, ?string $group = null): string
    {
        if (is_null($group)) {
            return 'No group';
        }
        return (string) $model->{$group};
    }
}
