<?php

namespace Panosmits\Basekit\Model\Storage;

interface StorageInterface
{
    public static function make(): StorageInterface;
    public function save($file): string;
//    public function retrieve($file): string;
//    public function delete($file): string;
}