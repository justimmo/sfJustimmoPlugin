<?php

/**
 * The function replaces the size parameter in a URL which requests an image.
 *
 * @param string $url Default picture URL
 * @param string $size New size to fetch (as specified in the file manager configuration of Justimmo)
 * @return string
 */
function api_pic_url_replace($url, $size = 'small')
{
    return preg_replace("!/pic/(\w+)\/!", "/pic/" . $size . "/", $url);
}

function first_paragraph($text)
{
    $start = strpos($text, "<p>");
    $end   = strpos($text, '</p>', $start);

    return substr($text, $start, $end - $start + 4);
}

function description_text($text)
{
    return strip_tags(
        html_entity_decode($text),
        '<p><a><ul><li><ol><b><i><em><sup><br><h3><h4><h5><h6>'
    );
}

function text($text)
{
    return strip_tags(
        html_entity_decode($text)
    );
}

/**
 * @param \Justimmo\Model\Realty $realty
 * @return string
 */
function realty_css_classes($realty)
{
    $realty_classes = array(
        'justimmo',
        'realty',
        'realty-' . $realty->getId(),
    );
    if ($realty->getStatus() != '') {
        array_push(
            $realty_classes,
            'realty-' . preg_replace('/\W+/', '', strtolower(strip_tags($realty->getStatus())))
        );
    }

    return implode(' ', $realty_classes);
}

/**
 *
 * @param array $pictures
 * @param int $index
 * @param $size
 * @return string
 */
function realty_picture_url($pictures, $index = 0, $size = 'orig')
{
    $picture_url = '';

    /** @var Justimmo\Model\Attachment $picture */
    if (isset($pictures[$index])) {
        $picture     = $pictures[$index];
        $picture_url = $picture->getUrl($size);
    }

    return $picture_url == '' ? '/images/realty-no-image.jpg' : $picture_url;
}


/**
 * Format "mailto:" with full name and email address (look at the employee partial)
 * @param string $name
 * @param string $email
 * @return string
 */
function format_mailto($name, $email)
{
    if (!empty($name)) {
        return
            "mailto:" .
            str_replace(" ", "%20", $name) .
            "%20" .
            "%3c" . $email . "%3e";
    }
    if (!empty($email)) {
        return
            "mailto:" . $email;
    }

    return '';
}

// function to show a filter summary: Kauf, Miete, Fläche 80 - 120 m², Zimmer 1 - 4, Wohnung, Haus, Salzburg (5020)
