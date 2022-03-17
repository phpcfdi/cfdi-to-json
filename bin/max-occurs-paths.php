<?php

declare(strict_types=1);

use PhpCfdi\CfdiToJson\XsdMaxOccurs\XsdMaxOccursFromNsRegistry;

require __DIR__ . '/../vendor/autoload.php';

exit(call_user_func(new class (...$argv) {
    /** @var string */
    private $commandName;

    /** @var string[] */
    private $arguments;

    public function __construct(string $commandName, string ...$arguments)
    {
        $this->commandName = $commandName;
        $this->arguments = $arguments;
    }

    public function __invoke(): int
    {
        try {
            if ([] !== array_intersect($this->arguments, ['-h', '--help'])) {
                $this->printHelp();
                return 0;
            }

            $app = new XsdMaxOccursFromNsRegistry();
            echo json_encode($app->obtainPaths(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), "\n";

            return 0;
        } catch (Throwable $exception) {
            file_put_contents('php://stderr', $exception->getMessage() . PHP_EOL, FILE_APPEND);
            return $exception->getCode() ?: 1;
        }
    }

    public function printHelp(): void
    {
        echo <<<HELP
            This program obtains the SAT namespace registry from phpcfdi/sat-ns-registry and search into all
            the XML Schema Definitions (XSD) all the elements that can appears multiple times.

            Syntax:
                php {$this->commandName} [-h|--help]

            Common usage:
                php {$this->commandName} > src/UnboundedOccursPaths.json

            This file is part of https://github.com/phpcfdi/cfdi-to-json project

            HELP;
    }
}));
