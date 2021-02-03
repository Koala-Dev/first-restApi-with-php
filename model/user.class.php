<?php

    class User 
    {
        public function get($id)
        {
            require_once 'controller/connection.controller.php';
            try {
                $stmt = $conn->prepare("SELECT * FROM `apirest_test`.`user` WHERE `userId` = :ui ");
                $stmt->bindParam(":ui", $id);
                $stmt->execute();
                $user = $stmt->fetchAll(PDO:: FETCH_ASSOC);
                return $user;
            } catch (PDOException $e) {
                return 'problema';
            }
        }
        public function login()
        {
            require_once 'controller/connection.controller.php';
            try {
                $dados = json_decode(file_get_contents("php://input"), true);
                // $dados_FirstName = addslashes($dados['FirstName']);
                // $dados_LastName = addslashes($dados['LastName']);
                $dados_email = addslashes($dados['email']);
                $dados_password = md5($dados['password']);

                $stmt = $conn->prepare("SELECT `email`, `password`, `FirstName`,`LastName`, `userId`  FROM `apirest_test`.`user` WHERE `email` = :ui ");
                $stmt->bindParam(":ui",  $dados_email);
                $stmt->execute();
                $user = $stmt->fetchAll(PDO:: FETCH_ASSOC);
                    if(empty($user)){
                        $status = array('emailExists' => false);
                        return $status;
                    } else {
                        if($dados_password===$user[0]['password']){
                            $status = array(
                                'emailExists' => true, 
                                'emailConfirm' => true, 
                                'passwordConfirm' =>true, 
                                'details' => array(
                                    'email' => $user[0]['email'],
                                    'FirstName' => $user[0]['FirstName'],
                                    'LastName' => $user[0]['LastName'],
                                    'userId' => $user[0]['userId'],
                                    )
                                );
                            return $status;
                        } else {
                            $status = array('emailExists' => true, 'emailConfirm' => true, 'passwordConfirm' =>false);
                            return $status;
                        }
                    }

            } catch (PDOException $e) {
                return 'problema';
            }
        }
        public function create(){
            require_once 'controller/connection.controller.php';
            try {
                $dados = json_decode(file_get_contents("php://input"), true);
                $dados_FirstName = addslashes($dados['FirstName']);
                $dados_LastName = addslashes($dados['LastName']);
                $dados_email = addslashes($dados['email']);
                $dados_password = md5($dados['password']);

                $stmt = $conn->prepare("SELECT `email`, `password` FROM `apirest_test`.`user` WHERE `email` = :ui ");
                $stmt->bindParam(":ui",  $dados_email);
                $stmt->execute();
                $user = $stmt->fetchAll(PDO:: FETCH_ASSOC);
                
                if(empty($user)){
                    $stmt2 = $conn->prepare("INSERT INTO `apirest_test`.`user` (`FirstName`, `LastName`, `email`, `password`) VALUES (:fn, :ln, :m, :pw )");
                    $stmt2->bindParam(":fn", $dados_FirstName);
                    $stmt2->bindParam(":ln", $dados_LastName);
                    $stmt2->bindParam(":m", $dados_email);
                    $stmt2->bindParam(":pw", $dados_password);
                    $stmt2->execute();

                    $stmt3 = $conn->prepare("SELECT `email`, `FirstName`,`LastName` FROM `apirest_test`.`user` WHERE `email` = :ui ");
                    $stmt3->bindParam(":ui",  $dados_email);
                    $stmt3->execute();
                    $userCreated = $stmt3->fetchAll(PDO:: FETCH_ASSOC);
                    if(empty($userCreated)){
                        $status = array('createUser' => 'email não criado' );
                        return $status;
                    } else {
                        $status = array(
                            'createUser' => 'email  criado', 
                            'Email' =>  $userCreated[0]["email"], 
                            'FirstName' => $userCreated[0]["FirstName"],
                            'LastName' => $userCreated[0]["LastName"]
                        );
                        return $status;
                    }
                } else {
                    $status = array('emailExists' => true );
                    return $status;
                }

                // return 'ok';
            } catch (PDOException $e) {
                return 'problema';
            }


        }
        public function update(){}
        public function delete(){}
    }