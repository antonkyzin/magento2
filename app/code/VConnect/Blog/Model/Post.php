<?php

namespace VConnect\Blog\Model;

use Magento\Framework\Model\AbstractModel;
use VConnect\Blog\Api\Data\PostInterface;

class Post extends AbstractModel implements PostInterface
{
    protected function _construct()
    {
        $this->_init('VConnect\Blog\Model\ResourceModel\Post');
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return PostInterface
     */
    public function setId($id)
    {
        return $this->setData(self::POST_ID, $id);
    }


    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * Get announce
     *
     * @return string
     */
    public function getAnnounce()
    {
        return $this->getData(self::ANNOUNCE);
    }

    /**
     * Get publish date
     *
     * @return string
     */
    public function getPublishDate()
    {
        return $this->getData(self::PUBLISH_DATE);
    }

    /**
     * Get post status
     *
     * @return bool|int
     */
    public function getPostStatus()
    {
        return $this->getData(self::IS_PUBLISHED);
    }

    /**
     * Get created time
     *
     * @return string
     */
    public function getCreatedTime()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Get updated time
     *
     * @return string
     */
    public function getUpdatedTime()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * Set title
     *
     * @param string $title
     * @return PostInterface
     */
    public function setTitle($title)
    {
       return $this->setData(self::TITLE, $title);
    }

    /**
     * Set content
     *
     * @param string $content
     * @return PostInterface
     */
    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * Set announce
     *
     * @param string $announce
     * @return PostInterface
     */
    public function setAnnounce($announce)
    {
        return $this->setData(self::ANNOUNCE, $announce);
    }

    /**
     * Set publish date
     *
     * @param string $publishDate
     * @return PostInterface
     */
    public function setPublishDate($publishDate)
    {
        return $this->setData(self::PUBLISH_DATE, $publishDate);
    }

    /**
     * Set post status
     *
     * @param bool $isPublished
     * @return PostInterface
     */
    public function setPostStatus($isPublished)
    {
        return $this->setData(self::IS_PUBLISHED, $isPublished);
    }

    /**
     * Set created time
     *
     * @param string $createdTime
     * @return PostInterface
     */
    public function setCreatedTime($createdTime)
    {
        return $this->setData(self::CREATED_AT, $createdTime);
    }

    /**
     * Set updated time
     *
     * @param string $updatedTime
     * @return PostInterface
     */
    public function setUpdatedTime($updatedTime)
    {
        return $this->setData(self::UPDATED_AT, $updatedTime);
    }
}
