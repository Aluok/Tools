<?php
namespace SSS\AccueilBundle\Divers;
class XML
{
    private $routes;
    private $parser;

    public function __construct(){
        $this->routes = array();
        $this->parser=xml_parser_create();
        xml_set_element_handler($this->parser, Array($this, "start"), Array($this, "stop"));
    }
    public function decrypt_routing_file($path){

        //Open XML file
        $fp=fopen($path,"r");
        $data = file_get_contents($path);

        //Read data
        xml_parse($this->parser,$data,feof($fp)) or
            die (sprintf("XML Error: %s at line %d", xml_error_string(xml_get_error_code($this->parser)),
                xml_get_current_line_number($this->parser)));

        //Free the XML parser
        xml_parser_free($this->parser);
        $routes = $this->routes;
        $this->routes = array();
        return $routes;
    }
    //Function to use at the start of an element
    private function start($parser,$element_name,$element_attrs) {
        $array = array();
        if($element_name == "IMPORT" && isset($element_attrs['PREFIX'])){
            if(substr($element_attrs['RESOURCE'], 0, 4) === '@SSS'){
                if(preg_match('#.php#', $_SERVER['REQUEST_URI']) == false){
                    $code = 'index.php';
                }else{
                    $code = '.php';
                }
                $lien ='http://'.$_SERVER['SERVER_NAME'].split('.php',$_SERVER['REQUEST_URI'])[0].$code;
                if(!preg_match("#/$#", $lien)){
                    $lien .= '/';
                }
                $lien .= substr($element_attrs['PREFIX'], 1);
                array_push($this->routes, array('nom' => preg_replace('#^@SSS(\w+)Bundle.+$#', '$1', $element_attrs['RESOURCE']),
                                                'lien' => $lien,
                                          ));
            }
        }
    }
    //Function to use at the end of an element
    private function stop($parser,$element_name) {
    }
}
