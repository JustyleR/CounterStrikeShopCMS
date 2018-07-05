<?php

if (!defined('file_access')) {
    header('Location: ' . url . ' home');
}

function Bootstrap() {
    if (isset($_GET['p'])) {
        $page = explode('/', $_GET['p']);

        if (isset($page[0])) {
            $query = query("SELECT * FROM pages WHERE link_page='". $page[0] ."'");
			if(num_rows($query) > 0) {
				$r = fetch_assoc($query);
				if($r['logged'] == 3) {
					if(!isset($_SESSION['user_logged'])) {
						template('custom_page');
					} else {
						core_header('home');
					}
					
				} else if($r['logged'] == 1) {
					if(isset($_SESSION['user_logged'])) {
						template('custom_page');
					} else {
						core_header('home');
					}
				} else if($r['logged'] == 2) {
					template('custom_page');
				}
			} else {
				// check if we can include the file without any folders
				if (file_exists('controllers/' . $page[0] . '.php')) {
					checkFile($page, 'controllers/' . $page[0] . '.php', 'default');
				} else {
					// check if we can include the file within a folder
					$folder = str_replace('!', '', $page[0]);
					if (isset($page[1])) {
						if (file_exists('controllers/' . $folder . '/' . $page[1] . '.php')) {
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
			}
        } else {
            core_header('home');
        }
    } else {
        core_header('home');
    }
}

function checkFile($page, $dir, $type) {

    require($dir);

    if (function_exists('main_info') && (function_exists('main'))) {
        $main_info = main_info();
        $countp    = count($page);
        if ($type === 'default_folder') {
            $page = array_slice($page, 1, $countp);
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
                main();
            } else {
                core_header('home');
            }
        } else {
            core_header('home');
        }
    } else {
        if ($page[0] === 'home') {
            template_error(language('errors', 'HOME_WITHOUT_MAIN_FUNCTION"'), 1);
        } else {
            core_header('home');
        }
    }
}
