<?php

namespace App\Applications\Post\DAL;

use App\Applications\Post\Model\Posts;
use Illuminate\Database\Eloquent\Collection;

interface CategoryDALInterface{

    public function getAll();

    public function getCategoryById($id);

//    public function getCategorysByUser($id);

    public function saveCategory($input);

    public function editCategory($id, $input);

    public function deleteCategory($id);

}
?>
