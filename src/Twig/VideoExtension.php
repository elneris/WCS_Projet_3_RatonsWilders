<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 09/07/19
 * Time: 17:38
 */

namespace App\Twig;

use RicardoFiorani\Matcher\VideoServiceMatcher;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class VideoExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('embed', [$this, 'getEmbed']),
        ];
    }

    public function getEmbed(string $url)
    {
        $videoMatcher = new VideoServiceMatcher();
        $video = $videoMatcher->parse($url);

        if (!$video->isEmbeddable()) {
            throw new \Exception('Video not available to display');
        }

        return $video->getEmbedCode(200, 200);
    }
}
