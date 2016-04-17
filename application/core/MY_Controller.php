<?php

/**
 * core/MY_Controller.php
 *
 * Default application controller
 *
 * @author		JLP
 * @copyright           2010-2015, James L. Parry
 * ------------------------------------------------------------------------
 */
class Application extends CI_Controller {

    protected $data = array();      // parameters for view components
    protected $id;                  // identifier for our content

    /**
     * Constructor.
     * Establish view parameters & load common helpers
     */

    function __construct() {
        parent::__construct();
        
        $this->data = array();
        $this->data['title'] = '?';
        $this->errors = array();
        $this->data['pageTitle'] = '??';
        $this->load->library('session');

        

    }
    function register() {
            $this->load->model('Agent');

            $url = 'botcards.jlparry.com/status';
            //open connection
            $status = curl_init();
            //set the url, number of POST vars, POST data
            curl_setopt($status,CURLOPT_URL,$url);
            curl_setopt($status, CURLOPT_RETURNTRANSFER, true);
            //execute post
            $result = curl_exec($status);
            $status_xml = new SimpleXMLElement($result);

            if((!$this->Agent->checkround($status_xml->round))AND($status_xml->state == 2 or $status_xml->state == 3)){
              
              echo "Add";
              
              echo $status_xml->state;
              
            
            $this->load->model('Transaction');
            $this->load->library('session');
            $fields_string = '';
            $reg_url = 'botcards.jlparry.com/register';
            $fields = array(
                  'team'=>urlencode('B07'),
                  'name'=>urlencode('MJAM'),
                  'password'=>urlencode('tuesday')
            );
            $this->Transaction->delete_trans();
            $this->Transaction->delete_collection();
            //url-ify the data for the POST
            foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
            rtrim($fields_string,'&');

            //open connection
            $ch = curl_init();

            //set the url, number of POST vars, POST data
            curl_setopt($ch,CURLOPT_URL,$reg_url);
            curl_setopt($ch,CURLOPT_POST,count($fields));
            curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            //execute post
            $result = curl_exec($ch);
            
            //echo $result;
            curl_close($ch);
            $xml = new SimpleXMLElement($result);
            foreach ($xml->token as $element) {
            $this->session->set_userdata('token', (string)$element);
            $this->Agent->addround($status_xml->round, (string)$element);
            $this->Transaction->delete_trans();
            $this->Transaction->delete_collection();
            $this->Agent->resetPeanuts();
            
          }

      }
    }
    /**
     * Render this page
     */
    function render() {
        $this->data['menubar'] = $this->parser->parse('_menubar', $this->config->item('menu_choices'),true);
        $this->data['content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);

        // finally, build the browser page!
        $this->data['data'] = &$this->data;

        $user[] = $this->session->userdata('username');
            if( $user[0]=='None' or !isset($user[0])){
                 
                 $this->parser->parse('_template', $this->data);
            }
            else{
                $this->parser->parse('_template1', $this->data);
           
      }
        
    }

}
