<?php
// Gets all subcategories by category id
header("Access-Control-Allow-Origin: *");

$db = new SQLite3('./db/module.db');

$parent_id = (int)$_GET['parent_id'];

$result_object =  new \stdClass();

$query = $db->query('SELECT * FROM categories WHERE parent_id='.$parent_id.' ORDER BY name');

$parent_name = $db->query('SELECT name from categories where id='.$parent_id)->fetchArray()[0];

$subcategories = array();

while ($row = $query->fetchArray()) {
        $has_files = false;
    $files_result = $db->query('SELECT COUNT(*) as count FROM files WHERE category_id='.$row['id'].'');
    $files_row = $files_result->fetchArray();
    $numRows = $files_row['count'];
    if($numRows !== 0) {
        $has_files = true;
    }
    else{
        $has_files = false; 
    }
    $subcategories[] = [
        'id' => $row['id'],
        'name' => $row['name'],
        'has_files'=> $has_files
    ];
   $result_object->parentName= $parent_name;
   $result_object->subcategories= $subcategories;

}
 
print(json_encode($result_object));



