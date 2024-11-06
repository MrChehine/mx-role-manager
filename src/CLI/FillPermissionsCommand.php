<?php

namespace MxRoleManager\CLI;

class FillPermissionsCommand extends AbstractCommand
{
    private bool $isUpdate = false;
    private bool $isClearCache = false;
    private bool $isTruncate = false;

    /**
     * @return bool
     */
    public function isUpdate(): bool
    {
        return $this->isUpdate;
    }

    /**
     * @param bool $isUpdateCommand
     */
    public function setIsUpdate(bool $isUpdate): void
    {
        $this->isUpdate = $isUpdate;
    }

    /**
     * @return bool
     */
    public function isClearCache(): bool
    {
        return $this->isClearCache;
    }

    /**
     * @param bool $isClearCache
     */
    public function setIsClearCache(bool $isClearCache): void
    {
        $this->isClearCache = $isClearCache;
    }

    /**
     * @return bool
     */
    public function isTruncate(): bool
    {
        return $this->isTruncate;
    }

    /**
     * @param bool $isTruncate
     */
    public function setIsTruncate(bool $isTruncate): void
    {
        $this->isTruncate = $isTruncate;
    }
}