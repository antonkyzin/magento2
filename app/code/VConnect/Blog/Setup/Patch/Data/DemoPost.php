<?php
declare(strict_types=1);

namespace VConnect\Blog\Setup\Patch\Data;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use VConnect\Blog\Api\Data\PostInterfaceFactory;
use VConnect\Blog\Model\PostRepository;

class DemoPost implements DataPatchInterface
{
    private ModuleDataSetupInterface $moduleDataSetup;
    private PostInterfaceFactory $postFactory;
    private PostRepository $postRepository;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param PostInterfaceFactory $postFactory
     * @param PostRepository $postRepository
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        PostInterfaceFactory $postFactory,
        PostRepository $postRepository
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->postFactory = $postFactory;
        $this->postRepository = $postRepository;
    }

    /**
     * @inheritDoc
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $post = $this->postFactory->create();
        $post->setTitle('DemoTitle');
        $post->setContent('DemoContent');
        $post->setAnnounce('DemoAnnounce');
        $post->setUrlKey('demo-post');
        try {
            $this->postRepository->save($post);
        } catch (CouldNotSaveException $couldNotSaveException) {
            //silently skip
        }
        $this->moduleDataSetup->endSetup();
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getAliases(): array
    {
        return [];
    }
}
