<?php
declare(strict_types=1);

namespace App\Dto;

use App\Helper\Request\Access;

class PlatformAccess
{
    /**
     * Source Unknown
     */
    const SOURCE_UNKNOWN = 0;

    /**
     * Source Member Web
     */
    const SOURCE_MEMBER_WEB = 1;

    /**
     * Source Member Application (Android/IOS)
     */
    const SOURCE_MEMBER_MOBILE_APPLICATION = 2;
    /**
     * Source Venue Dashboard Web
     */
    const SOURCE_VENUE_DASHBOARD_WEB = 3;
    /**
     * Source Admin Dashboard Web
     */
    const SOURCE_ADMIN_DASHBOARD_WEB = 4;

    /**
     * Source Member GO-Fitness Web
     */
    const SOURCE_MEMBER_GOFITNESS_WEB = 5;

    /**
     * PlatformAccess constructor.
     * @param Access $access
     */
    public function __construct(private Access $access)
    {
    }

    /**
     * @param int $check
     * @return bool
     */
    public function is(int $check): bool
    {
        return $this->getPlatformID() == $check;
    }

    /**
     * @return int
     */
    public function getPlatformID(): int
    {
        return match ($this->access->getRequestAs()) {
            Access::AS_MEMBER => self::SOURCE_MEMBER_MOBILE_APPLICATION,
            Access::AS_MEMBER_GOJEK => self::SOURCE_MEMBER_GOFITNESS_WEB,
            Access::AS_VENUE_ACCESS => self::SOURCE_VENUE_DASHBOARD_WEB,
            default => self::SOURCE_UNKNOWN
        };
    }
}
