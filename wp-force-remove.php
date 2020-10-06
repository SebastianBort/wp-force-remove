<?php 
/*
Plugin Name: Usuń bez kosza
Description: Dodaje opcję "Usuń na zawsze" do masowych działań, umożliwiając kasowanie wpisów bez uprzedniego przenoszenia do kosza.
Version: 1.0.0
Author: Sebastian Bort
*/
 
class WP_Force_Remove {

    public function __construct() { 
            
            add_action('init', [$this, 'on_init']);
    }
    
    public function on_init() { 
            
          $post_types = get_post_types();
          foreach($post_types AS $pt) {
                add_filter('bulk_actions-edit-' . $pt, [$this, 'register_force_remove']);
                add_filter('handle_bulk_actions-edit-' . $pt, [$this,'bulk_handler'], 10, 3);        
          }
    }        
 
    public function register_force_remove($bulk_actions) {
          
          $bulk_actions['force_remove'] = 'Usuń na zawsze';
          return $bulk_actions;
    }
 
    public function bulk_handler($redirect_to, $doaction, $post_ids) {         
        
          if($doaction !== 'force_remove') {
                  return $redirect_to;
          }
          
          foreach($post_ids AS $post_id) {
                  wp_delete_post($post_id, true);
          }
          
          return $redirect_to;
    } 
}      
 
new WP_Force_Remove();

?>