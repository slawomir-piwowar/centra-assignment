<?php
declare(strict_types=1);

use Rector\CodeQuality\Rector\BooleanNot\ReplaceMultipleBooleanNotRector;
use Rector\CodingStyle\Rector\Class_\AddArrayDefaultToArrayPropertyRector;
use Rector\CodingStyle\Rector\ClassConst\VarConstantCommentRector;
use Rector\CodingStyle\Rector\ClassMethod\UnSpreadOperatorRector;
use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Rector\CodingStyle\Rector\String_\SymplifyQuoteEscapeRector;
use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector;
use Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector;
use Rector\Naming\Rector\ClassMethod\RenameVariableToMatchNewTypeRector;
use Rector\Privatization\Rector\Class_\FinalizeClassesWithoutChildrenRector;
use Rector\Privatization\Rector\Class_\RepeatedLiteralToClassConstantRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\TypeDeclaration\Rector\ClassMethod\AddArrayParamDocTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddArrayReturnDocTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ArrayShapeFromConstantArrayReturnRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [
        __DIR__ . '/src'
    ]);
    $parameters->set(Option::PHP_VERSION_FEATURES, PhpVersion::PHP_74);

    $containerConfigurator->import(LevelSetList::UP_TO_PHP_74);
    $containerConfigurator->import(SetList::CODE_QUALITY);
    $containerConfigurator->import(SetList::CODING_STYLE);
    $containerConfigurator->import(SetList::DEAD_CODE);
    $containerConfigurator->import(SetList::PHP_74);
    $containerConfigurator->import(SetList::NAMING);
    $containerConfigurator->import(SetList::PRIVATIZATION);
    $containerConfigurator->import(SetList::PSR_4);
    $containerConfigurator->import(SetList::TYPE_DECLARATION);
    $containerConfigurator->import(SetList::TYPE_DECLARATION_STRICT);
    $containerConfigurator->import(SetList::UNWRAP_COMPAT);
    $containerConfigurator->import(SetList::EARLY_RETURN);
    $containerConfigurator->import(SetList::EARLY_RETURN);

    $containerConfigurator->services()->remove(UnSpreadOperatorRector::class);
    $containerConfigurator->services()->remove(VarConstantCommentRector::class);
    $containerConfigurator->services()->remove(SymplifyQuoteEscapeRector::class);
    $containerConfigurator->services()->remove(NewlineAfterStatementRector::class);
    $containerConfigurator->services()->remove(AddArrayDefaultToArrayPropertyRector::class);
    $containerConfigurator->services()->remove(ReplaceMultipleBooleanNotRector::class);
    $containerConfigurator->services()->remove(FinalizeClassesWithoutChildrenRector::class);
    $containerConfigurator->services()->remove(AddArrayReturnDocTypeRector::class);
    $containerConfigurator->services()->remove(RenameVariableToMatchMethodCallReturnTypeRector::class);
    $containerConfigurator->services()->remove(RenameVariableToMatchNewTypeRector::class);
    $containerConfigurator->services()->remove(RepeatedLiteralToClassConstantRector::class);
    $containerConfigurator->services()->remove(ArrayShapeFromConstantArrayReturnRector::class);
    $containerConfigurator->services()->remove(RenameParamToMatchTypeRector::class);
    $containerConfigurator->services()->remove(AddArrayParamDocTypeRector::class);
};
