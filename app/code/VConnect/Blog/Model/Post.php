<?php
declare(strict_types=1);

namespace VConnect\Blog\Model;

use Magento\Framework\Model\AbstractModel;
use VConnect\Blog\Api\Data\PostInterface;
use VConnect\Blog\Model\ResourceModel\Post as ResourceModel;

class Post extends AbstractModel implements PostInterface
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * Set ID
     *
     * @param string $id
     * @return PostInterface
     */
    public function setPostId(string $id): PostInterface
    {
        return $this->setData(self::POST_ID, $id);
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
     * @return string|int
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
     * @return PostInterface
     */
    public function setTitle(string $title): PostInterface
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Set content
     *
     * @param string $content
     * @return PostInterface
     */
    public function setContent(string $content): PostInterface
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * Set announce
     *
     * @param string $announce
     * @return PostInterface
     */
    public function setAnnounce(string $announce): PostInterface
    {
        return $this->setData(self::ANNOUNCE, $announce);
    }

    /**
     * Set publish date
     *
     * @param string $publishDate
     * @return PostInterface
     */
    public function setPublishDate(string $publishDate): PostInterface
    {
        return $this->setData(self::PUBLISH_DATE, $publishDate);
    }

    /**
     * Set post status
     *
     * @param bool $isPublished
     * @return PostInterface
     */
    public function setPostStatus(bool $isPublished): PostInterface
    {
        return $this->setData(self::IS_PUBLISHED, $isPublished);
    }

    /**
     * Set created time
     *
     * @param string $createdTime
     * @return PostInterface
     */
    public function setCreatedTime(string $createdTime): PostInterface
    {
        return $this->setData(self::CREATED_AT, $createdTime);
    }

    /**
     * Set updated time
     *
     * @param string $updatedTime
     * @return PostInterface
     */
    public function setUpdatedTime(string $updatedTime): PostInterface
    {
        return $this->setData(self::UPDATED_AT, $updatedTime);
    }
}
