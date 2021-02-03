<?php

    class Groups 
    {
        public function get($id) {
            require_once 'controller/connection.controller.php';

            // $data = json_decode(file_get_contents('php://input'), true);
            // $data_fk_userId = addslashes($data['fk_userId']);

            $stmt = $conn->prepare("SELECT * FROM list_group WHERE `fk_userId` = :fkusr");
            $stmt->bindParam(":fkusr", $id);
            $stmt->execute();
            $list_group = $stmt-> fetchAll(PDO:: FETCH_ASSOC);
            return $list_group;
            
        }
        public function getOne() {
            require_once 'controller/connection.controller.php';

            $data = json_decode(file_get_contents('php://input'), true);
            $data_fk_userId = addslashes($data['fk_userId']); 
            $data_GroupId = addslashes($data['GroupId']); 

            $stmt = $conn->prepare("SELECT * FROM list_group WHERE GroupId = :gid AND `fk_userId` = :fkusr");
            $stmt->bindParam(":gid", $data_GroupId);
            $stmt->bindParam(":fkusr", $data_fk_userId);
            $stmt->execute();
            $list_group = $stmt-> fetchAll(PDO:: FETCH_ASSOC);
            return $list_group;
        }

        public function update() {
            require_once 'controller/connection.controller.php';

            $data = json_decode(file_get_contents('php://input'), true);
            $data_fk_userId = addslashes($data['fk_userId']); 
            $data_GroupId = addslashes($data['GroupId']);
            $data_GroupTitle = addslashes($data['GroupTitle']);

            $stmt = $conn->prepare("UPDATE list_group SET GroupTitle =  :ti WHERE GroupId = :i AND `fk_userId` = :fkusr ");
            $stmt->bindParam("ti", $data_GroupTitle);
            $stmt->bindParam("i", $data_GroupId);
            $stmt->bindParam("fkusr", $data_fk_userId);
            $stmt->execute();

            $stmt2 = $conn->prepare("SELECT * FROM list_group WHERE GroupId = :i AND `fk_userId` = :fkusr ");
            $stmt2->bindParam("i", $data_GroupId);
            $stmt2->bindParam("fkusr", $data_fk_userId);
            $stmt2->execute();
            $list_group = $stmt2-> fetchAll(PDO:: FETCH_ASSOC);

            return $list_group;
        }

        public function create() {
            require_once 'controller/connection.controller.php';

            $data = json_decode(file_get_contents('php://input'), true);

            $strg_grouptitle = strval($data['GroupTitle']);
            $strg_fk_userId = strval($data['fk_userId']);
            $stmt = $conn->prepare("INSERT `list_group` (`GroupTitle`, `fk_userId`) VALUES (:ti, :fkui)");
            $stmt->bindParam("ti", $strg_grouptitle);
            $stmt->bindParam("fkui", $strg_fk_userId);
            $stmt->execute();

            

            $stmt2 = $conn->prepare("SELECT * FROM list_group ");
            $stmt2->execute();
            $list_group = $stmt2-> fetchAll(PDO:: FETCH_ASSOC);


            return $list_group;
        }

        public function delete($id) {
            require_once 'controller/connection.controller.php';

            $stmt = $conn->prepare("DELETE FROM list_group  WHERE GroupId = :i");
            $stmt->bindParam("i", $id);
            $stmt->execute();

            $stmt2 = $conn->prepare("SELECT * FROM list_group ");
            $stmt2->execute();
            $list_group = $stmt2-> fetchAll(PDO:: FETCH_ASSOC);

            return $list_group;
        }
    }