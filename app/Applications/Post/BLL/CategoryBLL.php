<?php

namespace App\Applications\Post\BLL;
use App\Applications\Post\DAL\CategoryDALInterface;
use App\Applications\Common\DAL\MediaDALInterface;
use Illuminate\Support\Facades\Auth;

/**
 * @property CategoryDALInterface $categoryDAL
*/
class CategoryBLL implements CategoryBLLInterface {

    public function __construct(
        CategoryDALInterface $categoryDAL,
        MediaDALInterface $mediaDAL
    ){
        $this->categoryDAL = $categoryDAL;
        $this->mediaDAL = $mediaDAL;
    }
    public function getAllCategories(){
        return $this->categoryDAL->getAll();
    }

    public function getCategoryById($id){
        return $this->categoryDAL->getCategoryById($id);
    }

    public function saveCategory($data){
        $category = $this->getEntryDataArray($data);
        // dd($Category);
        return $this->categoryDAL->saveCategory($data);
    }

    public function editCategory($request, $id){
        $category_data = $request->all();
        $category = $this->categoryDAL->getCategoryById($id);
        $this->categoryDAL->editCategory($category, $category_data);
    }

    public function deleteCategory($id){
        return $this->categoryDAL->deleteCategory($id);
    }

    public function getEntryDataArray($request) {
        $input = [];
        $input['title'] = $request['title'];
        $input['body'] = $request['body'];
        $input['user_id'] = Auth::user()->id;
        $input['creator'] =  Auth::user()->first_name;

        return $input;
    }

}
?>
