$(document).ready(function() {
    const chatMessages = $('#chat-messages');
    const messageInput = $('#message-input');
    const sendButton = $('#send-button');
    const fileInput = $('#file-input');
    const uploadButton = $('#upload-button');

    // Envio de mensagem de texto
    sendButton.click(async function() {
        const message = messageInput.val().trim();
        if (message) {
            await sendMessage(message);
            messageInput.val('');
        }
    });

    // Upload de imagem
    uploadButton.click(function() {
        fileInput.click();
    });

    fileInput.change(async function() {
        const file = this.files[0];
        if (file) {
            const formData = new FormData();
            formData.append('image', file);
            
            try {
                const response = await fetch('/upload.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                if (data.url) {
                    await sendMessage(data.url, 'image');
                }
            } catch (error) {
                console.error('Upload failed:', error);
            }
        }
    });

    async function sendMessage(content, type = 'text') {
        // Implementar AJAX para salvar mensagem e obter resposta
        // Atualizar interface do chat
    }

    // Atualização automática das mensagens
    function loadMessages() {
        $.ajax({
            url: '/api/messages',
            method: 'GET',
            success: function(messages) {
                chatMessages.empty();
                messages.forEach(msg => {
                    const messageElement = createMessageElement(msg);
                    chatMessages.append(messageElement);
                });
                chatMessages.scrollTop(chatMessages[0].scrollHeight);
            }
        });
    }

    function createMessageElement(msg) {
        const isBot = msg.is_bot;
        const bubbleClass = isBot ? 'bot-message' : 'user-message';
        const content = msg.type === 'image' 
            ? `<img src="${msg.content}" class="img-fluid" style="max-height: 200px;">`
            : msg.content;

        return $(`
            <div class="d-flex ${isBot ? '' : 'justify-content-end'} mb-3">
                <div class="message-bubble ${bubbleClass}">
                    ${content}
                    <div class="text-muted small mt-1">
                        ${new Date(msg.created_at).toLocaleTimeString()}
                    </div>
                </div>
            </div>
        `);
    }

    // Atualizar mensagens a cada 2 segundos
    setInterval(loadMessages, 2000);
    loadMessages();
});