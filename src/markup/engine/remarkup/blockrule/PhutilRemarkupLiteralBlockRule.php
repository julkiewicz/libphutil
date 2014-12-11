<?php

final class PhutilRemarkupLiteralBlockRule extends PhutilRemarkupBlockRule {

  public function getMatchingLineCount(array $lines, $cursor) {
    $num_lines = 0;
    if (preg_match('/^\s*%%%/', $lines[$cursor])) {
      $num_lines++;

      while (isset($lines[$cursor])) {
        if (!preg_match('/%%%\s*$/', $lines[$cursor])) {
          $num_lines++;
          $cursor++;
          continue;
        }
        break;
      }

      $cursor++;

      while (isset($lines[$cursor])) {
        if (!strlen(trim($lines[$cursor]))) {
          $num_lines++;
          $cursor++;
          continue;
        }
        break;
      }

    }

    return $num_lines;
  }

  public function markupText($text, $children) {
    $text = preg_replace('/^\s*%%%(.*)%%%\s*\z/s', '\1', $text);
    if ($this->getEngine()->isTextMode()) {
      return $text;
    }

    $text = phutil_split_lines($text, $retain_endings = true);
    return phutil_implode_html(phutil_tag('br', array()), $text);
  }

}
