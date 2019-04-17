<?php

class SiteController
{
    public function actionIndex(){

        $categories = array();
        $categories = Category::getCategoriesList();

        $latestProducts = array();
        $latestProducts = Product::getLatestProducts(6);

        $recommendedProducts = array();
        $recommendedProducts = Product::getRecommendedProductsList();

        require_once (ROOT . '/views/site/index.php');

        return true;
    }

    public function actionContact(){
        $userEmail = '';
        $userText = '';
        $result = false;

        if(isset($_POST['submit'])){
            $errors = false;
            $userEmail = $_POST['userEmail'];
            $userText = $_POST['userText'];

            if(!User::checkEmail($userEmail)){
                $errors[] = 'Неправильный email';
            }

            if($errors == false){
                $adminEmail = 'mironenkonadya1999@gmail.com';
                $subject = 'Тема письма';
                $message = "Текст {$userText} .От {$userEmail}";
                //$result = mail($adminEmail, $subject, $message);
                //$result = true;
            }
        }

        require_once ROOT . '/views/site/contact.php';

        return true;
    }
}