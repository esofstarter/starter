<?php

namespace App\Applications\Post\BLL;



interface CategoryBLLInterface{

    public function getAllCategories();

    public function getCategoryById($id);

//    public function getCategorsByUser($id);

    public function saveCategory($request);

    public function editCategory($id, $request);

    public function deleteCategory($id);
}

?>
