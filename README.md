# 🛡️ static-analysis-kit
[![CircleCI](https://dl.circleci.com/status-badge/img/gh/quartetcom/static-analysis-kit/tree/master.svg?style=shield&circle-token=e664f9de38860a84eb9e96c47768c41682471683)](https://dl.circleci.com/status-badge/redirect/gh/quartetcom/static-analysis-kit/tree/master)
[![GitHub Actions](https://github.com/quartetcom/static-analysis-kit/actions/workflows/php.yml/badge.svg)](https://github.com/quartetcom/static-analysis-kit/actions/workflows/php.yml)

コードベースを防衛的に最適化するための堅牢でモダンなキット．

## 📦 インストール

```shell
composer require --dev quartetcom/static-analysis-kit
./vendor/bin/static-analysis-kit install
```

質問に従うと自動的にプロジェクトが最適な設定になります．

## ✅ 開発フロー

1. コードを変更する
2. PhpStorm で Reformat Code を行う (⌘L)
3. 波線のついたエラーがないことを確認する (スクロールバーのところでハイライトされる)
4. `composer analyse` を実行する
5. フォーマットに関する問題は `composer fix` で解決できる
6. それでも治らない問題はコードが悪いのでエラーに沿って解決する
   (`composer fix:risky` や `composer fix:rector` で解決を試みることもできるが，これは既存のコードのビヘイビアを破壊する可能性が あるので差分をよく確認すること)
7. `composer analyse` のエラーがないことを確認してコミットする
