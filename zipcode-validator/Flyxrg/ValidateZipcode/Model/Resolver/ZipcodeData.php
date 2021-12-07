<?php
declare(strict_types=1);
namespace Flyxrg\ValidateZipcode\Model\Resolver;
 
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
 
class ZipcodeData implements ResolverInterface
{
	/**
     * @var ZipcodeFactory
     */
    protected $zipcodeFactory;
	
	/**
     * @param ZipcodeFactory $zipcodeFactory
     */
	public function __construct(
        \Flyxrg\ValidateZipcode\Model\ZipcodeFactory $zipcodeFactory
    ) {
        $this->zipcodeFactory = $zipcodeFactory;
    }
	
	/**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $zipcodeId = $this->getZipcodeId($args);
        $zipcodeData = $this->getZipcodeData($zipcodeId);
 
        return $zipcodeData;
    }
	
	/**
     * @param array $args
     * @return int
     * @throws GraphQlInputException
     */
    private function getZipcodeId(array $args): int
    {
        if (!isset($args['zipcode'])) {
            throw new GraphQlInputException(__('zipcode should be specified'));
        }
		
		$zipcode = $this->zipcodeFactory->create()->load($args['zipcode'],"zipcode");
		$args['id'] = $zipcode->getId();
        return (int)$args['id'];
    }
    /**
     * @param int $zipcode
     * @return array
     * @throws GraphQlNoSuchEntityException
     */
    public function getZipcodeData(int $id): array
    {
        try {
            $zipcode = $this->zipcodeFactory->create();
			$modelData = $zipcode->load($id);
			
            $zipcodeData = [
                'zipcode_id' => $modelData->getZipcodeId(),
                'country_id' => $modelData->getCountryId(),
                'region_id' => $modelData->getRegionId(),
                'city' => $modelData->getCity(),
                'zipcode' => $modelData->getZipcode()
            ];
        } catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
        }
        return $zipcodeData;
    }
}