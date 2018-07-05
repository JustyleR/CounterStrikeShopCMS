<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('editPage', '{NUMBER}', '{STRING}');
}

// Main function
function main() {
	$page = core_page();
	if ($page[3] != NULL) {
        $string	= core_POSTP($page[3]);
		if($string === 'preview') {
			template('admin/pageView');
		} else {
			core_header('!admin/editPage/' . $page[2] . '/');
		}
        
    } else {
		// Include the template file
        template('admin/editPage');
    }
}

function editPage() {
	if(isset($_POST['edit'])) {
		$title = core_POSTP($_POST['pageTitle']);
		$text = bbcode_save(core_POSTP($_POST['pageText']));
		$page_name = core_POSTP($_POST['pageLink_name']);
		$pageLink = core_POSTP($_POST['pageLink']);
		$access = core_POSTP($_POST['access']);
		
		if(empty($title) || (empty($text)) || (empty($page_name)) || (empty($pageLink))) {
			
			core_message_set('editPage', language('messages', 'FILL_THE_FIELDS'));
			
		} else {
			
			$checkPage = query("SELECT link_name FROM pages WHERE link_name='$page_name' AND page_id <> ". core_page()[2] ."");
			if(num_rows($checkPage) > 0) {
				core_message_set('editPage', language('messages', 'PAGE_LINK_NAME_EXISTS'));
			} else {
				$checkLink = query("SELECT link_page FROM pages WHERE link_page='$pageLink' AND page_id <> ". core_page()[2] ."");
				if(num_rows($checkLink) > 0) {
					core_message_set('editPage', language('messages', 'PAGE_LINK_EXISTS'));
				} else {
					query("UPDATE pages SET title='$title', text='$text', link_name='$page_name', link_page='$pageLink', logged='$access' WHERE page_id='". core_page()[2] ."'");
					
					core_message_set('editPage', language('messages', 'SUCCESSFULLY_EDITED_PAGE'));
				}
			}
			
		}
	}
	
	if(isset($_POST['preview'])) {
		$text = core_POSTP($_POST['pageText']);
		$title = core_POSTP($_POST['pageTitle']);
		$_SESSION['preview_text'] = $text;
		$_SESSION['preview_title'] = $title;
		$_SESSION['preview_link'] = '!admin/editPage/' . core_page()[2] . '/';
		
		core_header('!admin/addPage/preview');
		
	}
	
	if(isset($_POST['clearPreview'])) {
		unset($_SESSION['preview_text']);
		unset($_SESSION['preview_title']);
		core_header('!admin/editPage/' . core_page()[2] . '/');
	}
}