<?php

class ProductController
{
    public function actionView($productId){

        $categories = array();
        $categories = Category::getCategoriesList();

        $product = array();
        $product = Product::getProductById($productId);

        require_once (ROOT . '/views/product/view.php');

        return true;
    }

    public function actionSearch(){

        $query = htmlspecialchars(trim($_POST['query']));

        if(empty($query)){
            header('Location: /');
        }

        $categories = array();
        $categories = Category::getCategoriesList();

        $products = array();
        $products = Product::search($query);

        require_once ROOT . '/views/site/search.php';
        return true;
    }
}