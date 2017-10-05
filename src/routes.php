<?php
$routes = [
    'metadata',
    'getTranslate',//1
    'getLanguagesForTranslate', // 1
    'getLanguagesForSpeak', // 1
    'getSpeak', //1
    'detectLanguage', //1
    'addTranslation', //1
    'getBreakSentences', // 1
    'addTranslateArray', // 1
    'getLanguageNames', //1
    'detectLanguageList', //1
    'addTranslationArray', //
    'getTranslations',
    'getTranslationsArray'
];
foreach($routes as $file) {
    require __DIR__ . '/../src/routes/'.$file.'.php';
}

