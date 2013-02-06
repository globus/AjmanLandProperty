<?php

class DocumentMasterController extends  Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			//'accessControl', // perform access control for CRUD operations
			'rights',
//			'accessControl', // perform access control for CRUD operations
//			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','Search','CustomerSearch'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
        public function allowedActions() { return 'index, uploadify'; }
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionIndex()
	{

                 $criteria = new CDbCriteria;            		
                $items = Letters::model()->findAll($criteria);
            
                $this->render('search', array(
				'docs'=>$items,));
		
	}
        
        public function actionAddOwner() {
                extract($_POST);
            $res=0;
            
           $res = CustomerMaster::model()->findByAttributes(array('CustomerNameArabic'=>$ArabicName));

            
             if( count($res)<1){
                 $customerMaster = new CustomerMaster;
                $customerMaster->CustomerNameArabic = $ArabicName;
                $customerMaster->Nationality = $Nationality;
                $customerMaster->save();
                $customerID = $customerMaster->CustomerID;
             }else{ $customerID = $res->CustomerID;}

              $res = DeedDetails::model()->findByAttributes(array('CustomerID'=>$customerID, 'DeedID'=>$deedID));
                    if( count($res)<1){
                    $deedDtails = new DeedDetails;
                    $deedDtails->CustomerID=$customerID;
                    $deedDtails->DeedID=$deedID;
                    $deedDtails->Share = $Share;
                    if($deedDtails->save()) $res=1;
                    $shareID = $deedDtails->DeedDetailsID;
                }
             
            print CJSON::encode(array("result"=>$res, "customerID"=>$customerID , "shareID"=>$shareID ));
        }
        public function actionAddFile(){
            
           $formData = CJSON::decode(stripslashes($_POST['formData']));
           $fileData = CJSON::decode($formData["fileData"]);
            $res=0;
//            print "count".count(CJSON::decode($formData["fileData"])); 
//            print_r($fileData);
//            print "ddd".$formData["fileData"][0]["fileName"];
            if(count($fileData)>0 and is_array($fileData)){
                    foreach ($fileData as $imageFile) {

                            $file = new FileMaster();
                            $file->Type = "deed";
                             $file->LandID = $formData["landID"];
                             $file->DeedID = $formData["deedID"];
                             $file->DateCreated = date('Y-m-d');
                             $file->Title = $imageFile["fileName"];
                             $file->Image = $imageFile["imageName"];
                                if($file->save()) $res=1;
                                   else  print_r( $file->getErrors() );
                    }    
            
            }else print "Files not found";
           print CJSON::encode($res);
        }
        public function actionAddHajaz() {
                extract($_POST);
            $res=0;
            $HajzMaster = new HajzMaster;
                $HajzMaster->LandID = $_LandID ; 
                $HajzMaster->DeedID = $_DeedID ; 
                $HajzMaster->Remarks = $Remarks ; 
                $HajzMaster->Type = $Type ; 
                $HajzMaster->TypeDetail = $TypeDetail ; 
                $HajzMaster->DateCreated = $DateCreated ; 
                $HajzMaster->AmountMortgaged = $AmountMortgaged ; 

            $HajzMaster->IsActive = $IsActive;
            if($HajzMaster->save()) $res=1;
             
            print CJSON::encode(array("HajzID"=>$HajzMaster->HajzID,"result"=>$res ));
        }
        public function actionDeleteOwner() {
                extract($_POST);
            $res=0;
            $searchCriteria=new CDbCriteria;
            print $query = "delete from `DeedDetails` where `DeedID`='$deedID'  AND  CustomerID = '$customerID'";
            $command =Yii::app()->db->createCommand($query);
            
            if($command->execute()) $res=1;
            
            
            // delete the rows matching the specified condition
//            DeedDetails::model()->deleteAll($condition,$params);
//            // delete the rows matching the specified condition and primary key(s)
//            DeedDetails::model()->deleteByPk($pk,$condition,$params);
            
            print CJSON::encode($res);
        }
        public function actionDeleteFine() {
                extract($_POST);
            $res=0;
            $searchCriteria=new CDbCriteria;
            print $query = "Delete From `HajzMaster` where `HajzID`='$HajzID'";//AND  LandID = '$LandID'
            $command =Yii::app()->db->createCommand($query);
            
            if($command->execute()) $res=1;
            print CJSON::encode($res);
        }
        public function actionDeleteFile() {
                extract($_POST);
            $res=0;
//            $searchCriteria=new CDbCriteria;
            $res = FileMaster::model()->findByAttributes(array('FileID'=>$FileID));
            $pathToFile = Yii::app()->basePath."/../images/uploads/";
            $fileToDelete = $res->Image;
            print "path and file is".$pathToFile.$fileToDelete;
            unlink($pathToFile.$fileToDelete) or die("File not deleted");
            print $query = "Delete From `filemaster` where `FileID`='$FileID'";//AND  LandID = '$LandID'
            $command =Yii::app()->db->createCommand($query);
//            
            if($command->execute()) $res=1;
            print CJSON::encode($res);
        }
        public function actionUpdateImageCaption() {
                extract($_POST);
            $res=0;
            
//            $searchCriteria=new CDbCriteria;
             $fileMaster=  FileMaster::model()->findByPk($id);
             $fileMaster->Title = $caption;
              if($fileMaster->save()) $res=1;
                else print_r( $fileMaster->getErrors() );
            print CJSON::encode($res);
        }
        public function actionUpdateLandOwnerShare() {
            
            $formData = CJSON::decode(stripslashes($_POST['formData']));
             $shareData = CJSON::decode($formData['shareData']);
             print_r($shareData);
            print $_DeedID = $formData['deedID'];
            DeedDetails::model()->deleteAllByAttributes(array("DeedID"=>$formData['deedID']));
            $res=0;

            if(count($shareData)>0 and is_array($shareData)){
                    foreach ($shareData as $shareRow) {
                        $DeedDetails = new DeedDetails;
                        $DeedDetails->CustomerID = $shareRow["CustomerID"] ; 
                        $DeedDetails->DeedID = $_DeedID ; 
                        $DeedDetails->Share = $shareRow["sharePercentage"]    ; 
                                    if($DeedDetails->save()) $res=1;
                                       else  print_r( $DeedDetails->getErrors() );
                    }    
            
            }else print "ShareData not found";
           print CJSON::encode($res);

        }
         public function actionMarkUpdated() {
                extract($_POST);
            $res=0;
            $searchCriteria=new CDbCriteria;
             $deedMaster= DeedMaster::model()->findByPk($DeedID);
              $deedMaster->ArchiveUpdate = True;
             if($deedMaster->save()) $res=1;
            
            print CJSON::encode($res);
        }
        public function actionUpdateLandData() {
            $res = "0";
           extract($_POST);

                $landDetails=LandMaster::model()->findByPk($LandID);
                $landDetails->Plot_No = $Plot_No ; 
                $landDetails->Piece = $Piece ; 
                $landDetails->location = $location ; 
                $landDetails->Land_Type = $Land_Type ; 
                $landDetails->TotalArea = $TotalArea ; 
                $landDetails->length = $length ; 
                $landDetails->width = $width ; 
                $landDetails->Remarks = $Remarks ; 
                $landDetails->North = $North ; 
                $landDetails->South = $South ; 
                $landDetails->East = $East ; 
                $landDetails->West = $West;

                 if($landDetails->save()) $res=1;
            print CJSON::encode($res);
        }
        public function actionCustomerSearch()
	{// for autocomplete will do DB search for Customers and Lands
		
		if (isset($_GET['term'])) { // first search that 
                // if user arabic name 
                // or english name 
                // or miobile number match
                    
                               
                                $keyword = $_GET["term"];

                               $searchCriteria=new CDbCriteria;
//                             $searchCriteria->condition = 'CustomerNameArabic LIKE :searchstring OR CustomerID LIKE :searchstring OR MobilePhone LIKE :searchstring OR Nationality LIKE :searchstring AND CustomerNameArabic <> "" AND CustomerNameArabic IS NOT NULL ';
                             
                               

                               // the new library                                                                                                                    
                               if (isset($_GET['term'])) 
                               if ($keyword != '') {
                                    $keyword = @$keyword;
                                    $keyword = str_replace('\"', '"', $keyword);

                                    $obj = new ArQuery();
                                    $obj->setStrFields('CustomerNameArabic');
                                    $obj->setMode(1);

                                    $strCondition = $obj->getWhereCondition($keyword);
                                } 
                               //die($strCondition);

			$qtxt = 'SELECT CustomerID, Nationality, CustomerNameArabic from CustomerMaster WHERE ('.$strCondition.' OR CustomerNameEnglish LIKE :name OR MobilePhone Like :name) limit 25';
			$command = Yii::app()->db->createCommand($qtxt);
			$command->bindValue(':name','%'.$_GET['term'].'%',PDO::PARAM_STR);
			$res = $command->queryAll();
                           if( count($res)<1){//run if no customer found 
                           //search DB if Land ID matches

                                    $qtxt = 'SELECT LandID lnd from LandMaster WHERE LandID Like :name';
                                    $command = Yii::app()->db->createCommand($qtxt);
                                    $command->bindValue(':name','%'.$_GET['term'].'%',PDO::PARAM_STR);
                                    $res = $command->queryColumn();

                            }
		}
		print CJSON::encode($res);
                
            // die ($strCondition);
	}
         public function actionNationalitySearch()
	{// for autocomplete will do DB search for Customers and Lands
		
		if (isset($_GET['term'])) { // first search that 
                // if user arabic name 
                // or english name 
                // or miobile number match
                    
                               
                                $keyword = $_GET["term"];

                               $searchCriteria=new CDbCriteria;
//                             $searchCriteria->condition = 'CustomerNameArabic LIKE :searchstring OR CustomerID LIKE :searchstring OR MobilePhone LIKE :searchstring OR Nationality LIKE :searchstring AND CustomerNameArabic <> "" AND CustomerNameArabic IS NOT NULL ';
                             
                               

                               // the new library                                                                                                                    
                               if (isset($_GET['term'])) 
                               if ($keyword != '') {
                                    $keyword = @$keyword;
                                    $keyword = str_replace('\"', '"', $keyword);

                                    $obj = new ArQuery();
                                    $obj->setStrFields('CustomerNameArabic');
                                    $obj->setMode(1);

                                    $strCondition = $obj->getWhereCondition($keyword);
                                } 
                               //die($strCondition);

//			$qtxt = 'SELECT CustomerID, Nationality, CustomerNameArabic from CustomerMaster WHERE '.$strCondition.' OR CustomerNameEnglish LIKE :name OR MobilePhone Like :name limit 25';
//			$command = Yii::app()->db->createCommand($qtxt);
//			$command->bindValue(':name','%'.$_GET['term'].'%',PDO::PARAM_STR);
//			$res = $command->queryAll();
//                           if( count($res)<1){//run if no customer found 
                           //search DB if Land ID matches

                                    $qtxt = 'SELECT distinct Nationality nat from CustomerMaster WHERE Nationality Like :name';
                                    $command = Yii::app()->db->createCommand($qtxt);
                                    $command->bindValue(':name','%'.$_GET['term'].'%',PDO::PARAM_STR);
                                    $res = $command->queryColumn();

//                            }
		}
		print CJSON::encode($res);
                
            // die ($strCondition);
	}
	

    
    
	public function actionSearch()
	{   
		if(isset($_POST["action"]) and $_POST["action"]=="search") //check that this action is only called using POST.. not get, not regular.
                {
                     
                               $searchstring=$_POST["string"];
                               $keyword = $_POST["string"];

                               $searchCriteria=new CDbCriteria;
//                             $searchCriteria->condition = 'CustomerNameArabic LIKE :searchstring OR CustomerID LIKE :searchstring OR MobilePhone LIKE :searchstring OR Nationality LIKE :searchstring AND CustomerNameArabic <> "" AND CustomerNameArabic IS NOT NULL ';
                             
                               

                               // the new library                                                                                                                    
                               if (isset($_POST['string'])) 
                               if ($keyword != '') {
                                    $keyword = @$_POST['string'];
                                    $keyword = str_replace('\"', '"', $keyword);

                                    $obj = new ArQuery();
                                    $obj->setStrFields('CustomerNameArabic');
                                    $obj->setMode(1);

                                    $strCondition = $obj->getWhereCondition($keyword);
                                } 
                              
                                
                               $searchCriteria->condition = $strCondition.' OR CustomerID LIKE :searchstring OR MobilePhone LIKE :searchstring OR Nationality LIKE :searchstring AND CustomerNameArabic <> "" AND CustomerNameArabic IS NOT NULL';
                               
                               $searchCriteria->params = array(':searchstring'=> $searchstring);
                               $searchCriteria->order = 'CustomerNameArabic';
                               $searchCriteria->limit = '25';
                               if (CustomerMaster::model()->count($searchCriteria)>0)
                                {
                                       $customerResult = CustomerMaster::model()->findAll($searchCriteria);
                                       print CJSON::encode($customerResult);			
                                }
                               else
                               {// search for lands and its current and previous owners plus all fines 
                                       //land details
                                       $lands = LandMaster::model()->findAllByAttributes(array("LandID"=>$searchstring));
                                       $landDetails["landInfo"] = $lands[0];
                                       $deeds = DeedMaster::model()->findAllByAttributes(array("LandID"=>$searchstring), 'Remarks <> "cancelled"');
                                       $deedDetails = DeedDetails::model()->findAllByAttributes(array("DeedID"=>$deeds[0]->DeedID));
                                       $deedFiles = FileMaster::model()->findAllByAttributes(array("DeedID"=>$deeds[0]->DeedID));
                                       print "deedfiles".print_r($deedFiles);
                                       // current owners
                                       foreach ($deeds as $did){ 
                                         $landDetails["current"]["deed"] = $did->DeedID;
                                         $landDetails["current"]["Remarks"] = $did->Remarks;
                                         $landDetails["current"]["files"] = $deedFiles;
                                        }
                                         if(count($deedDetails)>0){

                                        foreach ($deedDetails as $key=>$cid) {
                                         $_cids[] = $cid->CustomerID;
                                         $_share[$cid->CustomerID] = $cid->Share;
                                         
                                         }
                                       $searchCriteria=new CDbCriteria;
                                       $searchCriteria->addInCondition("customerID", $_cids);
                                       $landDetails["current"]["customers"] = CustomerMaster::model()->findAll($searchCriteria);
                                       $landDetails["current"]["share"] = $_share;

                                         }
                                       //previous owners
                                       $deeds = DeedMaster::model()->findAllByAttributes(array("LandID"=>$searchstring, "Remarks"=>"cancelled"),array('order'=>'DeedID DESC'));

                                        foreach ($deeds as $key=>$did) {
                                         $deedDetails = DeedDetails::model()->findAllByAttributes(array("DeedID"=>$did->DeedID));
                                         $landDetails["previous"]["deed"][$key]["deed"]= $did->DeedID;
                                            if(count($deedDetails)>0){
                                                $_cids= null;
                                                    foreach ($deedDetails as $cid) {
                                                         $_cids[] = $cid->CustomerID;
                                                    }
                                            $searchCriteria=new CDbCriteria;
                                            $searchCriteria->addInCondition("customerID", $_cids);
                                            $landDetails["previous"]["deed"][$key]["customers"] = CustomerMaster::model()->findAll($searchCriteria);
                                            }
                                   }
                                   // fines related to land
                                      $fines = HajzMaster::model()->findAllByAttributes(array("LandID"=>$searchstring, "IsActive"=>"1"));
                                      $landDetails["fines"] = $fines;
                                       print CJSON::encode($landDetails);
                               }
		
		}else{// this will find land of cutomerID provided in $_POST["string"]
                    	if(isset($_POST["action"]) and $_POST["action"]=="propertySearch") //check that this action is only called using POST.. not get, not regular.
                         {  $lands["landDetails"]["current"] ="";
                            $lands["landDetails"]["previous"] ="";
			 $searchstring = json_decode($_POST["string"]); 
//                        will get deed data feom customer ID
				$deedDetails = DeedDetails::model()->findAllByAttributes(array("CustomerID"=>$searchstring));
                                $_dids= null;

                                  foreach ($deedDetails as $key=>$did) {
                                         $_dids[] = $did->DeedID;
                                         
                                   }
//                                   print_r($_dids);
                                   // get lands related to cutomer from the DeedMaster using deed IDs where deed remarks are  cancelled
                                   
                                   //previous lands of customer
                                       $searchCriteria=new CDbCriteria;
                                       $searchCriteria->condition = '`Remarks` = "cancelled"';
                                       $searchCriteria->addInCondition("DeedID", $_dids);
                                       $LandIDs = DeedMaster::model()->findAll($searchCriteria);

                                       IF(COUNT($LandIDs)>0){
                                            foreach ($LandIDs as $key=>$landId) {
                                              $_landids[] = $landId->LandID;

                                              }
//                                              print_r($_landids);
                                            $searchCriteria=new CDbCriteria;
                                            $searchCriteria->addInCondition("LandID", $_landids);
                                               $lands["landDetails"]["previous"]=$LandInfo = LandMaster::model()->findAll($searchCriteria);
//                                               print  $lands["landDetails"]["previous"][0]->LandID;
                                        }
                                     // get lands related to cutomer from the DeedMaster using deed IDs where deed remarks are not cancelled  

                                       $searchCriteria = null;
                                       $searchCriteria=new CDbCriteria;
                                       $searchCriteria->condition = "Remarks <> 'cancelled'";
//                                       $searchCriteria->compare('Remarks', '<>cancelled', true);
                                       
                                       $searchCriteria->addInCondition("DeedID", $_dids);
                                       $LandIDs = DeedMaster::model()->findAll($searchCriteria);
//                                       print "cont ".COUNT($LandIDs);
                         IF(COUNT($LandIDs)>0){$_landids= null;
                                                foreach ($LandIDs as $key=>$landId) {
//                                                    if($landId->Remarks !="cancelled")
                                                  $_landids[] = $landId->LandID;
                                                  }
//                                                  print "lanids";
//                                                  print_r($_landids);

                                                 $searchCriteria=new CDbCriteria;
                                                 $searchCriteria->addInCondition("LandID", $_landids);
                                                 $lands["landDetails"]["current"]=$LandInfo = LandMaster::model()->findAll($searchCriteria);  
                                                 foreach ($_landids as $lKey=>$lId) {
//                                                     print $lId;
                                                       $searchCriteria=new CDbCriteria;
                                                        $searchCriteria->condition = '`LandID`= "'.$lId.'" AND Remarks <> "cancelled"';
                                                        $LandDeedInfo = DeedMaster::model()->findAll($searchCriteria);   
//                                                        print "deedid";
                                                        $LandDeedInfo[0]->DeedID;
//                                                        print_r($LandDeedInfo);  

                                                        $searchCriteria=new CDbCriteria;
                                                        $searchCriteria->condition = '`DeedID`= '.$LandDeedInfo[0]["DeedID"];
                                                        $DeedCustomerInfo = DeedDetails::model()->findAll($searchCriteria); 
                                                        $_cids = null;
                                                        foreach ($DeedCustomerInfo as $key=>$cId) {
                                                             $_cids[] = $cId->CustomerID;
                                                         }
//                                                         print_r($_cids);

                                                       $searchCriteria=new CDbCriteria;
                                                       $searchCriteria->addInCondition("CustomerID", $_cids);
                                                       $lands["currentOwners"][$lKey]=$CustomerInfo = CustomerMaster::model()->findAll($searchCriteria);   
                                                  }
                         }else{
                              $searchstring = $_POST["string"];

                               $searchCriteria=new CDbCriteria;
                               $searchCriteria->condition = 'CustomerNameArabic LIKE :searchstring OR CustomerID LIKE :searchstring OR MobilePhone LIKE :searchstring OR Nationality LIKE :searchstring AND CustomerNameArabic <> "" AND CustomerNameArabic IS NOT NULL ';
                               $searchCriteria->params = array(':searchstring'=> $searchstring);
                               $searchCriteria->order = 'CustomerNameArabic';
                               $searchCriteria->limit = '25';
                               if (CustomerMaster::model()->count($searchCriteria)>0)
                                {
                                       $lands["currentOwners"]=$customerResult = CustomerMaster::model()->findAll($searchCriteria);
                                }
                         }

                                print CJSON::encode($lands);
                       }
                }	
	}
        public function actionuploadify(){
                return array(
            'upload'=>'application.controllers.upload.UploadFileAction',
        );
        }
        public function actionpSearchProperty()
	{// method not in use 
            // this is a test commit// j comiited
		if(isset($_POST["data"])) //check that this action is only called using POST.. not get, not regular.
        {
			$searchstring = json_decode($_POST["data"]); 
			$searchCriteria=new CDbCriteria;
			$searchCriteria->condition = 'CustomerNameArabic LIKE :searchstring OR MobilePhone LIKE :searchstring OR Nationality LIKE :searchstring';
			$searchCriteria->params = array(':searchstring'=> $searchstring);
			$searchCriteria->order = 'CustomerNameArabic';
//                        $searchCriteria->limit = '0,300';
		
			if (CustomerMaster::model()->count($searchCriteria)>0)
	        {
				$customerResult = CustomerMaster::model()->findAll($searchCriteria);
                                $customerPropertyResult = "123";LandMaster::model()->findAllByAttributes(array("LandID"=>$customerResult[0]["CustomerID"]));
                                    $customerResult[0]["customerResultProperty"] = $customerPropertyResult;
			}

			else
			{
				$lands = LandMaster::model()->findAllByAttributes(array("LandID"=>$searchstring));
				$deed = DeedMaster::model()->findAllByAttributes(array("LandID"=>$searchstring));
				print CJSON::encode($lands);
				
			}
		
		}	
		
	}
}
?>
