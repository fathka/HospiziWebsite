<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pasien - HOSPIZI</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #ffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-container {
            display: flex;
            max-width: 1000px;
            width: 100%;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }
        
        .login-left {
            flex: 1;
            background: linear-gradient(135deg,  #1D3033 0%, #396066 20%, #A4DAD2 100%);
            padding: 60px 40px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .logo {
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 20px;
            color: white;
        }
        
        .login-left h2 {
            font-size: 28px;
            margin-bottom: 15px;
        }
        
        .login-left p {
            font-size: 16px;
            line-height: 1.6;
            opacity: 0.95;
        }
        
        .login-right {
            flex: 1;
            padding: 60px 50px;
        }
        
        .login-right h3 {
            font-size: 32px;
            color: #2C5F4F;
            margin-bottom: 10px;
        }
        
        .login-right p {
            color: #666;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            color: #2C5F4F;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .form-group input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #E0E0E0;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s;
            outline: none;
        }
        
        .form-group input:focus {
            border-color: linear-gradient(135deg, #F6D809 0%, #F9BE59 100%);
            box-shadow: 0 0 0 3px rgba(124, 185, 168, 0.1);
        }
        
        .form-group input.error {
            border-color: #E74C3C;
        }
        
        .error-message {
            color: #E74C3C;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }
        
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .alert-error {
            background-color: #FADBD8;
            color: #C0392B;
            border-left: 4px solid #E74C3C;
        }
        
        .alert-success {
            background-color: #D4EDDA;
            color: #155724;
            border-left: 4px solid #28A745;
        }
        
        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #F6D809 0%, #F9BE59 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(124, 185, 168, 0.3);
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(124, 185, 168, 0.4);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .login-footer {
            text-align: center;
            margin-top: 25px;
            color: #666;
            font-size: 14px;
        }
        
        .login-footer a {
            color: #7CB9A8;
            text-decoration: none;
            font-weight: 600;
        }
        
        .login-footer a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }
            
            .login-left {
                padding: 40px 30px;
            }
            
            .login-right {
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-left">
            <div class="logo">Hospizi</div>
            <h2>Welcome Back</h2>
            <p>Hospizi merupakan sistem pelayanan gizi untuk membantu ahli gizi dalam mengelola diet pasien serta memberikan akses informasi nutrisi kepada pasien rumah sakit.</p>
        </div>
        
        <div class="login-right">
            <h3>Sign In</h3>
            <p>Sign in to your account</p>
            
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
            
            <form action="<?= base_url('pasien/login') ?>" method="POST">
                <?= csrf_field() ?>
                
                <div class="form-group">
                    <label for="No Rekam Medis">NO. RM</label>
                    <input 
                        type="text" 
                        id="no_rm" 
                        name="no_rm" 
                        placeholder="Masukkan No. RM"
                        value="<?= old('no_rm') ?>"
                        class="<?= isset($errors['no_rm']) ? 'error' : '' ?>"
                        required
                    >
                    <?php if (isset($errors['no_rm'])): ?>
                        <span class="error-message"><?= $errors['no_rm'] ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="tanggal lahir">Tanggal Lahir</label>
                    <input 
                        type="date" 
                        id="tanggal_lahir" 
                        name="tanggal_lahir" 
                        placeholder="Masukkan tanggal lahir"
                        class="<?= isset($errors['tanggal_lahir']) ? 'error' : '' ?>"
                        required
                    >
                    <?php if (isset($errors['tanggal_lahir'])): ?>
                        <span class="error-message"><?= $errors['tanggal_lahir'] ?></span>
                    <?php endif; ?>
                </div>
                
                <button type="submit" class="btn-login">Sign In</button>
            </form>
            
            <div class="login-footer">
                <p>Ahli Gizi? <a href="<?= base_url('auth/login') ?>">Login sebagai Ahli Gizi</a></p>
            </div>
        </div>
    </div>
</body>
</html>