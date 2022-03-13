<?php

namespace EloquentPosition\Commands;

use EloquentPosition\Traits\Position;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class RecalculatePositionCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = "model:position {model}";

    /**
     * The console command description.
     */
    protected $description = "Recalculates given model position. You must provide full model class";

    /**
     * Execute the console command.
     */
    public function handle(): bool
    {
        /** @var Model|Position $modelClass */
        $modelClass = $this->argument( "model" );

        /** @var Model|Position $model */
        $model = new $modelClass();
        if ( !method_exists( $model, "newPositionQuery" ) ) {
            $this->error( "Model {$modelClass} is not using Position trait" );
            return false;
        }

        $positionsByGroup = [];
        $group = $model->getPositionGroup();

        $modelClass::sorted()->chunk( 200, function (Collection $collection) use ($group, &$positionsByGroup) {
            /** @var Model|Position $model */
            foreach ( $collection as $model ) {
                $groupKey = $this->buildGroupKeyForPosition( $model, $group );
                $model->setPosition( $this->getPositionForGroup( $groupKey, $positionsByGroup ) )
                    ->save();
            }
        } );

        $this->table( [ "Group", "Last position", ], collect( $positionsByGroup )->map( function ($value, $key) {
            return [ $key, $value ];
        } ) );
        return true;
    }

    /**
     * Builds the group key from the group columns and the values form the model
     */
    protected function buildGroupKeyForPosition(Model|Position $model, ?string $group = null): string
    {
        if ( is_null( $group ) ) {
            return "No group";
        }
        return (string) $model->{$group};
    }

    /**
     * Stores/updates the next position
     */
    protected function getPositionForGroup(string $groupKey, array &$positionsByGroup)
    {
        if ( !isset( $positionsByGroup[$groupKey] ) ) {
            $positionsByGroup[$groupKey] = 0;
        }

        $positionsByGroup[$groupKey]++;

        return $positionsByGroup[$groupKey];
    }
}