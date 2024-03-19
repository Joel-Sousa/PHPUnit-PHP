<?php

namespace OrderBundle\Service;

use OrderBundle\Entity\Customer;

class CustomerCategoryService
{
    const CATEGORY_NEW_USER = 'new-user';
    const CATEGORY_LIGHT_USER = 'light-user';
    const CATEGORY_MEDIUM_USER = 'medium-user';
    const CATEGORY_HEAVY_USER = 'heavy-user';

    private $categories;

    public function addCategory(CustomerCategoryInterface $category)
    {
        $this->categories[] = $category;
    }

    public function getUsageCategory(Customer $customer)
    {
        foreach ($this->categories as  $category) {
            if ($category->isEligible($customer)) {
                return $category->getCategoryName();
            }
        }

        if ($customer->getTotalOrders() >= 20 && $customer->getTotalRatings() >= 5 && $customer->getTotalRecommendations() >= 1) {
            return self::CATEGORY_MEDIUM_USER;
        }

        if ($customer->getTotalOrders() >= 5 && $customer->getTotalRatings() >= 1)
            return self::CATEGORY_LIGHT_USER;

        return self::CATEGORY_NEW_USER;
    }
}
