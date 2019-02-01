<?php

namespace GorbanSv\ModuleOop\Model;

use Magento\Framework\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Driver\File;

/**
 * Class DirContents
 * @package GorbanSv\ModuleOop\Model
 */
class DirContents
{
    public const DIRCONTENTS_CONST = 'DirContents constant';

    /**
     * @var DirectoryList
     */
    private $directoryList;

    /**
     * @var File
     */
    private $file;

    /**
     * DirContents constructor.
     * @param DirectoryList $directoryList
     * @param File $file
     */
    public function __construct(
        DirectoryList $directoryList,
        File $file
    ) {
        $this->directoryList = $directoryList;
        $this->file = $file;
    }

    /**
     * @param bool $magento_way
     * @return array
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function getDirContents(bool $magento_way = false) : array
    {
        $result = $items = [];
        $app_code_path = $this->directoryList->getPath('app'). '/code';

        if ($magento_way) {
            foreach ($this->file->readDirectoryRecursively($app_code_path) as $item) {
                $items[] = $item;
            }
        } else {
            $flags = \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::UNIX_PATHS;
            $objects = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($app_code_path, $flags),
                \RecursiveIteratorIterator::CHILD_FIRST
            );

            foreach ($objects as $item) {
                $items[] = $item->getPathname();
            }
        }

        foreach ($items as $item) {
            $fileData = $this->file->stat($item);
            $result[$item] = date('Y-m-d H:i:s', $fileData['mtime']);
        }

        return $result;
    }
}
