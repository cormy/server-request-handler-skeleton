<?php
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ fileInfos ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
$fileInfos = new RecursiveIteratorIterator(
    new RecursiveCallbackFilterIterator(
        new RecursiveDirectoryIterator('.'),
        function ($fileInfo) {
            return !in_array($fileInfo->getFilename(), [
                '.',
                '..',
                'composer.lock',
                '.git',
                'vendor',
            ]);
        }
    )
);

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ template  ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
$template = [
    '{{vendor}}' => 'cormy',
    '{{project_name}}' => basename(__DIR__),
    '{{package}}' => '{{vendor}}/{{project_name}}',
    '{{namespace}}' => 'Cormy\Server\RequestHandler',
    '{{description}}' => 'Cormy {{class_name}} request handler',
    '{{create_description}}' => 'Create a Cormy {{class_name}}',
    '{{user_name}}' => trim(`git config user.name` ?: `whoami`),
    '{{user_email}}' => trim(`git config user.email`),
    '{{year}}' => date('Y'),
    '{{sensio_labs_insight}}' => '[![SensioLabsInsight]({{sensio_labs_insight_url}}/big.png)]({{sensio_labs_insight_url}})',
    '{{sensio_labs_insight_url}}' => 'https://insight.sensiolabs.com/projects/{{your_project_id}}',
    '{{travis}}' => '[![Build Status]({{travis_url}}.svg?branch=master)]({{travis_url}})',
    '{{travis_url}}' => 'https://travis-ci.org/{{vendor}}/{{project_name}}',
    '{{coveralls}}' => '[![Coverage Status](https://coveralls.io/repos/{{vendor}}/{{project_name}}/badge.svg?branch=master&service=github)](https://coveralls.io/github/{{vendor}}/{{project_name}}?branch=master)',
    '{{scrutinizer}}' => '[![Scrutinizer Code Quality]({{scrutinizer_url}}/badges/quality-score.png?b=master)]({{scrutinizer_url}}/?branch=master)',
    '{{scrutinizer_url}}' => 'https://scrutinizer-ci.com/g/{{vendor}}/{{project_name}}',
];
$template['{{class_name}}'] = str_replace('-', '', ucwords($template['{{project_name}}'], '-'));
$template['{{user_url}}'] = $template['{{user_email}}'] === 'michael@schnittstabil.de' ? 'schnittstabil.de' : '';
$template['{{user_link}}'] = empty($template['{{user_url}}']) ? '{{user_name}}' : '[{{user_name}}](http://{{user_url}})';

function applyTemplate(string $content):string {
    global $template;

    do {
        $old = $content;
        foreach ($template as $key => $value) {
            $content = str_replace($key, $value, $content);
        }
    } while ($content !== $old);

    return $content;
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~ apply template ~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
foreach ($fileInfos as $fileInfo) {
    $newContent = applyTemplate(file_get_contents($fileInfo));
    file_put_contents($fileInfo, $newContent);
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~ edit composer ~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
$composer = json_decode(file_get_contents('composer.json'));

unset($composer->scripts->{'post-create-project-cmd'});

$composer->name = applyTemplate('{{package}}');
$composer->description = applyTemplate('{{description}}');
$composer->keywords = array_values(array_diff($composer->keywords, ['skeleton', 'template']));
$composer->type = 'library';
$composer->authors[0]->name = applyTemplate('{{user_name}}');
$composer->authors[0]->email = applyTemplate('{{user_email}}');

file_put_contents('composer.json', json_encode($composer, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE).PHP_EOL);

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ rename files ~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
foreach ([
    '.gitattributes.mustache' => '.gitattributes',
    'license.mustache' => 'license',
    'readme.mustache.md' => 'readme.md',
] as $from => $to) {
    unlink($to);
    rename($from, $to);
}

foreach ($fileInfos as $fileInfo) {
    $newPath = applyTemplate((string) $fileInfo);
    if ($newPath !== (string) $fileInfo) {
        rename($fileInfo, $newPath);
    }
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ clean up ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
unlink(__FILE__);
