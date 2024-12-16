<?php
declare(strict_types = 1);

namespace Blackbird\EavOptimize\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Config
{
    const string DEV_CACHING_CACHE_OPTION_VALUES = 'dev/caching/cache_option_values';
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return mixed
     */
    public function getCacheOptionValues(): bool
    {
        return $this->scopeConfig->getValue(self::DEV_CACHING_CACHE_OPTION_VALUES) == 1;
    }
}
