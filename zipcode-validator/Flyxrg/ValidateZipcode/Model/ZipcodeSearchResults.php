<?php
declare(strict_types=1);
namespace Flyxrg\ValidateZipcode\Model;

use Flyxrg\ValidateZipcode\Api\Data\ZipcodeSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

/**
 * Class ZipcodeSearchResults
 * @package Flyxrg\ValidateZipcode\Model
 */
class ZipcodeSearchResults extends SearchResults implements ZipcodeSearchResultsInterface
{
}
