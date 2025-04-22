<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DeepSeek Chat</title>
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
        <h2 class="text-center mb-4">Login</h2>
        <form id="login-form">
            <div class="mb-3">
                <label for="username" class="form-label">Nome de Usuário</label>
                <input type="text" class="form-control" id="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input type="password" class="form-control" id="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>
        <div class="mt-3 text-center">
            <p>Não tem uma conta? <a href="/register">Registre-se</a></p>
        </div>
        <div id="alert" class="mt-3"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#login-form').submit(function(e) {
                e.preventDefault();
                
                const username = $('#username').val();
                const password = $('#password').val();
                
                $.ajax({
                    url: '/api/auth/login',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ username, password }),
                    success: function(response) {
                        // Armazena o token JWT no localStorage
                        localStorage.setItem('authToken', response.token);
                        localStorage.setItem('user', JSON.stringify(response.user));
                        
                        // Redireciona para o chat
                        window.location.href = '/chat';
                    },
                    error: function(xhr) {
                        const error = xhr.responseJSON?.error || 'Credenciais inválidas';
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