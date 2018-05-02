<?php
namespace Store;
require_once  '../../vendor/autoload.php';
use Store\Category as Category;
use \PDO;
use Store\interfaces\GetCategories as GetCategories;

class Store implements GetCategories{

    private $db;

    /**
     *Database query to get category data
     *
     * @return array array of objects of category class
     */
    public function getCategories():array {
        $query = $this->db->prepare("SELECT `id`, `categoryName`, `defaultImageFilePath`,`defaultImageAlt` FROM `categories` WHERE `deleted` = 0;");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS, Category::class);
    }

//    public function setPDO(PDO $db){
//        $this->DB = $db;
//    }

    /**
     *Database query to get product data
     *
     * @return array of objects of product class
     */
    public function getProductPage($id):array {
        $query2 = $this->db->prepare("SELECT `products`.`id`, 
        `products`.`productName`, `products`.`productPrice`, `products`.`availableColors`
        ,`products`.`availableSizes`, `products`.`productDescription`,`images`.`imageRef`
          FROM `products` LEFT JOIN `images` ON `products`.`id` = `images`.`productId`
        WHERE `products`.`id`=:idInput;");

        $query2->bindParam(':idInput', $id);
        $query2->execute();
        return $query2->fetchAll(PDO::FETCH_CLASS,  'Store\Product');
    }
}


