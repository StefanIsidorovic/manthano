<?php
    /**
     * Created by Notepad+.
     * User: Gera
     * Date: 12/22/13
     * Time: 4:23 PM
     */

    class Material {
        private $Name;
        private $URI;
        private $Type;
        private $Date;
        private $OwnerID;
        private $db;
        private $idMaterial;
        private $exist;

        public function __construct($idMaterial){
            $where['idMaterial']=$idMaterial;
            $CI=&get_instance();
            $results=$CI->crud_model->db_get_Material($where); //function returns matrix
            if($results){
                $result=$results[0];
                $this->exist = 1;
                $this->idMaterial = $idMaterial;
                $this->Name = $result['Name'];
                $this->URI = $result['URI'];
                $this->Type = $result['Type'];
                $this->Date = $result['Date'];
                $this->OwnerID = $result['OwnerID'];
            }
            else
                $this->exist = 0;

        }

        public function __destruct(){

            $this->idMaterial = null;
            $this->Name = null;
            $this->URI = null;
            $this->Type = null;
            $this->Date = null;
            $this->OwnerID =null;
            $this->db = null;
        }


        public function exists(){
            return $this->exist;
        }

        /* get and set functions*/

        public function Name(){ return $this->Name;}
        public function URI(){ return $this->URI;}
        public function Type(){ return $this->Type;}
        public function Date(){ return $this->Date;}
        public function OwnerID(){ return $this->OwnerID;}
        public function idMaterial(){ return $this->idMaterial;}

        public function setName($value){ $this->Name = $value;}
        public function setURI($value){ $this->URI = $value;}
        public function setType($value){ $this->Type = $value;}
        public function setDate($value){ $this->Date = $value;}
        public function setOwnerID($value){ $this->OwnerID = $value;}
        //public function setID($value){ $this->ID = $value;}

        /* error handling for Accessing the wrong way to private properties of object*/
        public function __set($name, $value){
            echo "You are trying to direct set property ".$name." to value ".$value." and that is not possible use set".$name."(\$value) method.";
            echo "<br/> At line ".__LINE__." in file ".__FILE__;
        }
        public function __get($name){
            echo "You are trying to direct access property ".$name."and that is not possible. Use ".$name."() method";
            echo "<br/> At line ".__LINE__." in file ".__FILE__;
        }
       

       
        /* Finding Materials by id and return all relevant informations.
         * Return value is array if Materials exist, otherwise returns String.
         * Array has Name, URI, Type, Date, OwnerID, Active
         */
        public function getFullInfo(){

            $where['idMaterial']=$this->idMaterial;
            $result=$this->crud_model->db_get_Material($where);

            if(!$result){
                return "There is no any Material! ";
            }else{
                return $result;
            }
        }
        static public function addMaterial($db, $id, $name,$URI, $type,$date,$owner)
        {
            //$stmt = $db->prepare("call addMaterial(:id, :name,:URI,:type,:date,: owner);");
            $stmt = $db->prepare("call addMaterial(:id, :name,:URI,:type,:date,: owner);");
            //$stmt->bindParam(":idMaterial", $id, PDO::PARAM_INT);
            $stmt->bindParam(":Name", $name, PDO::PARAM_STR);
            $stmt->bindParam(":URI", $URI, PDO::PARAM_STR);
            $stmt->bindParam(":Type", $type, PDO::PARAM_STR);
            $stmt->bindParam(":Date", $date, PDO::PARAM_STR);
            $stmt->bindParam(":OwnerID", $owner, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount() ? true : false;
        }
/*
        static public function addMaterial($Name,$URI,$Type,$Date,$OwnerId){
            $CI=&get_instance();
            $db_data['Name']=$Name;
            $db_data['URI']=$URI;
            $db_data['Type']=$Type;
            $db_data['Date']=$Date;
            $db_data['OwnerId']=$OwnerId;
            // upotrebiti proceduru ovde
            return $CI->crud_model->db_insert_material($db_data);
        }*/

        public function getOwner($idMaterial){
//select user->fname + user->surname as[ Owner Name ] from material join user on material.ownerID=user.userID where material->id=$this->id;
            $where['idMaterial']=$this->idMaterial;
            $CI=&get_instance();
            $materials=$CI->crud_model->db_get_user_material($where);
            //$result=$this->crud_model->db_get_user_material($where);

            if(!$materials){
                return "Owner is deleted by Administrator! ";
            }else{
                return $materials[0]['Name'].$materials[0]['Surname'];
            }
        }

        /* Updates Material.
         * Update few attributes of one or more record from Material table;
         * Return true if successful or false if not.
         * */
        public function update(){
            //var_dump($this);
            $CI=&get_instance();
            $db_data['Name']=$this->Name;
            $db_data['URI']=$this->URI;
            $db_data['Type']=$this->Type;
            $db_data['Date']=$this->Date;
            $where['idMaterial']=$this->idMaterial;;
            return $CI->crud_model->db_update_Material($where,$db_data);

            /*$query = "UPDATE Material SET Name = :name, URI = :URI,Type=:Type, Date = :date, OwnerId=:OwnerID WHERE idMaterial = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":name", $this->Name, PDO::PARAM_STR);
            $stmt->bindParam(":URI", $this->URI, PDO::PARAM_STR);
            $stmt->bindParam(":Type", $this->Type, PDO::PARAM_STR);
            $stmt->bindParam(":date", $this->Date, PDO::PARAM_STR);
            $stmt->bindParam(":OwnerID", $this->OwnerID, PDO::PARAM_STR);
            $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->rowCount() ? true : false;*/
        }


        /* Static methods */

        /* Delete Material
         * No return value;
         */



        static public function deleteMaterial($idMaterial, $db){
            /* upotrebiti proceduru ovde  */
            $stmt = $db->prepare("call deleteMaterial(:idMaterial)");
            $stmt->bindParam(":idMaterial", $idMaterial, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount() ? true : false;
        }
    }