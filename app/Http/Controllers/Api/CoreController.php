<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HasJsonInputValidation;
use App\Http\Controllers\Traits\HasJsonResponses;
use App\Models\User;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;

abstract class CoreController extends Controller
{
    use HasJsonResponses;
    use HasJsonInputValidation;

    protected $debugList = [];

    public function __construct()
    {
        if (config('app.add_sql_debug')) {
            /** @var self $self */
            $self = $this;
            DB::listen(function (QueryExecuted $sql) use ($self) {
                $bindings = array_map(function($bind) {
                    if ($bind instanceof \DateTime) {
                        return $bind->format('Y-m-d H:i:s');
                    } else {
                        return $bind;
                    }
                }, $sql->bindings);

                $query = $sql->sql;

                if ($sql->bindings) {
                    // insert bindings into sql
                    $query = vsprintf(str_replace(array('?'), array('\'%s\''), $sql->sql), $bindings);
                }

                $query = str_replace("\r\n"," ", $query);
                $self->debugList['sql'][] = "[{$sql->time}] $sql->connectionName: {$query}";
            });
        }
    }

    abstract static public function routers();

    protected function getPerPage(int $defaultPerPage)
    {
        if (!$defaultPerPage){
            $defaultPerPage = 15;
        }

        return (int) request()->get('perPage', $defaultPerPage);
    }
}
