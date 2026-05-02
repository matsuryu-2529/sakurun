<div class="account-container">
    @if (session()->has('message'))
        <div class="success-message">{{ session('message') }}</div>
    @endif

    @include('livewire.students.account.items')
    @include('livewire.students.account.name-modal')
    @include('livewire.students.account.year-modal')
    @include('livewire.students.account.password-modal')

    <style>
    .account-container {
        padding: 20px;
        max-width: 400px;
        margin: 0 auto;
        min-height: calc(100vh - 120px);
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .success-message {
        background-color: #d4edda;
        color: #155724;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
        text-align: center;
    }

    .account-items {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .account-item {
        background-color: white;
        border: 2px solid #ddd;
        border-radius: 15px;
        padding: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .account-item:hover {
        background-color: #f8f9fa;
        border-color: #ceafaf;
    }

    .account-item-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
    }

    .account-item-title {
        font-size: 18px;
        font-weight: bold;
        color: #333;
    }

    .account-item-icon {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .modal-content {
        background-color: white;
        padding: 30px;
        border-radius: 10px;
        width: 90%;
        max-width: 400px;
    }

    .modal-content h3 {
        margin-bottom: 20px;
        text-align: center;
        color: #333;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #333;
    }

    .form-input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
    }

    .form-input:focus {
        outline: none;
        border-color: #ceafaf;
    }

    .error {
        color: #dc3545;
        font-size: 14px;
        margin-top: 5px;
        display: block;
    }

    .modal-buttons {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-top: 20px;
    }

    .btn-cancel {
        padding: 10px 20px;
        background-color: #6c757d;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-cancel:hover {
        background-color: #5a6268;
    }

    .btn-submit {
        padding: 10px 20px;
        background-color: #ceafaf;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-submit:hover {
        background-color: #bf9e9e;
    }

    .account-item:last-child {
        border-color: #dc3545;
        background-color: #fff5f5;
    }

    .account-item:last-child:hover {
        background-color: #ffe6e6;
        border-color: #dc3545;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(220, 53, 69, 0.2);
    }

    .account-item:last-child .account-item-title {
        color: #dc3545;
    }

    .account-item:last-child .account-item-icon svg {
        transition: transform 0.3s ease;
    }

    .account-item:last-child:hover .account-item-icon svg {
        transform: scale(1.1);
    }
    </style>
</div>
