<?php

class KarakeepExtension extends Minz_Extension
{
    protected array $csp_policies = [
        'default-src' => '*',
    ];

    public function init()
    {
        $this->registerHook('entry_before_display', array($this, 'addKarakeepButton'));
        $this->registerController('Karakeep');
        Minz_View::appendStyle($this->getFileUrl('style.css', 'css'));
        Minz_View::appendScript($this->getFileUrl('script.js', 'js'));
    }

    public function addKarakeepButton($entry)
    {
        $url = $entry->link();

        $url_karakeep = Minz_Url::display(array(
            'c' => 'Karakeep',
            'a' => 'addToKarakeep',
            'params' => array(
                'id' => $entry->id()
            )
        ));

        $entry->_content(
            '<div class="karakeep-add-wrap">'
            . '<button data-request="' . $url_karakeep . '" class="karakeep-add-btn">Add to Karakeep</button>'
            . '<div class="karakeep-add-content"></div>'
            . '</div>'
            . $entry->content()
        );
        return $entry;
    }

    public function handleConfigureAction()
    {
        if (Minz_Request::isPost()) {
            FreshRSS_Context::$user_conf->karakeep_url = Minz_Request::param('karakeep_url', '');
            FreshRSS_Context::$user_conf->karakeep_api_token = Minz_Request::param('karakeep_api_token', '');
            
            FreshRSS_Context::$user_conf->save();
        }
    }
}
