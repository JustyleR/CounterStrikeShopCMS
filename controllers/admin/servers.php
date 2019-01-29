<?php

if (!defined('file_access')) {
    header('Location: home');
}

// Pages function
function main_info() {
    return array('servers', '{STRING}', '{EVERYTHING}');
}

// Main function
function main($conn) {
    $page = core_page();

    if ($page[2] == 'add') {
        $id    = (int) $page[3];
        $check = query($conn, "SELECT id,hostname FROM " . prefix . "serverinfo WHERE id='" . $id . "'");
        if (num_rows($check) > 0) {
            query($conn, "INSERT INTO " . _table('servers') . " (csbans_id,shortname) VALUES ('" . $id . "','server" . $id . "')");

            core_header('!admin/servers/home/');
        } else {
            core_header('!admin/home/');
        }
    } else {
        if ($page[2] == 'remove') {
            $id    = (int) $page[3];
            $check = query($conn, "SELECT csbans_id FROM " . _table('servers') . " WHERE csbans_id='" . $id . "'");
            if (num_rows($check) > 0) {
                query($conn, "DELETE FROM " . _table('servers') . " WHERE csbans_id='" . $id . "'");

                core_header('!admin/servers/home/');
            } else {
                core_header('!admin/home/');
            }
        } else {
            if ($page[2] == 'home') {
                // Load the template
                $template = template($conn, 'admin/servers');
                // Load the default template variables
                $vars = template_vars($conn);

                $vars['servers'] = servers($conn);

                echo $template->render($vars);
            } else {
                core_header('!admin/home');
            }
        }
    }
}

function servers($conn) {
    $amxServers	= db_array($conn, "SELECT id,hostname FROM " . prefix . "serverinfo");
    if ($amxServers != NULL) {
        // Servers which are not added from the amxbans into the SMS System
        $nServers   = array();
        // Servers which are added from the amxbans into the SMS System
        $servers    = array();

        foreach ($amxServers as $server) {
            $checkServer = query($conn, "SELECT csbans_id FROM " . _table('servers') . " WHERE csbans_id='" . $server['id'] . "'");
            if (num_rows($checkServer) == 0) {
                $array['id']       = $server['id'];
                $array['hostname'] = $server['hostname'];
                $nServers[]        = $array;
            } else {
                $array['id']       = $server['id'];
                $array['hostname'] = $server['hostname'];
                $servers[]         = $array;
            }
        }

        return array($nServers, $servers);
    } else {
        return '';
    }
}
