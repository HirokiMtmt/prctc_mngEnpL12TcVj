# 社員管理システム

Laravel 12、Vue.js、Tailwind CSSを使用した社員管理システムです。

## 開発環境

- PHP 8.2以上
- Node.js 18以上
- Composer 2.x
- MySQL 8.0

## セットアップ

```bash
# リポジトリのクローン
git clone https://github.com/HirokiMtmt/prctc_mngEnpL12TcVj.git
cd prctc_mngEnpL12TcVj

# 依存関係のインストール
composer install
npm install

# 環境設定
cp .env.example .env
php artisan key:generate

# データベースのマイグレーション
php artisan migrate

# 開発サーバーの起動
php artisan serve     # Laravel サーバー
npm run dev          # Vite 開発サーバー
```

## ブランチ戦略

このプロジェクトでは以下のブランチ戦略を採用しています：

### メインブランチ

- `master`: 本番環境用のメインブランチ
  - 直接コミットは禁止
  - developブランチからのマージのみ許可
- `develop`: 開発用のメインブランチ
  - 直接コミットは禁止
  - feature、hotfixブランチからのマージのみ許可

### 作業用ブランチ

- `feature/*`: 新機能開発用
  - 例: `feature/add-user-authentication`
  - developブランチから分岐
  - 完了後はdevelopブランチにマージ
- `hotfix/*`: バグ修正用
  - 例: `hotfix/fix-login-error`
  - developブランチから分岐
  - 完了後はdevelopブランチにマージ

## コミットメッセージのルール

以下のプレフィックスを使用してコミットの種類を明確にします：

- `feat:` 新機能の追加
- `fix:` バグ修正
- `docs:` ドキュメントのみの変更
- `style:` コードの意味に影響を与えない変更（空白、フォーマット、セミコロンの追加など）
- `refactor:` バグ修正や機能追加ではないコードの変更
- `test:` テストの追加・修正
- `chore:` ビルドプロセスやツールの変更、ライブラリの更新など

例：
```
feat: ユーザー認証機能の追加
fix: ログインフォームのバリデーションエラーを修正
docs: READMEのセットアップ手順を更新
```

## プルリクエストのルール

1. レビュー必須
2. 以下のテンプレートに従って記述
   - 変更内容の概要
   - 変更理由
   - 確認項目
   - 関連するIssue

## コーディング規約

- PSR-12に準拠
- ESLintの設定に従う
- Prettier/PHP-CSによるコードフォーマット必須

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
