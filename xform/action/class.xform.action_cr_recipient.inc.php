<?php

/**
 * XForm
 * @author jan.kristinus[at]redaxo[dot]org Jan Kristinus
 * @author <a href="http://www.yakamara.de">www.yakamara.de</a>
 */

class rex_xform_action_cr_recipient extends rex_xform_action_abstract
{

    function execute()
    //function executeAction()
    {

        global $REX, $I18N;
        $I18N->appendFile($REX['INCLUDE_PATH'] . "/addons/lus_cleverreach/lang/");

        $apikey = $REX['ADDON']['lus_cleverreach']['settings']['apikey'];
        $groupid = $REX['ADDON']['lus_cleverreach']['settings']['groupid'];
        $formid = $REX['ADDON']['lus_cleverreach']['settings']['formid'];
        $source = $REX['ADDON']['lus_cleverreach']['settings']['source'];
        $privacy = $REX['ADDON']['lus_cleverreach']['settings']['privacy'];
        $privacyitem = $REX['ADDON']['lus_cleverreach']['settings']['privacyitem'];
        $infotext = $REX['ADDON']['lus_cleverreach']['settings']['infotext'];


        $error = false;
        $errormsg = '';
        // get post data

        foreach ($this->params['value_pool']['sql'] as $key => $value) {
            if ($this->getElement(2) == $key) {
                $email = $this->params['value_pool']['sql'][$key];
                break;
            }
        }

        $action = $this->getElement(3);
        if ( $action != '0' && $action != '1' ) {
            foreach ($this->params['value_pool']['sql'] as $key => $value) {
                if ($action == $key) {
                    $action = $value;
                    break;
                }
            }
        }

        if ($this->getElement(4) != '') {
            $fields = explode( ',',$this->getElement(4));
            $attributes = array();
            foreach ($this->params['value_pool']['sql'] as $key => $value) {
                if (in_array($key, $fields)) {
                    $attributes[] = array('key'=>$key, 'value'=>$value);
                }
            }
        }

        if (!empty($email) && !empty($apikey) && !empty($groupid) && !empty($formid) && !$error) {

            // create Cleverreach API object
            $api = new CleverreachAPI($apikey);

            // define groupid
            $api->setGroupid($groupid);

            // define fromid
            $api->setFormid($formid);
            $errormsg = $I18N->msg('lus_cleverreach_api_failure');

            if ($action == "1") {
                // add resipient
                $result = $api->addRecipient($email, $source, $attributes);
            } elseif ($action == "0" ) {
                // remove resipient
                $result = $api->removeRecipient($email);
            } else {
                $errormsg = $I18N->msg('lus_cleverreach_add_remove');
            }

            if ($result->status === 'SUCCESS') {
                //$errormsg = $I18N->msg('lus_cleverreach_api_success');
            } else {
                $error = true;
                if ($result->message != '') { $errormsg .= ': '. $result->message; }
            }
        } elseif (!empty($email) && !$error) {
            $error == true;
            $errormsg = $I18N->msg('lus_cleverreach_config_failure');
        }

        if ( $error == true ) {
            $this->params['form_show'] = true;
            $this->params['hasWarnings'] = true;
            $this->params['warning_messages'][] = $errormsg;
            return false;
        }


    }

    function getDescription()
    {
        return 'action|cr_recipient|emailfield|0/1/actionfield|anrede,titel,vorname,nachname,firma :the list of fields to send as user profile';
    }

}
