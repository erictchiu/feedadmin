<?php

/**
 * generator uses fof_render_item function from fof-render.php to generate static html files
 */

include_once("../fof-main.php");
include_once('../fof-render.php');


/**
 * Write html by tags
 *
 * @param string The path to write html
 * @param string The template file to use
 * @return null
 */

function write_html_by_tags($path, $template) {
    $tags = fof_get_tags(fof_current_user());
    
    if ($tags) {
        
        $index = 0;
        foreach($tags as $tag) {
            $tag_name = $tag['tag_name'];

            $result = fof_get_items(fof_current_user(), $_GET['feed'], $tag_name, $_GET['when'], $which, $_GET['howmany'], $order, $_GET['search']);
            
            $server_name = $_SERVER['SERVER_NAME'];
            $address = "http://$server_name/generator/generator.php?tag_name=$tag_name";

            foreach($result as $row) {

                $sourcepage = $address;
                                
                $targetfilename = "../html/$tag_name.html";
                $tempfilename = "../html/$tag_name.tmp";                
                
                
                $handle = fopen($sourcepage, "rb");
                $contents = '';
                while (!feof($handle)) {
                    $contents .= fread($handle, 8192);
                }
                fclose($handle);

                $tempfile = fopen($tempfilename, 'w');
                fwrite($tempfile, $contents);

                copy($tempfilename, $targetfilename); 
                unlink($tempfilename);
 
            }
            
            $index++;
        }
        echo "<strong>Html files generated!</strong>";
    }
}

if (!isset($_GET['tag_name'])) {
    write_html_by_tags("", "");
} else {
    include("header.php");
    
    $result = fof_get_items(fof_current_user(), $_GET['feed'], $_GET['tag_name'], $_GET['when'], $which, $_GET['howmany'], $order, $_GET['search']);
    foreach($result as $row) {
        fof_render_item($row);
    }
    
    include("footer.php");
}

?>