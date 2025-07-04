<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>さくるん - 講師ログイン</title>
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
        .login-container {
            padding: 40px 20px;
            max-width: 400px;
            margin: 0 auto;
        }
        .login-subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 16px;
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
            margin-top: 30px;
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
        .info-section {
            margin-top: 40px;
            padding: 20px;
            background-color: #e8f4f8;
            border-radius: 10px;
            text-align: center;
        }
        .info-section h4 {
            color: #333;
            margin-bottom: 10px;
        }
        .info-section p {
            color: #666;
            font-size: 14px;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-icon">🌸</div>
        <div class="header-title">さくるん</div>
    </div>

    <div class="login-container">
        <div class="login-subtitle">講師専用ログイン</div>

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('teacher.login') }}">
            @csrf
            <div class="form-section">
                <h3>ユーザー名</h3>
                <div class="form-group">
                    <input type="text" name="username" value="{{ old('username') }}" class="form-input" placeholder="講師ID" required>
                </div>
            </div>

            <div class="form-section">
                <h3>パスワード</h3>
                <div class="form-group">
                    <input type="password" name="password" class="form-input" placeholder="••••••" required>
                </div>
            </div>

            <button type="submit" class="login-button">ログイン</button>
        </form>

        <div class="info-section">
            <h4>講師の皆様へ</h4>
            <p>システム管理者から提供されたユーザー名とパスワードを使用してログインしてください。</p>
        </div>
    </div>

    @error('username')
        <div class="error-message">{{ $message }}</div>
    @enderror
    @error('password')
        <div class="error-message">{{ $message }}</div>
    @enderror
</body>
</html>
