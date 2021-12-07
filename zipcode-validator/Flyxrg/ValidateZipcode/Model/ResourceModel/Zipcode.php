<?php
declare(strict_types=1);
namespace Flyxrg\ValidateZipcode\Model\ResourceModel;

use Flyxrg\ValidateZipcode\Model\Zipcode as ZipcodeModel;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

/**
 * Class Zipcode
 * @package Flyxrg\ValidateZipcode\Model\ResourceModel
 */
class Zipcode extends AbstractDb
{
	/**
     * @var request
     */
	protected $request;
	
	/**
     * @var dataHelper
     */
    protected $dataHelper;
	
    /**
     * Zipcode constructor.
     * @param Context $context
     * @param null $connectionName
	 * @param \Flyxrg\ValidateZipcode\Helper\Data $dataHelper
     */
    public function __construct(
        Context $context,
		\Magento\Framework\App\Request\Http $request,
		\Flyxrg\ValidateZipcode\Helper\Data $dataHelper,
        $connectionName = null)
    {
		$this->request = $request;
		$this->dataHelper = $dataHelper;
        parent::__construct($context, $connectionName);
    }

    /**
     * _construct
     */
    public function _construct()
    {
        $this->_init('directory_zipcode', 'zipcode_id');
    }
	
	public function loadByZipcode($zipcode)
	{
		 $select = $this->getConnection()->select()
            ->from(['dz' => "directory_zipcode"])
			->where('zipcode = ?', $zipcode);
		
		$id = $this->getConnection()->fetchOne($select);
		return $id;
	}
	
	/**
     * Set region
     *
     * @param \Flyxrg\ValidateZipcode\Model\Zipcode|AbstractModel $object
     * @return \Flyxrg\ValidateZipcode\Model\Zipcode $object
     */
    protected function _beforeSave(AbstractModel $object)
    {
		$regionId = $this->request->getPost("region_id");
		if(isset($regionId))
		{
			$regionName = $this->dataHelper->getRegionName($regionId);
			
			parent::_beforeSave($object);
			$object->setRegion($regionName);
			return $object;
		}
    }
}
