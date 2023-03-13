# 🛡️ static-analysis-kit
[![CircleCI](https://dl.circleci.com/status-badge/img/gh/quartetcom/static-analysis-kit/tree/8.1.svg?style=shield&circle-token=e664f9de38860a84eb9e96c47768c41682471683)](https://dl.circleci.com/status-badge/redirect/gh/quartetcom/static-analysis-kit/tree/master)
[![GitHub Actions](https://github.com/quartetcom/static-analysis-kit/actions/workflows/php.yml/badge.svg)](https://github.com/quartetcom/static-analysis-kit/actions/workflows/php.yml)

Strict and modern kit to optimise the codebase defensively.

## 📦 Installation

```shell
composer require --dev quartetcom/static-analysis-kit:~8.2
./vendor/bin/static-analysis-kit install
```

> **Note**  
> Replace `~8.2` with the PHP version you want to use.
> Refer [Versioning](#-versioning) for details.

The project will be automatically optimised by answering the questions.

## 🔖 Versioning

Version of this package follows the PHP version that which is supported.
For example, if you want to use in a PHP 8.2 project, use in range of `~8.2`．

## ✅ Development Flow

1. Change code
2. Run "Reformat Code" (%L) in PhpStorm
3. Confirm there are no errors (will be highlighted on the scroll bar)
4. Run `composer analyse`
5. Problems about formatting can be resolved by `composer fix`
6. The remaining problems should caused by the code, so fix them manually
   (You can run `composer fix:risky` or `composer fix:rector` to resolve them, but this causes code breaks; be careful of the diff after run)
7. Commit after confirmed there are no errors by running `composer analyse`
