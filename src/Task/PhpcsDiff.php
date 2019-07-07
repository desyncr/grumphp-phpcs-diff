<?php

namespace Desyncr\GrumPHP\Task;

use GrumPHP\Collection\ProcessArgumentsCollection;
use GrumPHP\Runner\TaskResult;
use GrumPHP\Task\Context\ContextInterface;
use GrumPHP\Task\Context\GitPreCommitContext;
use GrumPHP\Task\Context\RunContext;
use RuntimeException;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * PhpcsDiff task
 *
 * @property \GrumPHP\Formatter\PhpcsFormatter $formatter
 */
class PhpcsDiff extends AbstractExternalTask
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'phpcs-diff';
    }

    /**
     * @return OptionsResolver
     */
    public function getConfigurableOptions()
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'standard' => 'PSR12',
            'branch' => 'master'
        ]);

        $resolver->addAllowedTypes('standard', ['string']);
        $resolver->addAllowedTypes('branch', ['string']);

        return $resolver;
    }

    /**
     * {@inheritdoc}
     */
    public function canRunInContext(ContextInterface $context)
    {
        return ($context instanceof GitPreCommitContext || $context instanceof RunContext);
    }

    /**
     * {@inheritdoc}
     */
    public function run(ContextInterface $context)
    {
        /** @var array $config */
        $config = $this->getConfiguration();
        /** @var array $whitelistPatterns */

        $arguments = $this->processBuilder->createArgumentsForCommand('phpcs-diff');
        $arguments->add($config['branch']);

        $process = $this->processBuilder->buildProcess($arguments);
        $process->run();

        if (!$process->isSuccessful()) {
            return TaskResult::createFailed($this, $context, $output);
        }

        return TaskResult::createPassed($this, $context);
    }
}
