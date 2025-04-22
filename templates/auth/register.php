<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - DeepSeek Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .auth-container {
            max-width: 400px;
            margin: 5rem auto;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            background: white;
        }
        .btn-primary {
            background-color: #1a73e8;
            border-color: #1a73e8;
        }
    </style>
</head>
<body>
    <div class="container auth-container">
        <h2 class="text-center mb-4">Criar Conta</h2>
        <form id="register-form">
            <div class="mb-3">
                <label for="username" class="form-label">Nome de Usuário</label>
                <input type="text" class="form-control" id="username" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input type="password" class="form-control" id="password" required>
            </div>
            <div class="mb-3">
                <label for="confirm-password" class="form-label">Confirmar Senha</label>
                <input type="password" class="form-control" id="confirm-password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Registrar</button>
        </form>
        <div class="mt-3 text-center">
            <p>Já tem uma conta? <a href="/login">Faça login</a></p>
        </div>
        <div id="alert" class="mt-3"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#register-form').submit(function(e) {
                e.preventDefault();
                
                const username = $('#username').val();
                const email = $('#email').val();
                const password = $('#password').val();
                const confirmPassword = $('#confirm-password').val();
                
                if (password !== confirmPassword) {
                    showAlert('As senhas não coincidem!', 'danger');
                    return;
                }
                
                $.ajax({
                    url: '/api/auth/register',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ username, email, password }),
                    success: function(response) {
                        showAlert('Registro realizado com sucesso! Redirecionando...', 'success');
                        setTimeout(() => {
                            window.location.href = '/login';
                        }, 1500);
                    },
                    error: function(xhr) {
                        const error = xhr.responseJSON?.error || 'Erro desconhecido';
                        showAlert(error, 'danger');
                    }
                });
            });
            
            function showAlert(message, type) {
                const alert = $('#alert');
                alert.html(`
                    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);
            }
        });
    </script>
</body>
</html>