<?php
declare(strict_types=1);
namespace Flyxrg\ValidateZipcode\Model;

use Flyxrg\ValidateZipcode\Api\ZipcodeRepositoryInterface;
use Flyxrg\ValidateZipcode\Api\Data\ZipcodeInterface;
use Flyxrg\ValidateZipcode\Api\Data\ZipcodeSearchResultsInterface;
use Flyxrg\ValidateZipcode\Api\Data\ZipcodeSearchResultsInterfaceFactory;
use Flyxrg\ValidateZipcode\Model\ResourceModel\Zipcode as ZipcodeResource;
use Flyxrg\ValidateZipcode\Model\ResourceModel\Zipcode\CollectionFactory as ZipcodeCollectionFactory;
use Flyxrg\ValidateZipcode\Model\ResourceModel\Zipcode\Collection as ZipcodeCollection;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class ZipcodeRepository
 */
class ZipcodeRepository implements ZipcodeRepositoryInterface
{
    /**
     * @var ZipcodeFactory
     */
    protected $zipcodeFactory;

    /**
     * @var ZipcodeResource
     */
    protected $zipcodeResource;

    /**
     * @var ZipcodeCollectionFactory
     */
    protected $zipcodeCollectionFactory;

    /**
     * @var ZipcodeSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * ZipcodeRepository constructor.
     * @param ZipcodeFactory $zipcodeFactory
     * @param ZipcodeResource $zipcodeResource
     * @param ZipcodeCollectionFactory $zipcodeCollectionFactory
     * @param ZipcodeSearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        ZipcodeFactory $zipcodeFactory,
        ZipcodeResource $zipcodeResource,
        ZipcodeCollectionFactory $zipcodeCollectionFactory,
        ZipcodeSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->zipcodeFactory = $zipcodeFactory;
        $this->zipcodeResource = $zipcodeResource;
        $this->zipcodeCollectionFactory = $zipcodeCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * save
     *
     * @param ZipcodeInterface $zipcode
     * @return ZipcodeInterface
     * @throws CouldNotSaveException
     */
    public function save(ZipcodeInterface $zipcode)
    {
        try {
            $this->zipcodeResource->save($zipcode);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $zipcode;
    }

    /**
     * getById
     *
     * @param int $zipcodeId
     * @return ZipcodeInterface
     * @throws NoSuchEntityException
     */
    public function getById($zipcodeId)
    {
        $zipcode = $this->zipcodeFactory->create();
        $this->zipcodeResource->load($zipcode, $zipcodeId);
        if (!$zipcode->getId()) {
            throw new NoSuchEntityException(__('News Zipcode with id "%1" does not exist.', $zipcodeId));
        }
        return $zipcode;
    }

    /**
     * delete
     *
     * @param \Flyxrg\ValidateZipcode\Api\Data\ZipcodeInterface $zipcode
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(ZipcodeInterface $zipcode)
    {
        try {
            $this->zipcodeResource->delete($zipcode);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * deleteById
     *
     * @param string $zipcodeId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($zipcodeId)
    {
        return $this->delete($this->getById($zipcodeId));
    }

    /**
     * getList
     * @param SearchCriteriaInterface $searchCriteria
     * @return ZipcodeSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->zipcodeCollectionFactory->create();

        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->load();
        return $this->buildSearchResult($searchCriteria, $collection);
    }

    /**
     * addFiltersToCollection
     * @param SearchCriteriaInterface $searchCriteria
     * @param ZipcodeCollection $collection
     */
    protected function addFiltersToCollection(SearchCriteriaInterface $searchCriteria, ZipcodeCollection $collection)
    {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    /**
     * addSortOrdersToCollection
     * @param SearchCriteriaInterface $searchCriteria
     * @param ZipcodeCollection $collection
     */
    protected function addSortOrdersToCollection(
        SearchCriteriaInterface $searchCriteria,
        ZipcodeCollection $collection
    ) {
        foreach ((array) $searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    /**
     * addPagingToCollection
     * @param SearchCriteriaInterface $searchCriteria
     * @param ZipcodeCollection $collection
     */
    protected function addPagingToCollection(SearchCriteriaInterface $searchCriteria, ZipcodeCollection $collection)
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

    /**
     * buildSearchResult
     * @param SearchCriteriaInterface $searchCriteria
     * @param ZipcodeCollection $collection
     * @return ZipcodeSearchResultsInterface
     */
    protected function buildSearchResult(SearchCriteriaInterface $searchCriteria, ZipcodeCollection $collection)
    {
        $searchResults = $this->searchResultsFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
