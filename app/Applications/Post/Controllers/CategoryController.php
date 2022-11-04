<?php

namespace App\Applications\Post\Controllers;

use App\Applications\Post\BLL\CategoryBLLInterface;
use App\Applications\Post\Requests\CategoryRequest;
use App\Http\Controllers\Controller;
/**
* @property CategoryBLLInterface $categoryBLL
 */
class CategoryController extends Controller
{
    public function __construct(
        CategoryBLLInterface $categoryBLL
    ){
        $this->categoryBLL = $categoryBLL;
    }
    public function allCategories(){
        return $this->categoryBLL->getAllCategories();
    }
    public function getCategoryById($id){
        return $this->categoryBLL->getCategoryById($id);
    }
//    public function getCategoryByUser(){
//        return $this->categoryBLL->getCommentByUser();
//    }
    public function saveCategory(CategoryRequest $request){
        return $this->categoryBLL->saveCategory( $request);
    }
    public function editCategory(CategoryRequest $request, $id){
        return $this->categoryBLL->editCategory($request,$id);
    }
    public function deleteCategory($id){
        return $this->categoryBLL->deleteCategory($id);
    }

}
?>
