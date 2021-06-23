<?php

use Config\Query;

spl_autoload_register(function ($class) {
    $file = str_replace(['.', '\\', '//', '///'], '/', $class) . '.php';
    return file_exists($file) ? require_once($file) : false;
});
$db = new Query();
header('Content-type: application/json; charset=UTF-8');
if (isset($db)) {
    $result = [];
    $result['request'] = $_REQUEST;

    extract($_REQUEST);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($table)) {
        $result['table'] = $table;
        $data = $db->validation($_REQUEST, $db->tableColumns($table));

        if (isset($insert)) {
            $result = array_merge($result, $db->create($table, $data));
        }
        if (isset($edit) || isset($update)) {
            $id = isset($edit) ? $edit:$update;
            $response = $db->update($table, $data, ['id' => $id]);
            $result = array_merge($result, $response);
        }
        if (isset($delete)) {
            $db->delete($table, "id={$id}");
        }
        if (isset($todoToggle)) {
            $db->update($table, ['active' => $todoToggle]);
        }
        // $result['data'] = $db->get($table);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($table)) {
        $result['table'] = $table;
        if (isset($delete)) {
            $result['action'] = $db->delete($table, "id={$id}");
        } elseif (isset($id)) {
            $result['data'] = $db->get($table, "id={$id}");
        } else {
            $dataContainer = [];
            $tables = explode(',', $table);
            foreach ($tables as $table) {
                $dataContainer[$table] = $db->get($table);
            }
            $result['data'] = $dataContainer;
        }
    }
}

echo json_encode($result);
die();
