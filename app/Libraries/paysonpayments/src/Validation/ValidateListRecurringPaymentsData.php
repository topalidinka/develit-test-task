<?php
/**
 *  @author    Payson AB <integration@payson.se>
 *  @copyright 2019 Payson AB
 *  @license   http://unlicense.org/
 */

namespace Payson\Payments\Validation;

/**
 * @package Payson\Payments\Validation
 */
class ValidateListRecurringPaymentsData extends ValidationService
{
    /**
     * @param mixed $data
     */
    public function validate($data)
    {
        $this->mustBeSet($data, 'subscriptionid', 'Recurring subscription ID');
        $this->mustBeString($data['subscriptionid'], 'Recurring subscription ID');

        if (isset($data['page'])) {
            $this->mustBeInteger($data['page'], 'Page number');
        }
    }
}
