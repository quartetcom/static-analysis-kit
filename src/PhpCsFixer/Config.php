<?php

declare(strict_types=1);

namespace Quartetcom\StaticAnalysisKit\PhpCsFixer;

use PhpCsFixer\Config as BaseConfig;
use PhpCsFixer\ConfigInterface;

class Config extends BaseConfig
{
    /**
     * @var array<string, array<string, mixed>|bool>
     */
    public array $normalRules = [
        '@PSR12' => true,
        '@PHP81Migration' => true,
        '@PhpCsFixer' => true,
        '@Symfony' => true,
        '@DoctrineAnnotation' => true,
        'control_structure_braces' => true,
        'control_structure_continuation_position' => true,
        'curly_braces_position' => true,
        'declare_parentheses' => true,
        'general_phpdoc_annotation_remove' => [
            'annotations' => ['author', 'package', 'subpackage'],
            'case_sensitive' => false,
        ],
        'no_multiple_statements_per_line' => true,
        'nullable_type_declaration_for_default_null_value' => true,
        'php_unit_internal_class' => false,
        'php_unit_test_class_requires_covers' => false,
        'phpdoc_line_span' => ['const' => 'multi', 'method' => 'multi', 'property' => 'multi'],
        'phpdoc_summary' => false,
        'phpdoc_tag_casing' => true,
        'phpdoc_types_order' => ['null_adjustment' => 'always_first'],
        'self_static_accessor' => true,
        'simplified_if_return' => true,
        'simplified_null_return' => true,
        'single_line_throw' => false,
        'statement_indentation' => true,
        'trailing_comma_in_multiline' => [
            'after_heredoc' => true,
            'elements' => ['arguments', 'arrays', 'match', 'parameters'],
        ],
        'yoda_style' => false,
    ];

    /**
     * @var array<string, array<string, mixed>|bool>
     */
    public array $riskyRules = [
        '@PHP80Migration:risky' => true,
        '@PHPUnit84Migration:risky' => true,
        '@PhpCsFixer:risky' => true,
        '@Symfony:risky' => true,
        'date_time_create_from_format_call' => true,
        'date_time_immutable' => true,
        'php_unit_test_case_static_method_calls' => ['call_type' => 'this'],
        'regular_callable_call' => true,
        'strict_param' => true,
    ];

    public function __construct(string $name = 'default')
    {
        parent::__construct($name);

        // Returns a ruleset with risky rules when loading .php-cs-fixer.dist.php directly for editor integrations.
        $this->configure(useRiskyRules: true);
    }

    public function setRules(array $rules): never
    {
        throw new \RuntimeException(
            'Config::setRules is disabled by quartetcom/static-analysis-kit. Use addRules or addRiskyRules instead.',
        );
    }

    /**
     * @param array<string, array<string, mixed>|bool> $rules
     */
    public function addRules(array $rules): static
    {
        $this->normalRules = [...$this->normalRules, ...$rules];

        return $this;
    }

    /**
     * @param array<string, array<string, mixed>|bool> $rules
     */
    public function addRiskyRules(array $rules): static
    {
        $this->riskyRules = [...$this->riskyRules, ...$rules];

        return $this;
    }

    public function configure(bool $useNormalRules = true, bool $useRiskyRules = false): ConfigInterface
    {
        return parent::setRules([
            ...($useNormalRules ? $this->normalRules : []),
            ...($useRiskyRules ? $this->riskyRules : []),
        ])
            ->setRiskyAllowed($useRiskyRules)
        ;
    }
}
