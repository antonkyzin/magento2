<?php

namespace VConnect\Blog\Api\Data;

interface PostInterface
{
    /**
     * Constants for keys of data array
     */
    const POST_ID = 'post_id';
    const TITLE = 'title';
    const CONTENT = 'content';
    const ANNOUNCE = 'announce';
    const PUBLISH_DATE = 'publish_date';
    const IS_PUBLISHED = 'is_published';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle();

    /**
     * Get content
     *
     * @return string|null
     */
    public function getContent();

    /**
     * Get announce
     *
     * @return string|null
     */
    public function getAnnounce();

    /**
     * Get publish date
     *
     * @return string|null
     */
    public function getPublishDate();

    /**
     * Get post status
     *
     * @return bool|null
     */
    public function getPostStatus();

    /**
     * Get created time
     *
     * @return string|null
     */
    public function getCreatedTime();

    /**
     * Get updated time
     *
     * @return string|null
     */
    public function getUpdatedTime();

    /**
     * Set ID
     *
     * @param int $id
     * @return PostInterface
     */
    public function setId($id);

    /**
     * Set title
     *
     * @param string $title
     * @return PostInterface
     */
    public function setTitle($title);

    /**
     * Set content
     *
     * @param string $content
     * @return PostInterface
     */
    public function setContent($content);

    /**
     * Set announce
     *
     * @param string $announce
     * @return PostInterface
     */
    public function setAnnounce($announce);

    /**
     * Set publish date
     *
     * @param string $publishDate
     * @return PostInterface
     */
    public function setPublishDate($publishDate);

    /**
     * Set post status
     *
     * @param bool $isPublished
     * @return PostInterface
     */
    public function setPostStatus($isPublished);

    /**
     * Set created time
     *
     * @param string $createdTime
     * @return PostInterface
     */
    public function setCreatedTime($createdTime);

    /**
     * Set updated time
     *
     * @param string $updatedTime
     * @return PostInterface
     */
    public function setUpdatedTime($updatedTime);
}
