<?php

class Product
{
    const SHOW_BY_DEFAULT = 9;

    public static function getLatestProducts($count = self::SHOW_BY_DEFAULT){
        $count = intval($count);
        $db = Db::getConnection();

        $productsList = array();

        $result = $db->query("SELECT id, name, price, author, publishing_house, page_number, year, is_new FROM product
                    WHERE status = 1 ORDER BY id DESC LIMIT " . $count);

        $i = 0;
        while($row = $result->fetch()){
             $productsList[$i]['id'] = $row['id'];
             $productsList[$i]['name'] = $row['name'];
             $productsList[$i]['price'] = $row['price'];
             $productsList[$i]['is_new'] = $row['is_new'];
             $productsList[$i]['author'] = $row['author'];
             $productsList[$i]['publishing_house'] = $row['publishing_house'];
             $productsList[$i]['page_number'] = $row['page_number'];
             $productsList[$i]['year'] = $row['year'];
             $i++;
        }

        return $productsList;
    }

    public static function getProductsForCatalog($page = 1){
        $db = Db::getConnection();

        $productsList = array();
        $offset = ($page - 1) * self::SHOW_BY_DEFAULT;

        $result = $db->query("SELECT id, name, price, author, publishing_house, page_number, year, is_new FROM product
                    WHERE status = 1 ORDER BY id DESC LIMIT " . self::SHOW_BY_DEFAULT . " OFFSET " . $offset);
        $i = 0;
        while($row = $result->fetch()){
            $productsList[$i]['id'] = $row['id'];
            $productsList[$i]['name'] = $row['name'];
            $productsList[$i]['price'] = $row['price'];
            $productsList[$i]['is_new'] = $row['is_new'];
            $productsList[$i]['author'] = $row['author'];
            $productsList[$i]['publishing_house'] = $row['publishing_house'];
            $productsList[$i]['page_number'] = $row['page_number'];
            $productsList[$i]['year'] = $row['year'];
            $i++;
        }

        return $productsList;
    }

    public static function getProductsListByCategory($categoryId = false, $page = 1){
        if($categoryId) {
            $db = Db::getConnection();

            $products = array();
            $offset = ($page - 1) * self::SHOW_BY_DEFAULT;

            $result = $db->query("SELECT id, name, price, author, publishing_house, page_number, year, is_new FROM product
                  WHERE status = '1' AND category_id = '$categoryId' ORDER BY id DESC  
                  LIMIT " . self::SHOW_BY_DEFAULT
                  . " OFFSET " . $offset);
            $i = 0;
            while($row = $result->fetch()){
                $products[$i]['id'] = $row['id'];
                $products[$i]['name'] = $row['name'];
                $products[$i]['price'] = $row['price'];
                $products[$i]['is_new'] = $row['is_new'];
                $products[$i]['author'] = $row['author'];
                $products[$i]['publishing_house'] = $row['publishing_house'];
                $products[$i]['page_number'] = $row['page_number'];
                $products[$i]['year'] = $row['year'];
                $i++;
            }
        }
        return $products;
    }

    public static function getProductById($id){
        $id = intval($id);

        if($id){
            $db = Db::getConnection();
            $result = $db->query("SELECT * FROM product WHERE id = " . $id);
            $result->setFetchMode(PDO::FETCH_ASSOC);
        }
        return $result->fetch();
    }

    public static function getTotalProducts(){
        $db = Db::getConnection();
        $result = $db->query("SELECT count(id) as count FROM product WHERE status = '1'");
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();

        return $row['count'];
    }

    public static function getTotalProductsInCategory($catedoryId){
        $db = Db::getConnection();
        $result = $db->query("SELECT count(id) as count FROM product WHERE status = '1' 
                                  AND category_id = " . $catedoryId);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();

        return $row['count'];
    }

    public static function getProductsByIds($idsArray){
        $products = array();

        $db = Db::getConnection();

        $idsString = implode(', ', $idsArray);

        $sql = "SELECT * FROM product WHERE status = '1' AND id IN ($idsString)";
        $result = $db->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);

        $i = 0;
        while($row = $result->fetch()){
            $products[$i]['id'] = $row['id'];
            $products[$i]['code'] = $row['code'];
            $products[$i]['name'] = $row['name'];
            $products[$i]['price'] = $row['price'];
            $products[$i]['author'] = $row['author'];
            $products[$i]['publishing_house'] = $row['publishing_house'];
            $products[$i]['page_number'] = $row['page_number'];
            $products[$i]['year'] = $row['year'];
            $i++;
        }
        return $products;
    }

    public static function getRecommendedProductsList(){
        $recommendedProducts = array();
        $db = Db::getConnection();

        $sql = "SELECT * FROM product WHERE status = '1' AND is_recommended = '1' ORDER BY id DESC";
        $result = $db->query($sql);

        $i = 0;
        while($row = $result->fetch()){
            $recommendedProducts[$i]['id'] = $row['id'];
            $recommendedProducts[$i]['name'] = $row['name'];
            $recommendedProducts[$i]['price'] = $row['price'];
            $recommendedProducts[$i]['is_new'] = $row['is_new'];
            $i++;
        }
        return $recommendedProducts;
    }

    public static function getProductsList(){
        $productsList = array();

        $db = Db::getConnection();

        $sql = "SELECT * FROM product ORDER BY id ASC";
        $result = $db->query($sql);

        $i = 0;
        while($row = $result->fetch()){
            $productsList[$i]['id'] = $row['id'];
            $productsList[$i]['name'] = $row['name'];
            $productsList[$i]['code'] = $row['code'];
            $productsList[$i]['price'] = $row['price'];
            $productsList[$i]['is_new'] = $row['is_new'];
            $productsList[$i]['author'] = $row['author'];
            $productsList[$i]['publishing_house'] = $row['publishing_house'];
            $productsList[$i]['page_number'] = $row['page_number'];
            $productsList[$i]['year'] = $row['year'];
            $i++;
        }
        return $productsList;
    }

    public static function deleteProductById($id){
        $db = Db::getConnection();
        $sql = 'DELETE FROM product WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }

    public static function createProduct($options){
        $db = Db::getConnection();


        $sql = "INSERT INTO product (name, code, price, category_id, description, author, publishing_house, page_number, year, availability, is_new, is_recommended, status)
                    VALUES (:name, :code, :price, :category_id, :description, :author, :publishing_house, :page_number, :year, :availability, :is_new, :is_recommended, :status)";

        $result = $db->prepare($sql);
        $result->bindParam(':name', $options['name'], PDO::PARAM_STR);
        $result->bindParam(':code', $options['code'], PDO::PARAM_INT);
        $result->bindParam(':price', $options['price'], PDO::PARAM_STR);
        $result->bindParam(':category_id', $options['category_id'], PDO::PARAM_INT);
        $result->bindParam(':description', $options['description'], PDO::PARAM_STR);
        $result->bindParam(':author', $options['author'], PDO::PARAM_STR);
        $result->bindParam(':publishing_house', $options['publishing_house'], PDO::PARAM_STR);
        $result->bindParam(':page_number', $options['page_number'], PDO::PARAM_INT);
        $result->bindParam(':year', $options['year'], PDO::PARAM_INT);
        $result->bindParam(':availability', $options['availability'], PDO::PARAM_INT);
        $result->bindParam(':is_new', $options['is_new'], PDO::PARAM_INT);
        $result->bindParam(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
        $result->bindParam(':status', $options['status'], PDO::PARAM_INT);


        if($result->execute()){
            return $db->lastInsertId();
        }
        return 0;
    }

    public static function updateProduct($id, $options){
        $db = Db::getConnection();

        $sql = "UPDATE product SET name =  :name, code = :code, price = :price, category_id = :category_id, 
                    description = :description, author = :author, publishing_house = :publishing_house, page_number = :page_number, year = :year, availability = :availability, is_new = :is_new, 
                    is_recommended = :is_recommended, status = :status WHERE id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':name', $options['name'], PDO::PARAM_STR);
        $result->bindParam(':code', $options['code'], PDO::PARAM_INT);
        $result->bindParam(':price', $options['price'], PDO::PARAM_STR);
        $result->bindParam(':category_id', $options['category_id'], PDO::PARAM_INT);
        $result->bindParam(':description', $options['description'], PDO::PARAM_STR);
        $result->bindParam(':author', $options['author'], PDO::PARAM_STR);
        $result->bindParam(':publishing_house', $options['publishing_house'], PDO::PARAM_STR);
        $result->bindParam(':page_number', $options['page_number'], PDO::PARAM_INT);
        $result->bindParam(':year', $options['year'], PDO::PARAM_INT);
        $result->bindParam(':availability', $options['availability'], PDO::PARAM_INT);
        $result->bindParam(':is_new', $options['is_new'], PDO::PARAM_INT);
        $result->bindParam(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
        $result->bindParam(':status', $options['status'], PDO::PARAM_INT);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        return $result->execute();
    }

    public static function getImage($id)
    {
        $noImage = 'no-image.jpg';
        $path = '/upload/images/products/';
        $pathToProductImage = $path . $id . '.jpg';
        if (file_exists($_SERVER['DOCUMENT_ROOT'].$pathToProductImage)) {
            return $pathToProductImage;
        }
        return $path . $noImage;
    }

    public static function getAvailabilityText($availability)
    {
        switch ($availability) {
            case '1':
                return 'В наличии';
                break;
            case '0':
                return 'Под заказ';
                break;
        }
    }

    public static function search($query){
        $db = Db::getConnection();
        $products = array();

        $result = $db->prepare('SELECT * FROM product WHERE name LIKE ? OR author LIKE ? OR publishing_house LIKE ?');
        $result->execute(array("%$query%", "%$query%", "%$query%"));

        $i = 0;
        while($row = $result->fetch()){
            $products[$i]['id'] = $row['id'];
            $products[$i]['name'] = $row['name'];
            $products[$i]['code'] = $row['code'];
            $products[$i]['price'] = $row['price'];
            $products[$i]['is_new'] = $row['is_new'];
            $products[$i]['author'] = $row['author'];
            $products[$i]['publishing_house'] = $row['publishing_house'];
            $products[$i]['page_number'] = $row['page_number'];
            $products[$i]['year'] = $row['year'];
            $i++;
        }
        return $products;
    }
}