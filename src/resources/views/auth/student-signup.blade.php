<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>さくるん - 新規アカウント作成</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
        .header {
            background-color: #ceafaf;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .header-icon {
            width: 40px;
            height: 40px;
            background-color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }
        .header-title {
            color: white;
            font-size: 24px;
            font-weight: bold;
        }
        .signup-container {
            padding: 40px 20px;
            max-width: 400px;
            margin: 0 auto;
        }
        .form-section {
            margin-bottom: 30px;
        }
        .form-section h3 {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-input {
            width: 100%;
            padding: 15px;
            border: 2px solid #ceafaf;
            border-radius: 25px;
            font-size: 16px;
            box-sizing: border-box;
            background-color: #f9f9f9;
        }
        .form-input:focus {
            outline: none;
            border-color: #bf9e9e;
            background-color: white;
        }
        .year-selection {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }
        .year-box {
            width: 60px;
            height: 60px;
            border: 2px solid #ceafaf;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            color: #333;
            background-color: #f9f9f9;
        }
        .year-label {
            font-size: 18px;
            color: #333;
        }
        .password-note {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
            text-align: center;
        }
        .signup-button {
            width: 100%;
            padding: 15px;
            background-color: #ceafaf;
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 30px;
        }
        .signup-button:hover {
            background-color: #bf9e9e;
        }
        .divider {
            height: 2px;
            background-color: #ddd;
            margin: 40px 0;
        }
        .login-section {
            text-align: center;
        }
        .login-section h4 {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }
        .login-button {
            width: 100%;
            padding: 15px;
            background-color: #ceafaf;
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            box-sizing: border-box;
        }
        .login-button:hover {
            background-color: #bf9e9e;
        }
        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
            text-align: center;
        }
        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-icon">🌸</div>
        <div class="header-title">さくるん</div>
    </div>

    <div class="signup-container">
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('student.signup') }}">
            @csrf
            <div class="form-section">
                <h3>名前</h3>
                <div class="form-group">
                    <input type="text" name="username" value="{{ old('username') }}" class="form-input" placeholder="松岡 龍之介" required>
                </div>
            </div>

            <div class="form-section">
                <h3>学年</h3>
                <div class="year-selection">
                    <div class="year-box">{{ old('year', '1') }}</div>
                    <div class="year-label">年生</div>
                    <input type="hidden" name="year" value="{{ old('year', '1') }}">
                </div>
            </div>

            <div class="form-section">
                <h3>パスワード</h3>
                <div class="password-note">※英数記号を含めた、8文字以上で入力してください</div>
                <div class="form-group">
                    <input type="password" name="password" class="form-input" placeholder="••••••" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password_confirmation" class="form-input" placeholder="パスワード再入力" required>
                </div>
            </div>

            <button type="submit" class="signup-button">登録</button>
        </form>

        <div class="divider"></div>

        <div class="login-section">
            <h4>既にアカウントをお持ちの場合</h4>
            <a href="{{ route('student.login') }}" class="login-button">ログイン画面へ</a>
        </div>
    </div>

    @error('username')
        <div class="error-message">{{ $message }}</div>
    @enderror
    @error('year')
        <div class="error-message">{{ $message }}</div>
    @enderror
    @error('password')
        <div class="error-message">{{ $message }}</div>
    @enderror
    @error('password_confirmation')
        <div class="error-message">{{ $message }}</div>
    @enderror

    <script>
        // 学年選択の機能を追加（必要に応じて）
        document.addEventListener('DOMContentLoaded', function() {
            const yearBox = document.querySelector('.year-box');
            const yearInput = document.querySelector('input[name="year"]');

            yearBox.addEventListener('click', function() {
                const currentYear = parseInt(yearInput.value);
                const nextYear = currentYear >= 3 ? 1 : currentYear + 1;
                yearBox.textContent = nextYear;
                yearInput.value = nextYear;
            });
        });
    </script>
</body>
</html>
