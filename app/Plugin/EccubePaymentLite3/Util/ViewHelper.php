<?php

namespace Plugin\EccubePaymentLite3\Util;

class ViewHelper
{
    /**
     * Insert Js
     *
     * @param $source
     * @param $insertSource
     * @return string
     */
    static public function insertJs($source, $insertSource)
    {
        return ViewHelper::insert($source, $insertSource, '{% block javascript %}', '{% endblock javascript %}');
    }

    /**
     * Insert Css
     *
     * @param $source
     * @param $insertSource
     * @return string
     */
    static public function insertCss($source, $insertSource)
    {
        return ViewHelper::insert($source, $insertSource, '{% block stylesheet %}', '{% endblock stylesheet %}');
    }

    /**
     * Insert Modal
     *
     * @param $source
     * @param $insertSource
     * @return string
     */
    static public function insertModal($source, $insertSource)
    {
        return ViewHelper::insert($source, $insertSource, '{% block modal %}', '{% endblock modal %}');
    }

    /**
     * Insert Snippet
     *
     * @param $source
     * @param $insertSource
     * @return string
     */
    static public function insertSnippet($source, $insertSource)
    {
        return ViewHelper::insert($source, $insertSource, '{% block main %}', '{% endblock %}');
    }

    /**
     * Insert Source
     *
     * @param $source
     * @param $insertSource
     * @param $startBlockTag
     * @param $endBlockTag
     * @return string
     */
    static public function insert($source, $insertSource, $startBlockTag, $endBlockTag)
    {
        if (strpos($source, $startBlockTag) !== false) {
            $startPos = strpos($source, $startBlockTag) + strlen($startBlockTag);
            $prefixSource = substr($source, 0, $startPos);
            $suffixSource = substr($source, $startPos);

            return $prefixSource . $insertSource . $suffixSource;
        } else {
            $insertSource = PHP_EOL . $startBlockTag . PHP_EOL . $insertSource . PHP_EOL . $endBlockTag;

            return $source . $insertSource;
        }
    }
}
