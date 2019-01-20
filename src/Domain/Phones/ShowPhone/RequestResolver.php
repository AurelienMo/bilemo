<?php

declare(strict_types=1);

/*
 * This file is part of Bilemo
 *
 * (c) Aurelien Morvan <morvan.aurelien@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\Phones\ShowPhone;

use App\Domain\AbstractRequestResolver;
use App\Domain\Common\Helpers\ProcessorErrorsHttp;
use App\Domain\Common\Helpers\RequestExtractorParams;
use App\Domain\InputInterface;
use App\Entity\Phone;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RequestResolver
 */
class RequestResolver extends AbstractRequestResolver
{
    public function resolve(Request $request): InputInterface
    {
        $phoneId = RequestExtractorParams::extractParams($request, RequestExtractorParams::PATH_PARAMS, 'id');
        $phone = $this->getRepository(Phone::class)->loadById($phoneId);

        if (empty($phone)) {
            ProcessorErrorsHttp::throwNotFound(
                ProcessorErrorsHttp::PRODUCT_NOT_FOUND
            );
        }

        $input = $this->instanciateInputClass();
        $input->setPhone($phone[0]);
        unset($phone[0]);
        $input->setPhonesFeatures(array_values($phone));

        return $input;
    }

    protected function getClassInput(): string
    {
        return PhoneInput::class;
    }
}
