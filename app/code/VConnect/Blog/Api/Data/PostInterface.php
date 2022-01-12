<?php
declare(strict_types=1);

namespace VConnect\Blog\Api\Data;

interface PostInterface
{
    /**
     * Constants for keys of data array
     */
    public const POST_ID = 'post_id';
    public const TITLE = 'title';
    public const CONTENT = 'content';
    public const ANNOUNCE = 'announce';
    public const PUBLISH_DATE = 'publish_date';
    public const IS_PUBLISHED = 'is_published';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    /**
     * Get ID
     *
     * @return string|null
     */
    public function getPostId(): ?string;

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle(): ?string;

    /**
     * Get content
     *
     * @return string|null
     */
    public function getContent(): ?string;

    /**
     * Get announce
     *
     * @return string|null
     */
    public function getAnnounce(): ?string;

    /**
     * Get publish date
     *
     * @return string|null
     */
    public function getPublishDate(): ?string;

    /**
     * Get post status
     *
     * @return string|null
     */
    public function getPostStatus(): ?string;

    /**
     * Get created time
     *
     * @return string|null
     */
    public function getCreatedTime(): ?string;

    /**
     * Get updated time
     *
     * @return string|null
     */
    public function getUpdatedTime(): ?string;

    /**
     * Set ID
     *
     * @param int $id
     * @return PostInterface
     */
    public function setPostId(int $id): PostInterface;

    /**
     * Set title
     *
     * @param string $title
     * @return PostInterface
     */
    public function setTitle(string $title): PostInterface;

    /**
     * Set content
     *
     * @param string $content
     * @return PostInterface
     */
    public function setContent(string $content): PostInterface;

    /**
     * Set announce
     *
     * @param string $announce
     * @return PostInterface
     */
    public function setAnnounce(string $announce): PostInterface;

    /**
     * Set publish date
     *
     * @param string $publishDate
     * @return PostInterface
     */
    public function setPublishDate(string $publishDate): PostInterface;

    /**
     * Set post status
     *
     * @param bool $isPublished
     * @return PostInterface
     */
    public function setPostStatus(bool $isPublished): PostInterface;

    /**
     * Set created time
     *
     * @param string $createdTime
     * @return PostInterface
     */
    public function setCreatedTime(string $createdTime): PostInterface;

    /**
     * Set updated time
     *
     * @param string $updatedTime
     * @return PostInterface
     */
    public function setUpdatedTime(string $updatedTime): PostInterface;
}
