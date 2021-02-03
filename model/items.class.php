<?php 

    class Items 
    {
        public function get($id) {
            require_once 'controller/connection.controller.php';

            $stmt = $conn->prepare("SELECT * FROM apirest_test.list_items WHERE `GroupId` = :i");
            $stmt->bindParam(":i", $id);
            $stmt->execute();
            $list_items = $stmt->fetchAll(PDO:: FETCH_ASSOC);
            if(empty($list_items)){
                $status = array(
                    'ExistsItems' => false ,
                );
                return $status; } 
            else {
                $status = array(
                    'ExistsItems' => true , 
                    'listItens' => $list_items
                );
                return  $status ;
            }
        }
        public function getone($id) {
            require_once 'controller/connection.controller.php';

            $stmt = $conn->prepare("SELECT * FROM apirest_test.list_items WHERE itemId  = :i");
            $stmt->bindParam(":i", $id);
            $stmt->execute();
            $item = $stmt->fetchAll(PDO:: FETCH_ASSOC);
            return $item;
        }
        public function update($id) {
            require_once 'controller/connection.controller.php'; 

            $dados = json_decode(file_get_contents("php://input"), true);

            $strg_item = strval($dados['Description']);
            $stmt = $conn->prepare("UPDATE apirest_test.list_items SET `Description` =  :d WHERE itemId = :i");
            $stmt->bindParam(":d", $strg_item);
            $stmt->bindParam(":i", $id);
            $stmt->execute();

            $stmt2 = $conn->prepare("SELECT * FROM apirest_test.list_items WHERE itemId  = :i");
            $stmt2->bindParam(":i", $id);
            $stmt2->execute();
            $item_update = $stmt2->fetchAll(PDO:: FETCH_ASSOC);
            return $item_update;

        }
        public function create() {

            require_once 'controller/connection.controller.php'; 

            $dados = json_decode(file_get_contents("php://input"), true);
            
            $Description = strval($dados['Description']);
            $GroupId = strval($dados['GroupId']);
            $stmt = $conn->prepare("INSERT  apirest_test.list_items (`Description`, GroupId) VALUES (:d, :i)");
            $stmt->bindParam(":d",$Description);
            $stmt->bindParam(":i", $GroupId);
            $stmt->execute();

            $stmt2 = $conn->prepare("SELECT * FROM apirest_test.list_items ");
            $stmt2->execute();
            $list_items = $stmt2-> fetchAll(PDO:: FETCH_ASSOC);

            return $list_items;
        }
        public function delete($id) {
            require_once 'controller/connection.controller.php'; 

            $stmt = $conn->prepare("DELETE FROM apirest_test.list_items  WHERE itemId = :i");
            $stmt->bindParam("i", $id);
            $stmt->execute();

            $stmt2 = $conn->prepare("SELECT * FROM apirest_test.list_items ");
            $stmt2->execute();
            $list_items = $stmt2-> fetchAll(PDO:: FETCH_ASSOC);

            return $list_items;
            
        }
    }