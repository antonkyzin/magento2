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
    public const URL_KEY = 'url_key';

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
     * Get url key
     *
     * @return string|null
     */
    public function getUrlKey(): ?string;

    /**
     * Set ID
     *
     * @param string $id
     * @return void
     */
    public function setPostId(string $id): void;

    /**
     * Set title
     *
     * @param string $title
     * @return void
     */
    public function setTitle(string $title): void;

    /**
     * Set content
     *
     * @param string $content
     * @return void
     */
    public function setContent(string $content): void;

    /**
     * Set announce
     *
     * @param string $announce
     * @return void
     */
    public function setAnnounce(string $announce): void;

    /**
     * Set publish date
     *
     * @param string $publishDate
     * @return void
     */
    public function setPublishDate(string $publishDate): void;

    /**
     * Set post status
     *
     * @param string $isPublished
     * @return void
     */
    public function setPostStatus(string $isPublished): void;

    /**
     * Set created time
     *
     * @param string $createdTime
     * @return void
     */
    public function setCreatedTime(string $createdTime): void;

    /**
     * Set url key
     *
     * @param string $urlKey
     * @return void
     */
    public function setUrlKey(string $urlKey): void;

    /**
     * Set updated time
     *
     * @param string $updatedTime
     * @return void
     */
    public function setUpdatedTime(string $updatedTime): void;
}
