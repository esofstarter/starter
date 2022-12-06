<?php

namespace App\Applications\Post\DAL;
use App\Applications\Post\Model\Category;
use App\Applications\User\Model\User;

/**
 * @property Category $category
 */
class CategoryDAL implements CategoryDALInterface {

    public function __construct(
        Category $category,
        User $user
    ){
        $this->category = $category;
        $this->user = $user;
    }
    public function getAll(){
        // $query = DB::table('users')->select('username')->join('posts', 'user_id', '=', 'users.id');
        // $username = $query->get();

        return $this->category::all();
    }
    public function getCategoryById($id){
        return $this->category::findOrFail($id);
    }

    public function getCategoryBySlug($slug){
        return $this->category->where('slug',$slug)->first();
    }
//    public function getCategoryByUser($id){
//        return $this->category::whereHas('user_id', function($q){
//            $q->where('user_id');
//        })->get();
//    }
    public function saveCategory($input){
        // dd($input);
        return $this->category->create($input);
    }
    public function editCategory($category, $input){
        return $category->update($input);
    }
    public function deleteCategory($id){
        return $this->category
            ->where('id', $id)
            ->delete();
    }

}
?>
