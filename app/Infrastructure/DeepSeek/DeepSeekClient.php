<?php 

namespace App\Infrastructure\DeepSeek;

use Dotenv\Dotenv;

class DeepseekClient
{

    private string $apiKey;
    private string $baseUrl = 'https://api.deepseek.com/v1';

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__, '../../../');
        $dotenv->load();
        $this->apiKey = $_ENV['DEEPSEEK_API_KEY'];
    }

    public function sendMessage(string $prompt): string 
    {
        $ch = curl_init("{$this->baseUrl}/chat/completions");

        $payload = json_encode([
            'model' => 'deepseek-chat',
            'messages' => [
                ['role' => 'user', 'content' => $prompt]
            ]
        ]);

        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->apiKey
            ],
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_RETURNTRANSFER => true,
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);
        
        return $data['choices'][0]['message']['content'] ?? 'Desculpe, ocorreu um erro';
    }
}