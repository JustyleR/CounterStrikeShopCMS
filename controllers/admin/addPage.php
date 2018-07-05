<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('addPage', '{STRING}');
}

// Main function
function main() {
	// Pages
    $page = core_page();

	// Check if its defined preview
    if ($page[2] != NULL) {
        $string	= core_POSTP($page[2]);
		if($string === 'preview') {
			template('admin/pageView');
		} else {
			core_header('!admin/addPage');
		}
        
    } else {
		// Include the template file
        template('admin/addPage');
    }
}

function pages() {
    if(isset($_POST['add'])) {
		
		$title = core_POSTP($_POST['pageTitle']);
		$text = bbcode_save(core_POSTP($_POST['pageText']));
		$page_name = core_POSTP($_POST['pageLink_name']);
		$pageLink = core_POSTP($_POST['pageLink']);
		$access = core_POSTP($_POST['access']);
		
		if(empty($title) || (empty($text)) || (empty($page_name)) || (empty($pageLink)) || (empty($access))) {
			
			core_message_set('addPage', language('messages', 'FILL_THE_FIELDS'));
			
		} else {
			
			$checkPage = query("SELECT link_name FROM pages WHERE link_name='$page_name'");
			if(num_rows($checkPage) > 0) {
				core_message_set('addPage', language('messages', 'PAGE_LINK_NAME_EXISTS'));
			} else {
				$checkLink = query("SELECT link_page FROM pages WHERE link_page='$pageLink'");
				if(num_rows($checkLink) > 0) {
					core_message_set('addPage', language('messages', 'PAGE_LINK_EXISTS'));
				} else {
					query("INSERT INTO pages (title,text,link_name,link_page,logged) VALUES ('$title','$text','$page_name','$pageLink','$access')");
					
					core_message_set('addPage', language('messages', 'SUCCESSFULLY_CREATED_PAGE'));
				}
			}
			
		}
		
	}
	if(isset($_POST['preview'])) {
		
		$text = core_POSTP($_POST['pageText']);
		$title = core_POSTP($_POST['pageTitle']);
		$_SESSION['preview_text'] = $text;
		$_SESSION['preview_title'] = $title;
		$_SESSION['preview_link'] = '!admin/addPage/preview';
		
		core_header('!admin/addPage/preview');
		
	}
	if(isset($_POST['clearPreview'])) {
		
		unset($_SESSION['preview_text']);
		unset($_SESSION['preview_title']);
		core_header('!admin/addPage/');
	}
}
