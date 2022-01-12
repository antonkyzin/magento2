<?php
declare(strict_types=1);

namespace VConnect\Blog\Model;

use VConnect\Blog\Api\Data\PostSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

/**
 * Service Data Object with Block search results.
 */
class PostSearchResults extends SearchResults implements PostSearchResultsInterface
{
}
