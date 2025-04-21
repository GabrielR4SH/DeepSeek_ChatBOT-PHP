<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DeepSeek Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --deepseek-blue: #1a73e8;
            --background-light: #f8f9fa;
        }
        
        body {
            background-color: var(--background-light);
        }
        
        .chat-container {
            max-width: 800px;
            margin: 2rem auto;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        
        .message-bubble {
            max-width: 70%;
            padding: 1rem;
            margin: 0.5rem;
            border-radius: 1.5rem;
        }
        
        .user-message {
            background-color: var(--deepseek-blue);
            color: white;
            margin-left: auto;
        }
        
        .bot-message {
            background-color: #e9ecef;
            margin-right: auto;
        }
    </style>
</head>
<body>
    <div class="container chat-container">
        <div class="card">
            <div class="card-header bg-primary text-white">
                DeepSeek Chat
            </div>
            <div class="card-body" id="chat-messages" style="height: 60vh; overflow-y: auto;">
                <!-- Mensagens serão carregadas aqui via AJAX -->
            </div>
            <div class="card-footer">
                <form id="chat-form">
                    <div class="input-group">
                        <input type="text" class="form-control" id="message-input" 
                               placeholder="Digite sua mensagem..." autocomplete="off">
                        <button type="button" class="btn btn-primary" id="send-button">
                            Enviar
                        </button>
                    </div>
                    <div class="mt-2">
                        <input type="file" id="file-input" class="form-control" 
                               accept="image/*" style="display: none;">
                        <button type="button" class="btn btn-outline-secondary" 
                                id="upload-button">
                            Enviar Imagem
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="assets/js/chat.js"></script>
</body>
</html>