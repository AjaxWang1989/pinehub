<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2018/4/17
 * Time: 下午4:12
 */

namespace App\Console\Commands;

use Barryvdh\Reflection\DocBlock;
use Barryvdh\Reflection\DocBlock\Serializer;

class DocBlockSerializer extends Serializer
{
    public function getDocComment(DocBlock $docblock)
    {
        $indent = str_repeat($this->indentString, $this->indent);
        $firstIndent = $this->isFirstLineIndented ? $indent : '';

        $text = $docblock->getText();
        if ($this->lineLength) {
            //3 === strlen(' * ')
            $wrapLength = $this->lineLength - strlen($indent) - 3;
            $text = wordwrap($text, $wrapLength);
        }
        $text = str_replace("\n", "\n{$indent} * ", $text);

        $comment = "{$firstIndent}/**\n{$indent} * {$text}\n{$indent} *\n";

        /** @var Tag $tag */
        $tags = [];
        foreach ($docblock->getTags() as $tag) {
            $tagText = (string) $tag;
            if ($this->lineLength) {
                $tagText = wordwrap($tagText, $wrapLength);
            }
            $tagText = str_replace("\n", "\n{$indent} * ", $tagText);
            if(isset($tags[$tagText])){
                continue;
            }
            $tags[$tagText] = true;
            $comment .= "{$indent} * {$tagText}\n";
        }

        $comment .= $indent . ' */';

        return $comment;
    }
}