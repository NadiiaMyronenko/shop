<?php

class AdminProductController extends AdminBase
{
    public function actionIndex(){
        self::checkAdmin();

        $productsList = Product::getProductsList();

        require_once ROOT . '/views/admin_product/index.php';

        return true;
    }

    public function actionCreate(){
        self::checkAdmin();

        $categoriesList = array();
        $categoriesList = Category::getCategoriesListAdmin();

        if(isset($_POST['submit'])) {
            $option['name'] = $_POST['name'];
            $option['code'] = $_POST['code'];
            $option['price'] = $_POST['price'];
            $option['category_id'] = $_POST['category_id'];
            $option['description'] = $_POST['description'];
            $option['author'] = $_POST['author'];
            $option['publishing_house'] = $_POST['publishing_house'];
            $option['page_number'] = $_POST['page_number'];
            $option['year'] = $_POST['year'];
            $option['availability'] = $_POST['availability'];
            $option['is_new'] = $_POST['is_new'];
            $option['is_recommended'] = $_POST['is_recommended'];
            $option['status'] = $_POST['status'];


            $errors = false;
            if (!isset($option['name']) && $option['name']) {
                $errors[] = "Заполните поля";
            }

            if ($errors == false) {
                $id = Product::createProduct($option);
                if($id){
                    if(is_uploaded_file($_FILES['image']['tmp_name'])){
                        move_uploaded_file($_FILES['image']['tmp_name'], ROOT . "/upload/images/products/{$id}.jpg");
                    }
                }

                header('Location: /admin/product');
            }
        }

        require_once ROOT . '/views/admin_product/create.php';
        return true;
    }

    public function actionUpdate($id){
        self::checkAdmin();

        $categoriesList = array();
        $categoriesList = Category::getCategoriesListAdmin();

        $product = Product::getProductById($id);

        if(isset($_POST['submit'])) {
            $option['name'] = $_POST['name'];
            $option['code'] = $_POST['code'];
            $option['price'] = $_POST['price'];
            $option['category_id'] = $_POST['category_id'];
            $option['description'] = $_POST['description'];
            $option['author'] = $_POST['author'];
            $option['publishing_house'] = $_POST['publishing_house'];
            $option['page_number'] = $_POST['page_number'];
            $option['year'] = $_POST['year'];
            $option['availability'] = $_POST['availability'];
            $option['is_new'] = $_POST['is_new'];
            $option['is_recommended'] = $_POST['is_recommended'];
            $option['status'] = $_POST['status'];


            if(Product::updateProduct($id, $option)){
                if(is_uploaded_file($_FILES['image']['tmp_name'])){
                    move_uploaded_file($_FILES['image']['tmp_name'], ROOT . "/upload/images/products/{$id}.jpg");
                }
                header('Location: /admin/product');
            }
        }


        require_once ROOT . '/views/admin_product/update.php';
        return true;
    }

    public function actionDelete($id){
        self::checkAdmin();

        if(isset($_POST['submit'])){
            Product::deleteProductById($id);

            header('Location: /admin/product');
        }

        require_once ROOT . '/views/admin_product/delete.php';

        return true;
    }
}