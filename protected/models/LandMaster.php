<?php

/**
 * This is the model class for table "LandMaster".
 *
 * The followings are the available columns in table 'LandMaster':
 * @property string $LandID
 * @property string $LocationID
 * @property string $Plot_No
 * @property int	$Piece
 * @property string $location
 * @property string $Land_Type
 * @property double $TotalArea
 * @property double $length
 * @property double $width
 * @property string $AreaUnit
 * @property string $Remarks
 * @property string $North
 * @property string $South
 * @property string $East
 * @property string $West
 */
class LandMaster extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LandMaster the static model class
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
		return 'LandMaster';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('LandID', 'required'),
			array('TotalArea, length, width', 'numerical'),
			array('LandID, location, Land_Type', 'length', 'max'=>200),
			array('LocationID', 'length', 'max'=>10),
			array('Plot_No, AreaUnit', 'length', 'max'=>50),
			array('Remarks', 'length', 'max'=>300),
			array('North, South, East, West', 'length', 'max'=>250),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('LandID, LocationID, Plot_No, Piece, location, Land_Type, TotalArea, length, width, AreaUnit, Remarks, North, South, East, West', 'safe', 'on'=>'search'),
			array('LandID, LocationID, Plot_No, Piece, location, Land_Type, TotalArea, length, width, AreaUnit, Remarks, North, South, East, West', 'safe'),
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
			'contractsMasters' => array(self::HAS_MANY, 'ContractsMaster', 'LandID'),
			'deedMasters' => array(self::HAS_MANY, 'DeedMaster', 'LandID'),
			'deedTrackers' => array(self::HAS_MANY, 'DeedTracker', 'LandID'),
			'hajzMasters' => array(self::HAS_MANY, 'HajzMaster', 'LandID'),
			'landDetails' => array(self::HAS_MANY, 'LandDetails', 'LandID'),
			'landFines' => array(self::HAS_MANY, 'LandFines', 'LandID'),
			'landSchemes' => array(self::HAS_MANY, 'LandScheme', 'LandID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'LandID' => 'رقم الارض',
			'LocationID' => 'رمز المنتقة',
			'Plot_No' => 'الحوظ',
			'Piece' => 'القطعة',
			'location' => 'المنتقة',
			'Land_Type' => 'نوع الارض',
			'TotalArea' => 'المساحة',
			'length' => 'الطول',
			'width' => 'العرض',
			'AreaUnit' => 'وحدة المساحة',
			'Remarks' => 'الملاحظات',
			'North' => 'شمالا',
			'South' => 'جنوبا',
			'East' => 'شرقا',
			'West' => 'غربا',
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

		$criteria->compare('LandID',$this->LandID,true);
		$criteria->compare('LocationID',$this->LocationID,true);
		$criteria->compare('Plot_No',$this->Plot_No,true);
		$criteria->compare('Piece',$this->Piece,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('Land_Type',$this->Land_Type,true);
		$criteria->compare('TotalArea',$this->TotalArea);
		$criteria->compare('length',$this->length);
		$criteria->compare('width',$this->width);
		$criteria->compare('AreaUnit',$this->AreaUnit,true);
		$criteria->compare('Remarks',$this->Remarks,true);
		$criteria->compare('North',$this->North,true);
		$criteria->compare('South',$this->South,true);
		$criteria->compare('East',$this->East,true);
		$criteria->compare('West',$this->West,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
