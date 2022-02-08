<?php
declare(strict_types=1);

use Magento\TestFramework\Helper\Bootstrap;
use VConnect\Blog\Api\Data\PostInterface;
use VConnect\Blog\Api\PostRepositoryInterface;

$objectManager = Bootstrap::getObjectManager();

$post = $objectManager->create(PostInterface::class);
$repo = $objectManager->create(PostRepositoryInterface::class);
$post->setTitle('Title');
$post->setContent('Content content');
$post->setAnnounce('Announce');
$post->setPostStatus('0');
$post->setUrlKey('url_key_for_post_1');
$post->setPublishDate('2022-02-08 07:12:15');
$repo->save($post);
