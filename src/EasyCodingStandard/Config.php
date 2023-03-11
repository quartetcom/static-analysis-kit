<?php

declare(strict_types=1);

namespace Quartetcom\StaticAnalysisKit\EasyCodingStandard;

use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\AssignmentInConditionSniff;
use PhpCsFixer\Fixer\Alias\ArrayPushFixer;
use PhpCsFixer\Fixer\Alias\BacktickToShellExecFixer;
use PhpCsFixer\Fixer\Alias\EregToPregFixer;
use PhpCsFixer\Fixer\Alias\ModernizeStrposFixer;
use PhpCsFixer\Fixer\Alias\NoAliasFunctionsFixer;
use PhpCsFixer\Fixer\Alias\NoAliasLanguageConstructCallFixer;
use PhpCsFixer\Fixer\Alias\NoMixedEchoPrintFixer;
use PhpCsFixer\Fixer\Alias\PowToExponentiationFixer;
use PhpCsFixer\Fixer\Alias\RandomApiMigrationFixer;
use PhpCsFixer\Fixer\Alias\SetTypeToCastFixer;
use PhpCsFixer\Fixer\ArrayNotation\NoMultilineWhitespaceAroundDoubleArrowFixer;
use PhpCsFixer\Fixer\ArrayNotation\NormalizeIndexBraceFixer;
use PhpCsFixer\Fixer\Basic\BracesFixer;
use PhpCsFixer\Fixer\Basic\NonPrintableCharacterFixer;
use PhpCsFixer\Fixer\Basic\OctalNotationFixer;
use PhpCsFixer\Fixer\Basic\PsrAutoloadingFixer;
use PhpCsFixer\Fixer\Casing\ClassReferenceNameCasingFixer;
use PhpCsFixer\Fixer\Casing\IntegerLiteralCaseFixer;
use PhpCsFixer\Fixer\Casing\MagicMethodCasingFixer;
use PhpCsFixer\Fixer\Casing\NativeFunctionCasingFixer;
use PhpCsFixer\Fixer\Casing\NativeFunctionTypeDeclarationCasingFixer;
use PhpCsFixer\Fixer\CastNotation\ModernizeTypesCastingFixer;
use PhpCsFixer\Fixer\CastNotation\NoShortBoolCastFixer;
use PhpCsFixer\Fixer\CastNotation\NoUnsetCastFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use PhpCsFixer\Fixer\ClassNotation\NoNullPropertyInitializationFixer;
use PhpCsFixer\Fixer\ClassNotation\NoPhp4ConstructorFixer;
use PhpCsFixer\Fixer\ClassNotation\NoUnneededFinalMethodFixer;
use PhpCsFixer\Fixer\ClassNotation\OrderedTraitsFixer;
use PhpCsFixer\Fixer\ClassNotation\SelfAccessorFixer;
use PhpCsFixer\Fixer\ClassNotation\SelfStaticAccessorFixer;
use PhpCsFixer\Fixer\ClassUsage\DateTimeImmutableFixer;
use PhpCsFixer\Fixer\Comment\CommentToPhpdocFixer;
use PhpCsFixer\Fixer\Comment\MultilineCommentOpeningClosingFixer;
use PhpCsFixer\Fixer\Comment\NoEmptyCommentFixer;
use PhpCsFixer\Fixer\Comment\SingleLineCommentSpacingFixer;
use PhpCsFixer\Fixer\ConstantNotation\NativeConstantInvocationFixer;
use PhpCsFixer\Fixer\ControlStructure\ControlStructureBracesFixer;
use PhpCsFixer\Fixer\ControlStructure\ControlStructureContinuationPositionFixer;
use PhpCsFixer\Fixer\ControlStructure\EmptyLoopBodyFixer;
use PhpCsFixer\Fixer\ControlStructure\EmptyLoopConditionFixer;
use PhpCsFixer\Fixer\ControlStructure\IncludeFixer;
use PhpCsFixer\Fixer\ControlStructure\NoAlternativeSyntaxFixer;
use PhpCsFixer\Fixer\ControlStructure\SimplifiedIfReturnFixer;
use PhpCsFixer\Fixer\ControlStructure\SwitchContinueToBreakFixer;
use PhpCsFixer\Fixer\ControlStructure\TrailingCommaInMultilineFixer;
use PhpCsFixer\Fixer\FunctionNotation\CombineNestedDirnameFixer;
use PhpCsFixer\Fixer\FunctionNotation\FopenFlagOrderFixer;
use PhpCsFixer\Fixer\FunctionNotation\FopenFlagsFixer;
use PhpCsFixer\Fixer\FunctionNotation\ImplodeCallFixer;
use PhpCsFixer\Fixer\FunctionNotation\LambdaNotUsedImportFixer;
use PhpCsFixer\Fixer\FunctionNotation\NativeFunctionInvocationFixer;
use PhpCsFixer\Fixer\FunctionNotation\NoUnreachableDefaultArgumentValueFixer;
use PhpCsFixer\Fixer\FunctionNotation\NoUselessSprintfFixer;
use PhpCsFixer\Fixer\FunctionNotation\UseArrowFunctionsFixer;
use PhpCsFixer\Fixer\FunctionNotation\VoidReturnFixer;
use PhpCsFixer\Fixer\Import\FullyQualifiedStrictTypesFixer;
use PhpCsFixer\Fixer\Import\GlobalNamespaceImportFixer;
use PhpCsFixer\Fixer\Import\NoUnneededImportAliasFixer;
use PhpCsFixer\Fixer\LanguageConstruct\CombineConsecutiveIssetsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\CombineConsecutiveUnsetsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\DirConstantFixer;
use PhpCsFixer\Fixer\LanguageConstruct\ErrorSuppressionFixer;
use PhpCsFixer\Fixer\LanguageConstruct\FunctionToConstantFixer;
use PhpCsFixer\Fixer\LanguageConstruct\GetClassToClassKeywordFixer;
use PhpCsFixer\Fixer\LanguageConstruct\IsNullFixer;
use PhpCsFixer\Fixer\LanguageConstruct\NoUnsetOnPropertyFixer;
use PhpCsFixer\Fixer\ListNotation\ListSyntaxFixer;
use PhpCsFixer\Fixer\NamespaceNotation\CleanNamespaceFixer;
use PhpCsFixer\Fixer\Naming\NoHomoglyphNamesFixer;
use PhpCsFixer\Fixer\Operator\AssignNullCoalescingToCoalesceEqualFixer;
use PhpCsFixer\Fixer\Operator\IncrementStyleFixer;
use PhpCsFixer\Fixer\Operator\LogicalOperatorsFixer;
use PhpCsFixer\Fixer\Operator\NotOperatorWithSuccessorSpaceFixer;
use PhpCsFixer\Fixer\Operator\NoUselessConcatOperatorFixer;
use PhpCsFixer\Fixer\Operator\NoUselessNullsafeOperatorFixer;
use PhpCsFixer\Fixer\Operator\ObjectOperatorWithoutWhitespaceFixer;
use PhpCsFixer\Fixer\Operator\OperatorLinebreakFixer;
use PhpCsFixer\Fixer\Operator\StandardizeNotEqualsFixer;
use PhpCsFixer\Fixer\Operator\TernaryToElvisOperatorFixer;
use PhpCsFixer\Fixer\Operator\TernaryToNullCoalescingFixer;
use PhpCsFixer\Fixer\Phpdoc\AlignMultilineCommentFixer;
use PhpCsFixer\Fixer\Phpdoc\GeneralPhpdocAnnotationRemoveFixer;
use PhpCsFixer\Fixer\Phpdoc\GeneralPhpdocTagRenameFixer;
use PhpCsFixer\Fixer\Phpdoc\NoBlankLinesAfterPhpdocFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocAddMissingParamAnnotationFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocAlignFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocAnnotationWithoutDotFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocInlineTagNormalizerFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoAccessFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoAliasTagFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoPackageFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoUselessInheritdocFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocOrderByValueFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocOrderFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocSeparationFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTagCasingFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTagTypeFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocToCommentFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTypesOrderFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocVarAnnotationCorrectOrderFixer;
use PhpCsFixer\Fixer\PhpTag\EchoTagSyntaxFixer;
use PhpCsFixer\Fixer\PhpTag\LinebreakAfterOpeningTagFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitConstructFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitDedicateAssertFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitDedicateAssertInternalTypeFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitExpectationFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitFqcnAnnotationFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitMockFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitMockShortWillReturnFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitNamespacedFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitNoExpectationAnnotationFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitSetUpTearDownVisibilityFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitStrictFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitTestAnnotationFixer;
use PhpCsFixer\Fixer\ReturnNotation\NoUselessReturnFixer;
use PhpCsFixer\Fixer\ReturnNotation\ReturnAssignmentFixer;
use PhpCsFixer\Fixer\ReturnNotation\SimplifiedNullReturnFixer;
use PhpCsFixer\Fixer\Semicolon\MultilineWhitespaceBeforeSemicolonsFixer;
use PhpCsFixer\Fixer\Semicolon\NoEmptyStatementFixer;
use PhpCsFixer\Fixer\Semicolon\SemicolonAfterInstructionFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use PhpCsFixer\Fixer\Strict\StrictComparisonFixer;
use PhpCsFixer\Fixer\Strict\StrictParamFixer;
use PhpCsFixer\Fixer\StringNotation\EscapeImplicitBackslashesFixer;
use PhpCsFixer\Fixer\StringNotation\HeredocToNowdocFixer;
use PhpCsFixer\Fixer\StringNotation\NoBinaryStringFixer;
use PhpCsFixer\Fixer\StringNotation\NoTrailingWhitespaceInStringFixer;
use PhpCsFixer\Fixer\StringNotation\SimpleToComplexStringVariableFixer;
use PhpCsFixer\Fixer\StringNotation\StringLengthToEmptyFixer;
use PhpCsFixer\Fixer\StringNotation\StringLineEndingFixer;
use PhpCsFixer\Fixer\Whitespace\BlankLineBeforeStatementFixer;
use PhpCsFixer\Fixer\Whitespace\HeredocIndentationFixer;
use PhpCsFixer\Fixer\Whitespace\NoExtraBlankLinesFixer;
use PhpCsFixer\Fixer\Whitespace\TypesSpacesFixer;
use Symplify\CodingStandard\Fixer\ArrayNotation\ArrayListItemNewlineFixer;
use Symplify\CodingStandard\Fixer\ArrayNotation\ArrayOpenerAndCloserNewlineFixer;
use Symplify\CodingStandard\Fixer\ArrayNotation\StandaloneLineInMultilineArrayFixer;
use Symplify\CodingStandard\Fixer\Spacing\MethodChainingNewlineFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

class Config
{
    public static function use(ECSConfig $ecsConfig): void
    {
        $ecsConfig->sets([
            SetList::COMMON,
            SetList::CLEAN_CODE,
            SetList::PSR_12,
            SetList::DOCTRINE_ANNOTATIONS,
        ]);

        $ecsConfig->rules([
            AlignMultilineCommentFixer::class, // PhpCsFixer
            AssignNullCoalescingToCoalesceEqualFixer::class, // PHP74Migration
            BacktickToShellExecFixer::class, // Symfony
            ClassReferenceNameCasingFixer::class, // Symfony
            CleanNamespaceFixer::class, // Symfony, PHP80Migration
            CombineConsecutiveUnsetsFixer::class, // PhpCsFixer
            CombineConsecutiveIssetsFixer::class, // PhpCsFixer
            ControlStructureBracesFixer::class,
            ControlStructureContinuationPositionFixer::class, // Symfony
            EchoTagSyntaxFixer::class, // Symfony
            EmptyLoopConditionFixer::class, // Symfony
            EscapeImplicitBackslashesFixer::class, // PhpCsFixer
            FullyQualifiedStrictTypesFixer::class, // Symfony
            HeredocIndentationFixer::class, // PHP73Migration
            HeredocToNowdocFixer::class, // PhpCsFixer
            IncludeFixer::class, // Symfony
            IncrementStyleFixer::class, // Symfony
            IntegerLiteralCaseFixer::class, // Symfony
            LambdaNotUsedImportFixer::class, // Symfony
            LinebreakAfterOpeningTagFixer::class, // Symfony
            ListSyntaxFixer::class, // PHP71Migration
            MagicMethodCasingFixer::class, // Symfony
            MultilineCommentOpeningClosingFixer::class, // PhpCsFixer
            NativeFunctionCasingFixer::class, // Symfony
            NativeFunctionTypeDeclarationCasingFixer::class, // Symfony
            NoAliasLanguageConstructCallFixer::class, // Symfony
            NoAlternativeSyntaxFixer::class, // Symfony
            NoBinaryStringFixer::class, // Symfony
            NoBlankLinesAfterPhpdocFixer::class, // Symfony
            NoEmptyCommentFixer::class, // Symfony
            NoEmptyStatementFixer::class, // Symfony
            NoMixedEchoPrintFixer::class, // Symfony
            NoMultilineWhitespaceAroundDoubleArrowFixer::class, // Symfony
            NoNullPropertyInitializationFixer::class, // PhpCsFixer
            NoShortBoolCastFixer::class, // Symfony
            NoUnneededImportAliasFixer::class, // Symfony
            NoUnsetCastFixer::class, // Symfony, PHP80Migration
            NoUselessConcatOperatorFixer::class, // Symfony
            NoUselessNullsafeOperatorFixer::class, // Symfony
            NoUselessReturnFixer::class, // PhpCsFixer
            NormalizeIndexBraceFixer::class, // Symfony, PHP74Migration
            ObjectOperatorWithoutWhitespaceFixer::class, // Symfony
            OctalNotationFixer::class, // PHP81Migration
            PhpUnitFqcnAnnotationFixer::class, // Symfony
            PhpdocAddMissingParamAnnotationFixer::class, // PHpCsFixer
            PhpdocAlignFixer::class, // Symfony
            PhpdocAnnotationWithoutDotFixer::class, // Symfony
            PhpdocInlineTagNormalizerFixer::class, // Symfony
            PhpdocNoAccessFixer::class, // Symfony
            PhpdocNoAliasTagFixer::class, // Symfony
            PhpdocNoPackageFixer::class, // Symfony
            PhpdocNoUselessInheritdocFixer::class, // Symfony
            PhpdocOrderByValueFixer::class, // PhpCsFixer
            PhpdocSeparationFixer::class, // Symfony
            PhpdocToCommentFixer::class, // Symfony
            PhpdocTagCasingFixer::class,
            PhpdocVarAnnotationCorrectOrderFixer::class, // PHpCsFixer
            ReturnAssignmentFixer::class, // PhpCsFixer
            SelfStaticAccessorFixer::class,
            SemicolonAfterInstructionFixer::class, // Symfony
            SimpleToComplexStringVariableFixer::class, // Symfony
            SingleLineCommentSpacingFixer::class,
            SimplifiedIfReturnFixer::class,
            SimplifiedNullReturnFixer::class,
            StandardizeNotEqualsFixer::class, // Symfony
            SwitchContinueToBreakFixer::class, // Symfony
            TernaryToNullCoalescingFixer::class, // PHP70Migration
            TypesSpacesFixer::class, // Symfony
        ]);

        $ecsConfig->rulesWithConfiguration(rulesWithConfiguration: [
            BlankLineBeforeStatementFixer::class => [ // Symfony
                'statements' => ['return'],
            ],
            BracesFixer::class => [ // Symfony
                'allow_single_line_anonymous_class_with_empty_body' => true,
                'allow_single_line_closure' => true,
            ],
            ClassAttributesSeparationFixer::class => [ // Symfony
                'elements' => ['method' => 'one'],
            ],
            EmptyLoopBodyFixer::class => [ // Symfony
                'style' => 'braces',
            ],
            GeneralPhpdocAnnotationRemoveFixer::class => [
                'annotations' => ['author', 'package', 'subpackage'],
                'case_sensitive' => false,
            ],
            GeneralPhpdocTagRenameFixer::class => [ // Symfony
                'replacements' => ['inheritDocs' => 'inheritDoc'],
            ],
            GlobalNamespaceImportFixer::class => [ // Symfony
                'import_classes' => false,
                'import_constants' => false,
                'import_functions' => false,
            ],
            MultilineWhitespaceBeforeSemicolonsFixer::class => [ // PhpCsFixer
                'strategy' => 'new_line_for_chained_calls',
            ],
            NoExtraBlankLinesFixer::class => [ // Symfony
                'tokens' => ['attribute', 'break', 'case', 'continue', 'curly_brace_block', 'default', 'extra', 'parenthesis_brace_block', 'return', 'square_brace_block', 'switch', 'throw', 'use'],
            ],
            OperatorLinebreakFixer::class => [ // PhpCsFixer
                'only_booleans' => true,
            ],
            PhpdocOrderFixer::class => [ // Symfony
                'order' => ['param', 'return', 'throws'],
            ],
            PhpdocTagTypeFixer::class => [ // Symfony
                'tags' => ['inheritDoc' => 'inline'],
            ],
            PhpdocTypesOrderFixer::class => [
                'null_adjustment' => 'always_first',
            ],
            TrailingCommaInMultilineFixer::class => [
                'after_heredoc' => true,
                'elements' => ['arguments', 'arrays', 'match', 'parameters'],
            ],
        ]);

        $ecsConfig->skip([
            NotOperatorWithSuccessorSpaceFixer::class,
            MethodChainingNewlineFixer::class,
            ArrayListItemNewlineFixer::class,
            ArrayOpenerAndCloserNewlineFixer::class,
            StandaloneLineInMultilineArrayFixer::class,
            AssignmentInConditionSniff::class, // @phpstan-ignore-line
        ]);

        $ecsConfig->cacheDirectory('./.cache/ecs');
    }

    /**
     * @internal
     */
    public static function useRisky(ECSConfig $ecsConfig): void
    {
        $ecsConfig->rules([
            ArrayPushFixer::class, // Symfony
            CombineNestedDirnameFixer::class, // Symfony, PHP70Migration
            CommentToPhpdocFixer::class, // PhpCsFixer
            DateTimeImmutableFixer::class,
            DeclareStrictTypesFixer::class, // PHP70Migration
            DirConstantFixer::class, // Symfony
            EregToPregFixer::class, // Symfony
            ErrorSuppressionFixer::class, // Symfony
            FopenFlagOrderFixer::class, // Symfony
            FunctionToConstantFixer::class, // Symfony
            GetClassToClassKeywordFixer::class, // PHP80Migration
            ImplodeCallFixer::class, // Symfony, PHP74Migration
            IsNullFixer::class, // Symfony
            LogicalOperatorsFixer::class, // Symfony
            ModernizeStrposFixer::class, // PHP80Migration
            ModernizeTypesCastingFixer::class, // Symfony
            NativeConstantInvocationFixer::class, // PhpCsFixer, Symfony
            NoAliasFunctionsFixer::class, // PhpCsFixer, Symfony, PHP80Migration, PHP74Migration
            NoHomoglyphNamesFixer::class, // Symfony
            NoPhp4ConstructorFixer::class, // Symfony, PHP80Migration
            NoTrailingWhitespaceInStringFixer::class, // PSR12
            NoUnneededFinalMethodFixer::class, // Symfony
            NoUnreachableDefaultArgumentValueFixer::class, // PhpCsFixer, Symfony, PHP80Migration, PSR12
            NoUnsetOnPropertyFixer::class, // PhpCsFixer
            NoUselessSprintfFixer::class, // Symfony
            NonPrintableCharacterFixer::class, // Symfony, PHP70Migration
            OrderedTraitsFixer::class, // Symfony
            PhpUnitConstructFixer::class, // Symfony
            PhpUnitMockShortWillReturnFixer::class, // Symfony
            PhpUnitSetUpTearDownVisibilityFixer::class, // Symfony
            PhpUnitStrictFixer::class, // PHpCsFixer
            PhpUnitTestAnnotationFixer::class, // Symfony
            PowToExponentiationFixer::class, // PHP56Migration
            PsrAutoloadingFixer::class, // Symfony
            SelfAccessorFixer::class, // Symfony
            SetTypeToCastFixer::class, // Symfony
            StrictComparisonFixer::class, // PhpCsFixer
            StrictParamFixer::class, // PhpCsFixer
            StringLengthToEmptyFixer::class, // Symfony
            StringLineEndingFixer::class, // Symfony
            TernaryToElvisOperatorFixer::class, // Symfony
            UseArrowFunctionsFixer::class, // PHP74Migration
            VoidReturnFixer::class, // PHP71Migration
        ]);

        $ecsConfig->rulesWithConfiguration([
            // risky
            FopenFlagsFixer::class => [ // Symfony
                'b_mode' => false,
            ],
            NativeFunctionInvocationFixer::class => [ // Symfony
                'include' => ['@compiler_optimized'],
                'scope' => 'namespaced',
                'strict' => true,
            ],
            PhpUnitDedicateAssertFixer::class => [ // PHPUnit56Migration
                'target' => '5.6',
            ],
            PhpUnitDedicateAssertInternalTypeFixer::class => [ // PHPUnit75Migration
                'target' => '7.5',
            ],
            PhpUnitExpectationFixer::class => [ // PHPUnit84Migration
                'target' => '8.4',
            ],
            PhpUnitMockFixer::class => [ // PHPUnit55Migration
                'target' => '5.5',
            ],
            PhpUnitNamespacedFixer::class => [ // PHPUnit60Migration
                'target' => '6.0',
            ],
            PhpUnitNoExpectationAnnotationFixer::class => [ // PHPUnit43Migration
                'target' => '4.3',
            ],
            RandomApiMigrationFixer::class => [ // PHP70Migration
                'replacements' => ['mt_rand' => 'random_int', 'rand' => 'random_int'],
            ],
        ]);

        $ecsConfig->skip([
            NotOperatorWithSuccessorSpaceFixer::class,
            MethodChainingNewlineFixer::class,
            ArrayListItemNewlineFixer::class,
            ArrayOpenerAndCloserNewlineFixer::class,
            StandaloneLineInMultilineArrayFixer::class,
            AssignmentInConditionSniff::class, // @phpstan-ignore-line
        ]);

        $ecsConfig->cacheDirectory('./.cache/ecs');
    }
}
