<?php

class AdminCategoryController extends AdminBase {
    public function actionIndex(){
        self::checkAdmin();

        $categoriesList = Category::getCategoriesListAdmin();

        require_once ROOT . '/views/admin_category/index.php';

        return true;
    }

    public function actionCreate(){
        self::checkAdmin();

        if(isset($_POST['submit'])) {
            $name = $_POST['name'];
            $sort_order = $_POST['sort_order'];
            $status = $_POST['status'];

            $errors = false;
            if (!isset($name) && $name) {
                $errors[] = "Заполните поля";
            }

            if ($errors == false) {
                Category::createCategory($name, $sort_order, $status);

                header('Location: /admin/category');
            }
        }

        require_once ROOT . '/views/admin_category/create.php';
        return true;
    }

    public function actionUpdate($id){
        self::checkAdmin();

        $category = Category::getCategoryById($id);

        if(isset($_POST['submit'])) {
            $name = $_POST['name'];
            $sort_order = $_POST['sort_order'];
            $status = $_POST['status'];


            if(Category::updateCategory($id, $name, $sort_order, $status)){

                header('Location: /admin/category');
            }
        }

        require_once ROOT . '/views/admin_category/update.php';
        return true;
    }

    public function actionDelete($id){
        self::checkAdmin();

        if(isset($_POST['submit'])){
            Category::deleteCategoryById($id);

            header('Location: /admin/category');
        }

        require_once ROOT . '/views/admin_category/delete.php';

        return true;
    }
}