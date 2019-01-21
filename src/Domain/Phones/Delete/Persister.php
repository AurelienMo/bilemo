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

namespace App\Domain\Phones\Delete;

use App\Domain\AbstractPersister;
use App\Domain\InputInterface;
use App\Entity\PhoneHasFeature;

/**
 * Class Persister
 */
class Persister extends AbstractPersister
{
    /**
     * @param InputInterface|PhoneDeleteInput $input
     *
     * @return string|null
     */
    public function save(InputInterface $input): ?string
    {
        $features = $this->getRepository()->listByPhoneId($input->getPhone()->getId()->toString());
        $this->removeAllFeaturesAttachPhone($features);
        $this->entityManager->remove($input->getPhone());
        $this->entityManager->flush();

        return null;
    }

    protected function getClassRepository(): string
    {
        return PhoneHasFeature::class;
    }

    private function removeAllFeaturesAttachPhone(array $features)
    {
        /** @var PhoneHasFeature $feature */
        foreach ($features as $feature) {
            $this->entityManager->remove($feature);
        }
    }
}
