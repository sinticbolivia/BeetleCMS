<?php
SB_Language::loadLanguage(LANGUAGE, 'newsletter', dirname(__FILE__) . SB_DS . 'locale');
SB_Module::RunSQL('newsletter');
