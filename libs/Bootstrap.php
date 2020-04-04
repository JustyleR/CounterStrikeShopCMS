<?php
/*
	Bootstrap Library
	The core file for the pages
*/

if (!defined('file_access')) {
    header('Location: ' . url . ' home');
}

// Check the link file
function Bootstrap() {
    if (isset($_GET['p'])) {
		// Get the pages into an array
        $page = explode('/', $_GET['p']);
		
        if (isset($page[0])) {
			// Check if we can include the file without any folders
			if (file_exists('controllers/' . $page[0] . '.php')) {
				checkFile($page, 'controllers/' . $page[0] . '.php', 'default');
			} else {
				// Check if we can include the file within a folder
				$folder = str_replace('!', '', $page[0]);
				if (isset($page[1])) {
					if (file_exists('controllers/' . $folder . '/' . $page[1] . '.php')) {
						// Check if the folder is called admin and if it is then check if the user has the admin session defined
						if ($folder === 'admin') {
							if (!isset($_SESSION['admin_logged'])) {
								core_header('home');
							}
						}
						checkFile($page, 'controllers/' . $folder . '/' . $page[1] . '.php', 'default_folder');
					} else {
						core_header('home');
					}
				} else {
					core_header('home');
				}
			}
        } else {
            core_header('home');
        }
    } else {
        core_header('home');
    }
}

// Check the link file content
function checkFile($page, $dir, $type) {
	
	// Include the file
    require($dir);
	
	// Check if the main function exists
    if (function_exists('main_info') && (function_exists('main'))) {
		$conn 		= connect();
        $main_info	= main_info();
        $countp   	= count($page);
        if ($type	=== 'default_folder') {
            $page	= array_slice($page, 1, $countp);
        }
        $countp = count($page);
        $array  = array();
		
        for ($i = 0; $i < $countp; $i++) {
            if ($main_info[$i] == $page[$i]) {
                $status = 1;
            } else {
                if ($main_info[$i] == '{EVERYTHING}') {
                    $status = 1;
                } else {
                    if ($main_info[$i] == '{NUMBER}') {
                        if (is_numeric($page[$i])) {
                            $status = 1;
                        } else {
                            $status = 0;
                        }
                    } else {
                        if ($main_info[$i] == '{STRING}') {
                            if (is_numeric($page[$i])) {
                                $status = 0;
                            } else {
                                $status = 1;
                            }
                        } else {
                            $status = 0;
                        }
                    }
                }
            }
            $array[] = $status;
        }

        if (count($page) == (count($main_info))) {
            if (count(array_unique($array)) === 1) {
				checkUser($conn);
                main($conn);
            } else {
                core_header('home');
            }
        } else {
            core_header('home');
        }
    } else {
        if ($page[0] === 'home') {
            template_error($conn, language('errors', 'HOME_WITHOUT_MAIN_FUNCTION"'), 1);
        } else {
            core_header('home');
        }
    }
}
