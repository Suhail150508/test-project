<?php


namespace App\Interfaces;


interface BaseInterface
{
    public function datatable(array $parameter = null);

    public function deletedDatatable(array $parameter = null);

    public function query();

    public function pluck(array $where_array = null);

    public function get(array $where_array = null);

    public function selectRawPluck(array $params = null);

    public function find($id);
    
    public function where($column, $operator = null, $value = null, $boolean = 'and');

    public function findOrFail($id);

    public function first(array $params = null);

    public function all();

    public function onlyTrashed();

    public function create(object $data, array $parameters = null);

    public function update($id, object $data, array $parameters = null);

    public function delete($id, array $relations = null);

    public function forceDelete($id, array $relations = null);

    public function restore($id, array $relations = null);

    public function with(array $array);

    public function status($id);

    public function multipleDelete(object $data);

    public function multipleRestore(object $data);

    public function model();
}
