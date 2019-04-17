<?php

class Category
{
    public static function getCategoriesList(){
        $db = Db::getConnection();
        $categoryList = array();
        $result = $db->query("SELECT id, name FROM category WHERE status = '1' ORDER BY sort_order ASC");

        $i = 0;
        while ($row = $result->fetch()){
            $categoryList[$i]['id'] = $row['id'];
            $categoryList[$i]['name'] = $row['name'];
            $i++;
        }

        return $categoryList;
    }

    public static function getCategoriesListAdmin(){
        $db = Db::getConnection();
        $categoryList = array();
        $result = $db->query("SELECT id, name, sort_order, status FROM category ORDER BY sort_order ASC");

        $i = 0;
        while ($row = $result->fetch()){
            $categoryList[$i]['id'] = $row['id'];
            $categoryList[$i]['name'] = $row['name'];
            $categoryList[$i]['sort_order'] = $row['sort_order'];
            $categoryList[$i]['status'] = $row['status'];
            $i++;
        }

        return $categoryList;
    }

    public static function createCategory($name, $sort_order, $status) {
        $db = Db::getConnection();

        $sql = "INSERT INTO category (name, sort_order, status) VALUES (:name, :sort_order, :status)";
        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':sort_order', $sort_order, PDO::PARAM_INT);
        $result->bindParam(':status', $status, PDO::PARAM_INT);

        return $result->execute();
    }

    public static function getCategoryById($id){
        $id = intval($id);
        if($id) {
            $db = Db::getConnection();
            $result = $db->query("SELECT id, name, sort_order, status FROM category WHERE id = " . $id);
            $result->setFetchMode(PDO::FETCH_ASSOC);
        }

        return $result->fetch();
    }

    public static function updateCategory($id, $name, $sort_order, $status){
        $db = Db::getConnection();

        $sql = "UPDATE category SET name =  :name, sort_order = :sort_order, status = :status WHERE id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':sort_order', $sort_order, PDO::PARAM_INT);
        $result->bindParam(':status', $status, PDO::PARAM_INT);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        return $result->execute();
    }

    public static function deleteCategoryById($id){
        $db = Db::getConnection();
        $sql = 'DELETE FROM category WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }

    public static function getStatusText($status)
    {
        switch ($status) {
            case '1':
                return 'Отображается';
                break;
            case '0':
                return 'Скрыта';
                break;
        }
    }
}