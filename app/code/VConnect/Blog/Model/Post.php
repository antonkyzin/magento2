<?php
declare(strict_types=1);

namespace VConnect\Blog\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use VConnect\Blog\Api\Data\PostInterface;
use VConnect\Blog\Model\ResourceModel\Post as ResourceModel;

class Post extends AbstractModel implements PostInterface, IdentityInterface
{
    /**
     * Post cache tag
     */
    public const CACHE_TAG = 'vct_p';

    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * Set ID
     *
     * @param string $id
     * @return void
     */
    public function setPostId(string $id): void
    {
        $this->setData(self::POST_ID, $id);
    }

    /**
     * Get ID
     *
     * @return string|null
     */
    public function getPostId(): ?string
    {
        return $this->getData(self::POST_ID);
    }

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Get content
     *
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * Get announce
     *
     * @return string|null
     */
    public function getAnnounce(): ?string
    {
        return $this->getData(self::ANNOUNCE);
    }

    /**
     * Get publish date
     *
     * @return string|null
     */
    public function getPublishDate(): ?string
    {
        return $this->getData(self::PUBLISH_DATE);
    }

    /**
     * Get post status
     *
     * @return string|null
     */
    public function getPostStatus(): ?string
    {
        return $this->getData(self::IS_PUBLISHED);
    }

    /**
     * Get created time
     *
     * @return string|null
     */
    public function getCreatedTime(): ?string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Get updated time
     *
     * @return string|null
     */
    public function getUpdatedTime(): ?string
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * Set title
     *
     * @param string $title
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->setData(self::TITLE, $title);
    }

    /**
     * Set content
     *
     * @param string $content
     * @return void
     */
    public function setContent(string $content): void
    {
        $this->setData(self::CONTENT, $content);
    }

    /**
     * Set announce
     *
     * @param string $announce
     * @return void
     */
    public function setAnnounce(string $announce): void
    {
        $this->setData(self::ANNOUNCE, $announce);
    }

    /**
     * Set publish date
     *
     * @param string $publishDate
     * @return void
     */
    public function setPublishDate(string $publishDate): void
    {
       $this->setData(self::PUBLISH_DATE, $publishDate);
    }

    /**
     * Set post status
     *
     * @param string $isPublished
     * @return void
     */
    public function setPostStatus(string $isPublished): void
    {
        $this->setData(self::IS_PUBLISHED, $isPublished);
    }

    /**
     * Set created time
     *
     * @param string $createdTime
     * @return void
     */
    public function setCreatedTime(string $createdTime): void
    {
        $this->setData(self::CREATED_AT, $createdTime);
    }

    /**
     * Set updated time
     *
     * @param string $updatedTime
     * @return void
     */
    public function setUpdatedTime(string $updatedTime): void
    {
        $this->setData(self::UPDATED_AT, $updatedTime);
    }

    /**
     * Return unique ID(s) for each post
     *
     * @return array
     */
    public function getIdentities(): array
    {
        return [self::CACHE_TAG . '_' . $this->getPostId()];
    }

    /**
     * Get url key
     *
     * @return string|null
     */
    public function getUrlKey(): ?string
    {
        return $this->getData(self::URL_KEY);
    }

    /**
     * Set url key
     *
     * @param string $urlKey
     * @return void
     */
    public function setUrlKey(string $urlKey): void
    {
        $this->setData(self::URL_KEY, $urlKey);
    }
}
