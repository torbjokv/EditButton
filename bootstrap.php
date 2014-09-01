<?php

if($app->module("auth")->getUser() && $app->module("auth")->hasaccess("Regions", ['create.regions', 'edit.regions'])) {

    $regionRenderer = $this->module("regions")->__get('render');

    $this->module("regions")->extend([
        "render" => function($name, $params = []) use($regionRenderer, $app) {
            $region = $app->db->findOne("common/regions", ["name"=>$name]);
            $output = $regionRenderer($name, $params);
            $path = dirname(__FILE__);
            $cockpitFolder = explode('/',$path)[sizeof(explode('/',$path))-4];
            $regionId = $region['_id'];
            $output .= $app->renderer->file(
                $path."/views/edit_button.php", 
                compact(
                    'cockpitFolder', 
                    'regionId'
                    )
                );
            
            return $output;
        }
    ]);
}
