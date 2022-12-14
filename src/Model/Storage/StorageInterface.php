<?php

namespace Panosmits\Basekit\Model\Storage;

interface StorageInterface
{
    public static function make(): StorageInterface;
    public function getName(): string;
    public function save(string $filePath): string;
    public function delete(string $imageId): void;
    public function retrieve(string $imageId): string;
}