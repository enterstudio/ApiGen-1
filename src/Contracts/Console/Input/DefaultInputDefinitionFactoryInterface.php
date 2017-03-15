<?php declare(strict_types=1);

namespace ApiGen\Contracts\Console\Input;

use Symfony\Component\Console\Input\InputDefinition;

interface DefaultInputDefinitionFactoryInterface
{

    /**
     * @return InputDefinition
     */
    public function create();
}
