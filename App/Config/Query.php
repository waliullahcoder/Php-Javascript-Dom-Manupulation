<?php


namespace Config;

use Config\Db;

class Query extends Db
{

    // input value filter start
    public function input_field_validation($val, $null_check)
    {
        if (is_array($val)) {
            return $this->validation($val, $null_check);
        }
        $data = trim($val);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        $data = trim($data);
        if (isset($null_check)) {
            $data = isset($data) ? $data : '';
        }
        return $data;
    }

    public function validation($data_, $tableColumns = [], $null_check = null, $remove = null)
    {
        if (is_array($data_)) {
            $dataArray = array();
            foreach ($data_ as $key => $value) {
                if (in_array($key, $tableColumns)) {
                    if (is_array($value)) {
                        if (!empty($value)) {
                            $sub_value_array = [];
                            foreach ($value as $sub_key => $array_value) {
                                $sub_value_array[$sub_key] = $this->input_field_validation($array_value, $null_check);
                            }
                            $dataArray[$key] = $sub_value_array;
                        }
                        $dataArray[$key] = $value;
                    } else {
                        $value = $this->input_field_validation($value, $null_check);
                        if (isset($remove) && !empty($value)) {
                            $dataArray[$key] = $value;
                        } elseif (!isset($remove)) {
                            $dataArray[$key] = $value;
                        }
                    }
                }
            }
            return $dataArray;
        } else {
            return $this->input_field_validation($data_, $null_check);
        }
    } // input value filter end



    public function tableColumns($table)
    {
        $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '{$table}'";
        $result = self::connect()->query($sql);
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row['COLUMN_NAME'];
            }
            return $data;
        }
    }

    // Where data process
    public function where($data)
    {
        if (is_array($data)) {
            $condition = implode(' AND ', array_map(function ($key, $value) {
                return "`{$key}`='$value'";
            }, array_keys($data), $data));
        } elseif (is_string($data)) {
            $condition = $data;
        }
        $condition = empty($condition) ? '' : "WHERE " . $condition;
        return $condition;
    }

    // update table info by condition
    public function update($table = '', $data = [], $condition = '')
    {
        if (!empty($data)) {
            $data = implode(', ', array_map(function ($key, $value) {
                return "`{$key}`='$value'";
            }, array_keys($data), $data));
        }

        $condition = $this->where($condition);
        $sql = "UPDATE {$table} SET $data {$condition}";
        $result = self::connect()->query($sql);

        $sql = "SELECT * FROM {$table} {$condition} LIMIT 1";
        $data = self::connect()->query($sql)->fetch_assoc();
        return ['action' => $result, 'data' => $data];
    }

    // Insert data to table
    public function create($table = '', $data = [])
    {
        $key = implode('`, `', array_keys($data));
        $value = implode("', '", array_values($data));
        $sql = "INSERT INTO `{$table}` (`{$key}`) VALUES('{$value}')";

        $result = self::connect()->query($sql);
        $currentRow = $this->getLastRow($table);
        return ['action' => $result, 'data' => $currentRow];
    }

    public function getLastRow($table)
    {
        $sql = "SELECT * FROM {$table} ORDER BY ID DESC LIMIT 1";
        return self::connect()->query($sql)->fetch_assoc();
    }
    // Delete table info by condition
    public function delete($table = '', $condition = '')
    {
        $condition = $this->where($condition);
        $sql = "DELETE FROM {$table} {$condition}";
        return self::connect()->query($sql);
    }

    // Get data from table by condition
    public function get($table = '', $condition = '')
    {
        $condition = empty($condition) ? '' : $this->where($condition);
        $sql = "SELECT * FROM {$table} {$condition}";
        $result = self::connect()->query($sql);
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
    }

    // Get data from table by condition
    public function fileUploadManage($fileKey = 'image', $path = '../../uploads/', $oldFile = false)
    {
        if (!empty($data) && isset($_FILES[$fileKey]['name'])) {
            $filename = $_FILES[$fileKey]['name'];

            // Valid image file extensions
            $valid_extensions = array("jpg", "jpeg", "png", "pdf");


            // File extension
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            if (in_array(strtolower($extension), $valid_extensions)) {

                // check file path is exists. if not exists create directory
                if (!file_exists($path)) {
                    mkdir($path);
                }

                // generate new file name with given path
                $filePath = $path . md5(round(time())) . '.' . $extension;

                // file move is success check
                if (move_uploaded_file($_FILES[$fileKey]['tmp_name'], $filePath)) {
                    // replace directory to access from index page
                    $paths = array("../", "../..", "../../");
                    $filePath = str_replace($paths, '', $filePath);

                    // old file is exists then delete old file
                    if ($oldFile && file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                    // return new file
                    return $filePath;
                } else {
                    return ['error' => 'Sorry! File upload is failed.'];
                }
            } else {
                return ['error' => 'Sorry! Invalid file.'];
            }
        }
        return $oldFile ? $oldFile : '';
    }
}
