# Docker 環境セットアップガイド

## 🚀 概要

このプロジェクトでは、Laravel 公式推奨のベストプラクティスに基づいた Docker 環境を構築しています。

## 🔧 自動権限設定

### 実装された機能

- **自動権限設定**: コンテナ起動時に自動的に Laravel 推奨の権限が設定されます
- **ディレクトリ作成**: 必要な Laravel ディレクトリが存在しない場合は自動作成されます
- **永続化**: Docker 再起動後も適切な権限が維持されます

### 設定される権限

```bash
# 以下のディレクトリが自動的に適切な権限で設定されます
storage/                    # 775, www-data:www-data
bootstrap/cache/           # 775, www-data:www-data
storage/logs/              # 775, www-data:www-data
storage/framework/sessions/ # 775, www-data:www-data
storage/framework/views/   # 775, www-data:www-data
storage/framework/cache/   # 775, www-data:www-data
```

## 📋 使用方法

### 初回セットアップ

```bash
# 1. 環境変数ファイルの設定
cp src/.env.example src/.env  # 必要に応じて

# 2. Docker環境の構築と起動
docker compose build --no-cache
docker compose up -d

# 3. Composer依存関係のインストール
docker compose exec app composer install

# 4. Laravel設定
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate
```

### 通常の起動

```bash
# コンテナの起動
docker compose up -d

# コンテナの停止
docker compose down
```

### 権限問題のトラブルシューティング

権限エラーが発生した場合、以下のコマンドで手動修正できます：

```bash
# 手動権限修正（通常は不要）
docker compose exec app chown -R www-data:www-data storage bootstrap/cache
docker compose exec app chmod -R 775 storage bootstrap/cache
```

## 🔍 ログ確認

entrypoint スクリプトの実行ログを確認：

```bash
docker compose logs app
```

成功時には以下のようなログが表示されます：

```
🚀 Starting Laravel Docker container...
🔧 Setting up Laravel permissions...
📁 Setting permissions for storage directory...
✅ Storage permissions set successfully
📁 Setting permissions for bootstrap/cache directory...
✅ Bootstrap cache permissions set successfully
🎯 Running Laravel optimizations...
✅ Laravel directory structure verified
🎉 Laravel container initialization completed successfully!
```

## 📁 ファイル構成

```
docker/
├── app/
│   ├── Dockerfile      # PHP-FPM + 自動権限設定
│   ├── entrypoint.sh   # Laravel権限設定スクリプト
│   └── php.ini         # PHP設定
├── web/
│   └── Dockerfile      # Nginx設定
└── db/
    └── Dockerfile      # MySQL設定

docker-compose.yml      # Docker Compose設定
```

## 🛡️ セキュリティ

- entrypoint スクリプトは root で実行され、適切な権限設定後に php-fpm プロセスを起動
- Laravel 推奨の 775 権限で www-data ユーザーがファイル操作可能
- 本番環境では追加のセキュリティ設定を検討してください

## 🔄 更新手順

Docker 設定を更新した場合：

```bash
# イメージの再ビルド
docker compose build --no-cache

# コンテナの再作成
docker compose up -d --force-recreate
```
