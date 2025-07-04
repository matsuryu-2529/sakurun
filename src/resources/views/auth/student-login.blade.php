<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>さくるん - ログイン</title>
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
        .divider {
            height: 2px;
            background-color: #ddd;
            margin: 40px 0;
        }
        .signup-section {
            text-align: center;
        }
        .signup-section h4 {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
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
            text-decoration: none;
            display: inline-block;
            box-sizing: border-box;
        }
        .signup-button:hover {
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
    </style>
</head>
<body>
    <div class="header">
        <div class="header-icon">🌸</div>
        <div class="header-title">さくるん</div>
    </div>

    <div class="login-container">
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('student.login') }}">
            @csrf
            <div class="form-section">
                <h3>名前</h3>
                <div class="form-group">
                    <input type="text" name="username" value="{{ old('username') }}" class="form-input" placeholder="松岡 龍之介" required>
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

        <div class="divider"></div>

        <div class="signup-section">
            <h4>アカウントをお持ちでない場合</h4>
            <a href="{{ route('student.signup') }}" class="signup-button">新規アカウント作成</a>
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
