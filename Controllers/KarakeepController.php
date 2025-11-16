<?php

class FreshExtension_Karakeep_Controller extends Minz_ActionController
{
    public function addToKarakeepAction()
    {
        $this->view->_layout(false);
        header('Content-Type: application/json');

        // Get configuration
        $karakeep_url = FreshRSS_Context::$user_conf->karakeep_url ?? '';
        $api_token = FreshRSS_Context::$user_conf->karakeep_api_token ?? '';

        // Validate configuration
        if (empty($karakeep_url) || empty($api_token)) {
            echo json_encode([
                'success' => false,
                'error' => 'Missing Karakeep configuration. Please configure the extension first.'
            ]);
            return;
        }

        // Get entry
        $entry_id = Minz_Request::param('id');
        $entry_dao = FreshRSS_Factory::createEntryDao();
        $entry = $entry_dao->searchById($entry_id);

        if ($entry === null) {
            echo json_encode(['success' => false, 'error' => 'Article not found']);
            return;
        }

        $article_url = $entry->link();
        $article_title = $entry->title();

        try {
            // Create bookmark in Karakeep
            $karakeep_response = $this->createKarakeepBookmark(
                $karakeep_url,
                $api_token,
                $article_url,
                $article_title
            );

            // Mark entry as read
            $entry_dao->markRead($entry_id, true);

            echo json_encode([
                'success' => true,
                'message' => 'Successfully added to Karakeep',
                'bookmark_id' => $karakeep_response['id'] ?? null
            ]);

        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function createKarakeepBookmark($karakeep_url, $api_token, $url, $title)
    {
        // Normalize Karakeep URL
        $karakeep_url = rtrim($karakeep_url, '/');
        $api_endpoint = $karakeep_url . '/api/v1/bookmarks';

        $data = [
            'type' => 'link',
            'url' => $url,
            'title' => $title,
            'archived' => false,
            'favourited' => false
        ];

        return $this->callKarakeepAPI($api_endpoint, $data, $api_token);
    }

    private function callKarakeepAPI($url, $data, $api_token)
    {
        $json_data = json_encode($data);
        
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $json_data,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $api_token,
                'Content-Type: application/json',
                'Content-Length: ' . strlen($json_data)
            ],
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_error($ch)) {
            curl_close($ch);
            throw new Exception('CURL Error: ' . curl_error($ch));
        }
        
        curl_close($ch);

        $result = json_decode($response, true);
        
        if ($http_code !== 200 && $http_code !== 201) {
            $error_message = $result['message'] ?? "HTTP {$http_code}";
            throw new Exception("Karakeep API Error: {$error_message}");
        }

        return $result;
    }
}
