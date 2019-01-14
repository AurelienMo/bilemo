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

namespace App\Application\UseCases\Phones\Delete;

use App\Application\Helpers\Core\ProcessorErrorsHttp;
use App\Application\UseCases\AbstractPersister;
use App\Application\UseCases\InputInterface;
use App\Application\UseCases\OutputInterface;
use App\Domain\Model\Phone;

/**
 * Class Persister
 */
class Persister extends AbstractPersister
{
    /**
     * @param InputInterface|DeletePhoneInput $input
     *
     * @return OutputInterface|null
     */
    public function save(InputInterface $input): ?OutputInterface
    {
        try {
            $this->entityManager->remove($input->getPhone());
        } catch (\Exception $e) {
            ProcessorErrorsHttp::throwInternalError(ProcessorErrorsHttp::INTERNAL_ERROR_SERVER);
        }

        return null;
    }

    protected function getClassRepository(): string
    {
        return Phone::class;
    }
}
