<?php

/**
 * This is the model class for table "Invoices".
 *
 * The followings are the available columns in table 'Invoices':
 * @property integer $InvoiceNo
 * @property string $InvoiceDateTime
 * @property string $UserID
 * @property string $Product
 * @property integer $TransactionID
 * @property integer $Amount
 * @property integer $CustomerID
 *
 * The followings are the available model relations:
 * @property ContractsMaster[] $contractsMasters
 * @property DeedMaster[] $deedMasters
 * @property User $user
 * @property CustomerMaster $customer
 */
class Invoices extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Invoices the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Invoices';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		//	array('InvoiceDateTime, UserID, Product, TransactionID, Amount, CustomerID', 'required'),
		//	array('TransactionID, Amount, CustomerID', 'numerical', 'integerOnly'=>true),
		//	array('UserID', 'length', 'max'=>64),
		//	array('Product', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('InvoiceNo, InvoiceDateTime, UserID, Product, TransactionID, Amount, CustomerID', 'safe', 'on'=>'search'),
			array('InvoiceNo, InvoiceDateTime, UserID, Product, TransactionID, Amount, CustomerID', 'safe'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'contractsMasters' => array(self::HAS_MANY, 'ContractsMaster', 'InvoiceNo'),
			'deedMasters' => array(self::HAS_MANY, 'DeedMaster', 'InvoiceNo'),
			'user' => array(self::BELONGS_TO, 'User', 'UserID'),
			'customer' => array(self::BELONGS_TO, 'CustomerMaster', 'CustomerID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'InvoiceNo' => 'Invoice No',
			'InvoiceDateTime' => 'Invoice Date Time',
			'UserID' => 'User',
			'Product' => 'Product',
			'TransactionID' => 'Transaction',
			'Amount' => 'Amount',
			'CustomerID' => 'Customer',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('InvoiceNo',$this->InvoiceNo);
		$criteria->compare('InvoiceDateTime',$this->InvoiceDateTime,true);
		$criteria->compare('UserID',$this->UserID,true);
		$criteria->compare('Product',$this->Product,true);
		$criteria->compare('TransactionID',$this->TransactionID);
		$criteria->compare('Amount',$this->Amount);
		$criteria->compare('CustomerID',$this->CustomerID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
