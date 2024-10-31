<?php
/*
Plugin Name: O RLY Comment Spam Search
Plugin URI: http://www.jasonmorrison.net/content/o-rly-comment-spam-search-wordpress-plugin/
Description: Creates a quick link to make sure comments aren't spam
Version: 1.0
Author: Jason Morrison
Author URI: http://www.jasonmorrison.net
*/

/*  Copyright 2009  Jason Morrison  (http://www.jasonmorrison.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


// Add filters for moderation emails and admin links:
add_filter ( 'comment_moderation_text', 'o_rly_create_link');
add_filter ( 'comment_row_actions', 'o_rly_create_action', 5, 2);


function o_rly_get_string($content) {
  // This still might break in some cases, improve: 
  if (strlen($content) > 40) {
    $stop_pos = strpos($content, ' ', 40);
  } else {
    $stop_pos = strlen($content);
  }
  $search_string = trim(substr(strip_tags($content), 0, $stop_pos));
  $search_string = str_replace("'", " ", $search_string);

  return $search_string;

}

function o_rly_create_link($content) {
  
  $search_string = o_rly_get_string($content);
  $link = '<a href=\'http://www.google.com/search?q="'.$search_string.'"&safe=off&filter=0\' target=\'_blank\'>O RLY?</a>';
  $content.=$link;

  return $content;

}

function o_rly_create_action($actions, $comment) {
  
  $search_string = o_rly_get_string($comment->comment_content);
  $search_url = 'http://www.google.com/search?q="'.$search_string.'"&safe=off&filter=0\'';
  //example:
  //$actions['delete'] = "<a href='$delete_url' class='delete:the-comment-list:comment-$comment->comment_ID delete vim-d vim-destructive'>" . __('Delete') . '</a>';
  $actions['o-rly'] = "<a href='$search_url' class='delete:the-comment-list:comment-$comment->comment_ID::spam=1 vim-s vim-destructive' title='Check for comment on other sites' target='_blank'>O RLY?</a>";
  
  return $actions;
  
}



?>