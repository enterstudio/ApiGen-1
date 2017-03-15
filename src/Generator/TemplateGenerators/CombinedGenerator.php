<?php declare(strict_types=1);

namespace ApiGen\Generator\TemplateGenerators;

use ApiGen\Contracts\Generator\TemplateGenerators\TemplateGeneratorInterface;
use ApiGen\Templating\TemplateFactory;

class CombinedGenerator implements TemplateGeneratorInterface
{

    /**
     * @var TemplateFactory
     */
    private $templateFactory;


    public function __construct(TemplateFactory $templateFactory)
    {
        $this->templateFactory = $templateFactory;
    }


    /**
     * {@inheritdoc}
     */
    public function generate()
    {
        $this->templateFactory->createForType('combined')
            ->save();
    }
}
