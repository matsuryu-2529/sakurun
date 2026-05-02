# さくるん

> 受験期までに、自分で学習計画が立てられるようになる。

高校1,2年生向けの学習計画支援Webアプリです。  
**クライアント（塾講師）への課題ヒアリングから要件定義・設計・実装・運用までを一人称で担当**したオリジナルプロダクトです。

---

## 🎯 このREADMEで伝えたいこと

「与えられた仕様を実装した」ではなく、
**「現場の課題を自分で聞き出し、要件に落とし込み、形にした」** という開発プロセス全体を担当しました。

技術スタックだけでなく、以下のプロセスもご覧いただけると嬉しいです。

1. [課題のヒアリング](#1-課題のヒアリングクライアントとの対話)
2. [要求分析](#2-要求分析本当に解決すべきことの特定)
3. [要件定義](#3-要件定義機能優先度づけ)
4. [設計](#4-設計figma--er図--インフラ構成)
5. [実装](#5-実装技術スタック)
6. [継続的なフィードバック反映](#6-継続的なフィードバック反映)

---

## 1. 課題のヒアリング（クライアントとの対話）

ヒアリング相手は**現役の塾講師**。何度かの対話を通じて、以下の生の声を引き出しました。

> 「生徒は、提示された課題はやる。でも自分で計画を立てて実行することができない。
>  仮にできても、それを継続することができない。」

ここから、**「高校1,2年生が、高校3年生になるまでに自分で学習計画を立てられるようにする」** ことを本プロダクトのゴールに据えました。

詳細は [`documents/system-requirements/problem_statement.md`](documents/system-requirements/problem_statement.md) にまとめています。

### 既存サービスとの差別化ポイント

ヒアリングの過程で気付いた点：

- 学習計画を「記録する」サービスは既に多く存在する
- しかし、**「学習計画の立て方そのものをサポートする」** サービスは存在しない
- 紙の手書きでは続かない／講師側からは進捗が見えない

→ そこで「PDCAサイクルをアプリ上で回す」というアプローチを採用しました。

---

## 2. 要求分析（本当に解決すべきことの特定）

ヒアリング内容をそのまま機能に落とし込まず、一段抽象化して整理しました。

| 項目 | 内容 |
| --- | --- |
| **本当に解決したい課題** | 高校1,2年生が、自分で学習計画を立てられないこと |
| **本当に実現したいこと** | 高校3年生までに、生徒が自分で学習計画を立てられている状態 |

詳細は [`documents/system-requirements/requirements_analysis.md`](documents/system-requirements/requirements_analysis.md) にまとめています。

---

## 3. 要件定義（機能・優先度づけ）

クライアントと**「やらないこと」を最初にすり合わせ**、スコープの肥大化を防ぎました。
機能には優先度（P0：必須 / P1：実装想定 / P2：余力があれば）を付け、段階的にリリースできる粒度に分解しています。

### 主な機能要件

| カテゴリ | 機能 | 優先度 |
| --- | --- | --- |
| ユーザー管理 | 登録・ログイン・ログアウト・パスワード変更 | P0 |
| 学習計画（Plan） | 目標・科目・タスク・期限の登録／編集／削除 | P0 |
| 学習計画（Plan） | テンプレートによる計画作成ガイド | P1 |
| 学習実績（Do） | 日々の学習時間・進捗率の入力 | P0 |
| 学習結果（Check） | 計画に対する進捗状況の可視化 | P0 |
| 学習結果（Check） | 過去実績との比較グラフ | P1 |
| 改善策（Act） | 改善策の手動入力 | P0 |
| 改善策（Act） | 結果分析に基づく自動提案 | P1 |
| 講師用 | 担当生徒の学習計画・実績・改善策の閲覧 | P0 |
| 講師用 | 担当生徒の検索・フィルタリング | P1 |

### 非機能要件（抜粋）

- **ユーザビリティ**：生徒用画面はスマホ、講師用画面はPCを主想定としたレスポンシブUI
- **拡張性**：モジュール化された設計で機能追加・変更を容易に
- **セキュリティ**：CSRF対策／SQLインジェクション対策／XSS対策／SSL-TLS／適切な認証・認可
- **運用保守性**：mainブランチへのマージで自動デプロイ、Push時に静的解析

詳細は [`documents/system-requirements/requirements_specification.md`](documents/system-requirements/requirements_specification.md) にまとめています。

---

## 4. 設計（Figma / ER図 / インフラ構成）

### 画面設計

[Figmaで作成した設計書](https://www.figma.com/file/yFUOUXFz7tGcQvyyVfqq6g/%E3%82%AA%E3%83%AA%E3%83%97%E3%83%AD%E8%A8%AD%E8%A8%88?type=design&node-id=1669%3A162202&mode=design&t=UtoFa6mK6hAivAg0-1)を、クライアントにレビューしてもらいながら詰めました。

#### PDCA画面（生徒用）／ 講師用画面
<img width="287" alt="PDCA画面" src="https://github.com/user-attachments/assets/fce458fd-919f-423b-b636-b2bfba1da7b7">
<img width="959" alt="講師用画面" src="https://github.com/user-attachments/assets/6222194a-4977-4513-8b3f-717e96299dd0">

### インフラ構成図
<img width="434" alt="インフラ構成図" src="https://github.com/user-attachments/assets/d4024a08-b907-4f8e-932c-99265b713601">

### ER図
<img width="842" alt="ER図" src="https://github.com/user-attachments/assets/e161750c-e932-4118-866a-cf21d5e82ba7">

---

## 5. 実装（技術スタック）

| レイヤ | 採用技術 |
| --- | --- |
| 言語 | PHP 8.1+ |
| フレームワーク | Laravel 10 |
| フロント | Laravel Livewire 3 / Alpine.js / Tailwind CSS / Vite |
| 認証 | Laravel Breeze + Sanctum |
| DB | MySQL |
| 実行環境 | Docker / Docker Compose（app / web / db の3コンテナ構成）|
| テスト | PHPUnit |
| 静的解析・整形 | Laravel Pint |

### なぜこの構成か

- **Laravel + Livewire**：少人数向けプロダクトのため、SPAを別途構築せずサーバーサイドで完結させ、開発速度を優先
- **Docker**：環境差異を吸収し、クライアント側でも同じ手順で再現できるように
- **Tailwind CSS**：シンプルで直感的なUIを短いサイクルで反映できるように

ローカル環境のセットアップ手順は [`DOCKER_SETUP.md`](DOCKER_SETUP.md) を参照してください。

---

## 6. 継続的なフィードバック反映

リリース後もクライアントから定期的にフィードバックを受け、改善を続けています。

| クライアントの声 | 対応 |
| --- | --- |
| 「計画が一目でわかりにくい」 | カレンダー画面の実装を計画中（P2機能の昇格） |
| 「ログアウト操作を間違えやすい」 | ログアウト前に確認ダイアログを表示するよう改修済み |
| 「PDCAの入力がもっと速くしたい」 | ドロップダウン選択・自動補完を導入し、入力工数を削減 |

ヒアリング → 要件 → 設計 → 実装 → フィードバック というサイクルを、**プロダクト自身のテーマであるPDCAと同じ形で回す** ことを意識しています。

---

## 使い方

1. 生徒が学習計画（Plan）を立てる
2. 日々の学習実績（Do）を記録する
3. 計画に対する結果（Check）を確認する
4. 改善策（Act）を入力し、次の計画に反映する
5. 講師は担当生徒の進捗を確認し、フィードバックを行う

---

## ドキュメント一覧

| ファイル | 内容 |
| --- | --- |
| [`documents/system-requirements/problem_statement.md`](documents/system-requirements/problem_statement.md) | 課題定義（背景・ゴール・やらないこと） |
| [`documents/system-requirements/requirements_analysis.md`](documents/system-requirements/requirements_analysis.md) | 要求分析 |
| [`documents/system-requirements/requirements_specification.md`](documents/system-requirements/requirements_specification.md) | 要件定義（機能要件・非機能要件） |
| [`documents/system-design/design.md`](documents/system-design/design.md) | 設計（Figma リンク） |
| [`documents/research-resources.md`](documents/research-resources.md) | 参考資料 |
| [`DOCKER_SETUP.md`](DOCKER_SETUP.md) | ローカル開発環境の構築手順 |

---

## 補足：過去コミットに含まれる `.env.bak` の取り扱いについて

リファクタリング作業中に、`src/.env.bak` が `.gitignore` の漏れにより過去のコミット（`9680751`、`7ab399b`）で追跡されていたことが判明しました。現在は `git rm` 済み・`.gitignore` も修正済みです。

このファイルに含まれていた `APP_KEY` の値は以下の通りで、**`base64:...=` が2つ連結された形式不正な値**でした。

```
APP_KEY=base64:ZTSQSECno3Kqhpg+kpZOmE/Y7HZJmCiBo5EznfDHLmg=base64:8fUDp47iqMuBRBflJy9RkhXp/0QYvuGZgUOT+YyiRtc=
```

このキーは Laravel が parse できず、暗号化／復号に利用不可能なため、**第三者がこの値から本アプリのセッション・暗号化カラム・署名付きURLを復号することはできません**。よって**実害なし**と判定しました。

なお、現在 `src/.env` で運用しているキーは履歴のものとは別物で、`.gitignore` により追跡されていません。

将来的に有効な機密値が誤って履歴へ混入した場合は、`git filter-repo` 等での履歴書き換え＋`php artisan key:generate` によるキーローテーションを実施する方針です。
