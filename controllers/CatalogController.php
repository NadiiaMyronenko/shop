<?php

class CatalogController
{
    public function actionIndex($page = 1){
        $categories = array();
        $categories = Category::getCategoriesList();

        $total = Product::getTotalProducts();

        $latestProducts = array();
        $latestProducts = Product::getProductsForCatalog($page);


        $pagination = new Pagination($total, $page, Product::SHOW_BY_DEFAULT, 'page-');

        require_once (ROOT . '/views/catalog/index.php');

        return true;
    }

    public function actionCategory($categoryId, $page = 1){
        $categories = array();
        $categories = Category::getCategoriesList();

        $categoryProducts = array();
        $categoryProducts = Product::getProductsListByCategory($categoryId, $page);

        $total = Product::getTotalProductsInCategory($categoryId);

        $pagination = new Pagination($total, $page, Product::SHOW_BY_DEFAULT, 'page-');

        require_once (ROOT . '/views/catalog/category.php');
        return true;
    }
}