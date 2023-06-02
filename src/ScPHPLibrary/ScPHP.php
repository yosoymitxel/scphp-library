<?php

namespace ScPHPLibrary;

class ScPHP{
    public function __construct()
    {
        
    }

    /*
    Librería SC PHP
    Fecha de inicio: 3/08/2020
    
    Lista de categorías:
    
    DEV     = Debug
    DOM     = Manejo de DOM - HTML
    URL     = Manejo de Urls
    SQL     = Manejo de SQL
    JS      = Opciones de JS
    STR     = Manejo de string
    FEC     = Manejo de fechas
    ARR     = Manejo de Arrays
    IS      = Tipo de variable
    
    */
    
    
    /*###DEV###*/
    
    public static function dev_var_dump($obj,$etiqueta='',$id='',$class='',$style=''){
            echo (!ScPHP::dom_etiqueta_inicio($etiqueta)) ?
                "<pre id='$id' class='$class' style='$style'>" :
                "<$etiqueta id='$id' class='$class' style='$style'>";
            var_dump($obj);
            echo (!ScPHP::dom_etiqueta_inicio($etiqueta)) ? '</pre>' : "</$etiqueta>";
            ScPHP::dom_etiqueta_fin($etiqueta);
    }
    
    public static function dev_echo($t,$valor='',$etiqueta='p',$id='',$class='',$style='',$name=''){
            $valor = ($valor!='') ?  ' : '.$valor: '';
            echo("<$etiqueta id='$id' class='$class' style='$style' name='$name'>$t$valor</$etiqueta>");
    }
    
    public static function dev_activar_depurar_global($condicion){
        ini_set('display_errors',$condicion);
        ini_set('display_startup_errors',$condicion);
        error_reporting(E_ALL);
    }
    
    public static function dev_echo_indice($titulo,$texto,$etiqueta='p',$id='',$class='',$style='',$name=''){
        $texto = "$titulo : $texto";
        ScPHP::dom_crear_elemento($etiqueta,$texto,$id,$class,$style,$name);
    }
    
    public static function dev_contador_texto_para_pruebas($texto='Prueba',$valor = false) {
        static $index = 0;
        
        if($valor===0){
            $index = 0;
        }
    
        $index++;
        echo "<p id='".ScPHP::str_sin_caracteres_especiales($texto)."-$index' class='m-0 p-0 w-100'>$texto: $index</p>";
    }
    
    public static function dev_echo_oculto($texto,$depurar=false,$id='id-oculto',$clase=''){
        echo "<div style='display: none;' class='$clase' id='$id'>";
        
        if ($depurar){
            ScPHP::dev_var_dump($texto);
        }else{
            echo "<p>$texto</p>";
        }
    
        echo '</div>';
    }
    
    public static function dev_depurar($condicion,$obj,$id='id-depuracion'){
        if($condicion){
            ScPHP::dom_etiqueta_inicio('div',"debug-$id",'w-100');
            ScPHP::dom_crear_elemento('h3',$id,"debug-$id");
            
            if(ScPHP::is_array($obj,1)){
                $i = 0;
                
                foreach ($obj as $value){
                    ScPHP::dev_var_dump($value,null,"var-dump__$id-".++$i);
                }
            }else{
                ScPHP::dev_var_dump($obj,"var-dump__$id");
            }
    
            ScPHP::dom_etiqueta_fin('div');
        }
    }
    
    public static function dev_obj_a_bool($obj,$depurar=false){
        ScPHP::dev_depurar($depurar,$obj,'ScPHP::dev_obj_a_bool');
        return !(!$obj);
    }
    
    /*###DOM###*/
    
    public static function dom_get_atributos($arrayAtributos,$depurar=false){
        if(ScPHP::is_array($arrayAtributos)){
            $atributos = '';
            
            ScPHP::dev_depurar(
                $depurar,
                array(
                    $arrayAtributos
                ),
                'ScPHP::dom_get_atributos'
            );
    
            foreach ($arrayAtributos as $atributo => $valor){
                if($depurar){
                    ScPHP::dev_var_dump($atributo.' : '.$valor,'p');
                }
    
                $atributos .= ($valor)? $atributo.'="'.$valor.'", ' : '';
            }
    
            $atributos = implode(' ',(explode(',',$atributos)));
            
            return $atributos;
        }
    
        return false;
    }
    
    public static function dom_crear_elemento($etiqueta,$contenido,$depurar=false,$id='',$class='',$style='',$name=''){
        if(ScPHP::is_string($etiqueta,1)){
            $atributos = array('id'=>$id,'class'=>$class,'style'=>$style,'name'=>$name);
            $elemento  = "<$etiqueta ".ScPHP::dom_get_atributos($atributos,$depurar);
            echo $elemento.">$contenido</$etiqueta>";
            return true;
        }
    
        return false;
    }
    
    public static function dom_crear_elemento_sin_cerrar($etiqueta,$depurar=false,$value='',$id='',$class='',$style='',$name='',$type='',$src='',$alt=''){
        if(ScPHP::is_string($etiqueta,1)){
            $atributos = array('id'=>$id,'class'=>$class,'style'=>$style,'name'=>$name,'value'=>$value,'type'=>$type,'src'=>$src,'alt'=>$alt);
            $elemento  = "<$etiqueta ".ScPHP::dom_get_atributos($atributos,$depurar);
            echo $elemento.">";
            return true;
        }
    
        return false;
    }
    
    public static function dom_crear_elemento_personalizado($etiqueta,$contenido,$arrayTipoAtributos,$arrayValorAtributos,$etiquetaCerrada=true,$depurar=false){
        ScPHP::dev_depurar($depurar,
            array('etiqueta'=>$etiqueta,
                'Contenido'          =>$contenido,
                'arrayTipoAtributos' =>$arrayTipoAtributos,
                'arrayValorAtributos'=>$arrayValorAtributos,
                'cerradoAbierto'     =>$etiquetaCerrada
            ),'ScPHP::dom_crear_elemento_personalizado');
    
        $arrayTemp = array_combine($arrayTipoAtributos,$arrayValorAtributos);
        $atributos = ScPHP::dom_get_atributos($arrayTemp);
        echo "<$etiqueta $atributos>$contenido";
       
        if($etiquetaCerrada){
            echo "</$etiqueta>";
        }
    }
    
    public static function dom_crear_elemento_input($type='text',$value='',$id='',$name='',$class='',$style=''){
        $name = (isset($name{1}))?$name:$id;
        ScPHP::dom_crear_elemento_sin_cerrar('input',false,$value,$id,$class,$style,$name,$type);
    }
    
    public static function dom_etiqueta_inicio($etiqueta='',$id='',$class='',$style='',$name=''){
        if(isset($etiqueta{1})){
            $atributos = array('id'=>$id,'class'=>$class,'style'=>$style,'name'=>$name);
            $elemento  = "<$etiqueta ";
          
            foreach ($atributos as $atributo => $valor){
                $elemento .= ($atributo)? $atributo.'="'.$valor.'" ' : '';
            }
    
            echo $elemento.">";
    
            return true;
        }
    
        return false;
    }
    
    public static function dom_etiqueta_fin($etiqueta){
        if(isset($etiqueta[1])){
            echo "</$etiqueta>";
            return true;
        }
    
        return false;
    }
    
    public static function dom_cdn($id,$link,$tipo='css',$depurar=false){
        ScPHP::dev_depurar($depurar,array($id,$link,$tipo),'ScPHP::dom_cdn');
        
        switch ($tipo){
            case 'js':
            case 'javascript':
            case 'script':
                ScPHP::dom_crear_elemento_personalizado('script',null,array('id','src'),array($id,$link));
                break;
            case 'css':
            default:
                ScPHP::dom_crear_elemento_personalizado('link',null,array('id','rel','href'),array($id,'stylesheet',$link),false);
                break;
        }
    }
    
    public static function dom_generar_tabla($arrayContenido, $arrayTitulos = [], $id = '', $class='' ){
            if(ScPHP::is_array($arrayContenido)){
                $tableHtml = "<table id='$id' class='$class'>";
    
                if(ScPHP::arr_contiene_keys($arrayContenido) && !$arrayTitulos){
                    $arrayTitulos = array_keys($arrayContenido);
                }
    
                if(!$arrayTitulos){
                    $tableHtml .= '<thead>
                                    <th>';
    
                    foreach($arrayTitulos as $value){
                        $tableHtml .= "<td>$value</td>";
                    }
    
                    $tableHtml .= '</th>
                                </thead>';
                }
    
                $tableHtml .= '<tbody>';
    
                foreach($arrayContenido as $value){
                    if(ScPHP::is_array($value)){
                        $tableHtml .= '<tr>';
    
                        foreach( $value as $row){
                            $tableHtml .= "<td>$row</td>";
                        }
    
                        $tableHtml .= '</tr>';
    
                    }else{
                        $tableHtml .= "<tr><td>$value</td></tr>";
                    }
                }
    
                $tableHtml .= '</tbody>
                            </table>';
            }
    
            return false;
    }
    
    
    /*###URL###*/
    
    public static function url_informacion_sitio_actual(){
        $indicesServer = array('PHP_SELF',
            'argv',
            'argc',
            'GATEWAY_INTERFACE',
            'SERVER_ADDR',
            'SERVER_NAME',
            'SERVER_SOFTWARE',
            'SERVER_PROTOCOL',
            'REQUEST_METHOD',
            'REQUEST_TIME',
            'REQUEST_TIME_FLOAT',
            'QUERY_STRING',
            'DOCUMENT_ROOT',
            'HTTP_ACCEPT',
            'HTTP_ACCEPT_CHARSET',
            'HTTP_ACCEPT_ENCODING',
            'HTTP_ACCEPT_LANGUAGE',
            'HTTP_CONNECTION',
            'HTTP_HOST',
            'HTTP_REFERER',
            'HTTP_USER_AGENT',
            'HTTPS',
            'REMOTE_ADDR',
            'REMOTE_HOST',
            'REMOTE_PORT',
            'REMOTE_USER',
            'REDIRECT_REMOTE_USER',
            'SCRIPT_FILENAME',
            'SERVER_ADMIN',
            'SERVER_PORT',
            'SERVER_SIGNATURE',
            'PATH_TRANSLATED',
            'SCRIPT_NAME',
            'REQUEST_URI',
            'PHP_AUTH_DIGEST',
            'PHP_AUTH_USER',
            'PHP_AUTH_PW',
            'AUTH_TYPE',
            'PATH_INFO',
            'ORIG_PATH_INFO') ;
    
        echo '<table cellpadding="10">' ;
      
        foreach ($indicesServer as $arg) {
            if (isset($_SERVER[$arg])) {
                echo '<tr><td>'.$arg.'</td><td>' . $_SERVER[$arg] . '</td></tr>' ;
            }
            else {
                echo '<tr><td>'.$arg.'</td><td>-</td></tr>' ;
            }
        }
    
        echo '</table>' ;
    }
    
    public static function url_get_url_actual(){
        return $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    }
    
    public static function url_get_ip_remoto(){
        return $_SERVER['REMOTE_ADDR'];
    }
    
    public static function url_direcciones(){
        return $_SERVER['PHP_SELF'];
    }
    
    public static function url_metodo_get(){
        return $_SERVER['HTTP_GET_VARS'];
    }
    
    public static function url_metodo_post(){
        return $_SERVER['HTTP_POST_VARS'];
    }
    
    public static function url_metodo_cookies(){
        return $_SERVER['HTTP_COOKIE_VARS'];
    }
    
    public static function url_get_servidor($url){
        $url = explode('.',$url);
    
        if(ScPHP::str_existe_en_string($url[0],'www')){
            $urlProcesada = $url[1];
        }else{
            $urlProcesada = str_replace('https://','',$url[0]);
            $urlProcesada = str_replace('http://','',$urlProcesada);
        }
    
        return $urlProcesada;
    }
    
    public static function url_borrar_cookies($depurar=false){
        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
           
            foreach($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name  = trim($parts[0]);
                setcookie($name, '', time()-1000);
                setcookie($name, '', time()-1000, '/');
            }
        }
    }
    
    public static function url_get_youtube_title($video_id){
        $url = "http://www.youtube.com/watch?v=".$video_id;
        $str = file_get_contents($url);
        
        if(strlen($str)>0){
            $str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks inside <title>
            preg_match("/\<title\>(.*)\<\/title\>/i",$str,$title); // ignore case
          
            return ScPHP::str_reemplazar_expresion_regular($title[1],'/( \- YouTube)/','');
        }
    }
    
    public static function url_get_id_youtube($urlYoutube){
        $expresionUrl     = ScPHP::str_corregir_expresion_regular('(https?:\/\/)?(www\.)?(youtube\.com\/watch\?v=(\w+|\-)+|youtu\.be\/(\w+|\-)+)');
        $expresionIdVideo = ScPHP::str_corregir_expresion_regular('(((\?v=)[\w\-]+)|be\/\w+)');
       
        return (ScPHP::str_incluye_expresion_regular($urlYoutube,$expresionUrl)) ?
            substr(ScPHP::str_extraer_expresion_regular($urlYoutube, $expresionIdVideo),3) :
            false;
    }
    
    public static function url_generar_iframe_youtube($link,$return=false,$altura='30vh',$ancho='100%',$class="pt-2",$depurar=false){
        ScPHP::dev_depurar($depurar,array($link,$altura,$ancho),'ScPHP::url_generar_iframe_youtube');
        $enlace = ScPHP::url_get_id_youtube(ScPHP::str_quitar_espacios_blancos($link));
       
        if($enlace){
            $altura = ScPHP::str_incluye_expresion_regular($altura,'\d+(\%|px|vh|vmin|vw)')?($altura):($altura.'px');
            $ancho   = ScPHP::str_incluye_expresion_regular($ancho  ,'\d+(\%|px|vh|vmin|vw)')?($ancho)  :  ($ancho.'px');
            $iframe = '
                <div id="contenedor-iframe-yt-'.$enlace.'" class="'.$class.'">
                    <iframe id="iframe-yt-'.$enlace.'" style="width:'.$ancho.'; height:'.$altura.';" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen 
                        src="https://www.youtube.com/embed/'.$enlace.'">
                    </iframe>
                </div>
            ';
          
            if ($return){
                return $iframe;
            }
    
            echo $iframe;
            return true;
        }else{
            return false;
        }
    }
    
    public static function url_descargar_imagen_al_servidor($url,$serverURl , $direccionCarpeta='assets/archivos/logos'){
        $url = (ScPHP::str_inicia_con($url,'http://') || ScPHP::str_inicia_con($url,'https://'))?
            $url :
            'http://'.$url ;
        $url = parse_url($url)['host'];
        $nombreImagen = (ScPHP::str_inicia_con($url,'www.'))?
            $url :
            'www.'.$url ;
        $nombreImagen = urlencode($nombreImagen);
        //ScPHP::dev_echo_indice($url,$direccionCarpeta);
        //ScPHP::dev_var_dump(is_file(SERVERURL . "$direccionCarpeta/$nombreImagen"));
    
        if (!is_file($serverURl . "$direccionCarpeta/$nombreImagen")) {
            //abrimos un fichero donde guardar la descarga de la web
            $fp = fopen("$direccionCarpeta/$nombreImagen.png", "w");
    
            if($fp){
                // Se crea un manejador CURL
                $ch=curl_init();
    
                // Se establece la URL y algunas opciones
                curl_setopt($ch, CURLOPT_URL, "https://www.google.com/s2/favicons?domain=$url");
                //determina donde guardar el fichero
                curl_setopt($ch, CURLOPT_FILE, $fp);
    
                // Se obtiene la URL indicada
                curl_exec($ch);
    
                // Se cierra el recurso CURL y se liberan los recursos del sistema
                curl_close($ch);
    
                //se cierra el manejador de ficheros
                fclose($fp);
                return true;
            }
    
        }
        return false;
    }
    
    //Falta corrección
    public static function url_buscar_imagenes_google($busqueda){
        $img_pattern = '/<img[^>]+>/i';
        
        if ($busqueda != '') {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://www.google.com.ar/search?q=".urlencode($busqueda.' -vertical -portada')."&source=lnms&tbm=isch&sa=X");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            //Execute the session, returning the results to $curlout, and close.
            $curlout = curl_exec($ch);
            curl_close($ch);
            preg_match_all($img_pattern, $curlout, $img_tags);
        }
    
        return $img_tags;
    }
    
    public static function url_str_a_url_amigable($t){
        $caracteresInvalidos = explode(',', ".,\,,(,),[,],{,},!,¡,.,?,#,',\",`");
        $letrasInvalidos     = explode(',', "á,é,í,ó,ú,Á,É,Í,Ó,Ú");
        $letrasValidas       = explode(',', "a,e,i,o,u,a,e,i,o,u");
        $conservar           = '0-9a-z\s\-'; // juego de caracteres a conservar
        $regex               = sprintf('~[^%s]++~i', $conservar); // case insensitive
        
        foreach ($caracteresInvalidos as $caracter) {
            $t = str_replace($caracter, "", $t);
        }
    
        for($i = 0, $iMax = sizeof($letrasInvalidos); $i < $iMax; $i++) {
            $t = str_replace($letrasInvalidos[$i], $letrasValidas[$i], $t);
        }
    
        $t = preg_replace($regex, '', $t);
        $t = trim($t);
        $t = strtolower(preg_replace('/\s+/','-', $t));
    
        return $t;
    }
    
    public static function url_redirect($url, $statusCode = 303){
       header('Location: ' . $url, true, $statusCode);
       die();
    }
    
    
    /*###SQL###*/
    
    public static function sql_conexion($host, $bbdd, $user, $pass, $puerto = '3306', $opcionesPDO = [], $driver='mysql'){
        try {
            $dsn = "$driver:host=$host;dbname=$bbdd;port=$puerto";
            $dbh = new PDO($dsn, $user, $pass, $opcionesPDO);
            
            $dbh->setAttribute(PDO::ATTRR_ERRMODE, PDO::ERRMODE_SILENT);
            $dbh->setAttribute(PDO::ATTRR_ERRMODE, PDO::ERRMODE_WARNING);
            $dbh->setAttribute(PDO::ATTRR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            return $dbh;
    
        } catch (PDOException $e){
            echo $e->getMessage();
        }
        
    }
    
    public static function sql_select($conexion, $sql, $parametros = [], $tipoPDOFech = PDO::FETCH_ASSOC, $depurar = false){
        $query = $conexion->prepare($sql);
       
        try {
            $sqlResult = $query->execute($parametros);
    
            if ($sqlResult) {
                $sqlResult = $query->fetchAll($tipoPDOFech);
                $sqlResult = count($sqlResult) > 0 ? $sqlResult : false;
    
            }else{
                $sqlResult = false;
            }
    
            if ($depurar){
                ScPHP::dev_echo('Debug de ScPHP::sql_secure_lookup (4):');
                ScPHP::dev_var_dump($sql);
                ScPHP::dev_var_dump($parametros);
                ScPHP::dev_var_dump($tipoPDOFech);
                ScPHP::dev_var_dump($sqlResult);
            }
    
            return $sqlResult;
    
        } catch (Exception $e) {
            ScPHP::dev_var_dump('Hubo un error: ');
            ScPHP::dev_var_dump($e);
            return false;
        }
    }
    
    public static function sql_execute($conexion, $sql, $parametros = null, $depurar = false){
        $query = $conexion->prepare($sql);
    
        try {
            $execResult = $query->execute($parametros);
    
            if ($depurar){
                ScPHP::dev_echo('Debug de ScPHP::sql_secure_lookup (4):');
                ScPHP::dev_var_dump($sql);
                ScPHP::dev_var_dump($parametros);
                ScPHP::dev_var_dump($execResult);
            }
    
            return !!( $execResult );
    
        } catch (Exception $e) {
            ScPHP::dev_var_dump('Hubo un error: ');
            ScPHP::dev_var_dump($e);
            return false;
        }
    
    }
    
    //Falta corregir
    public static function sql_lookup($sql){
        global $pdoLibreria;
        $query = $pdoLibreria->prepare($sql);
    
        try {
            $sqlResult = $query->execute(array());
    
            if ($sqlResult) {
                $sqlResult = $query->fetchAll(PDO::FETCH_ASSOC);
                return $sqlResult;
            }else{
                return false;
            }
        } catch (Exception $e) {
            return '<p class="alert-danger">No funcionó</p>';
        }
    }
    
    public static function sql_secure_lookup($sql,$array=null,$depurar=false){
        global $pdoLibreria;
        $query     = $pdoLibreria->prepare($sql);
        $sqlResult = false;
    
        try {
            $sqlResult = $query->execute($array);
    
            if ($sqlResult) {
                $sqlResult = $query->fetchAll(PDO::FETCH_ASSOC);
                $query = null;
    
                if ($depurar){
                    ScPHP::dev_echo('Debug de ScPHP::sql_secure_lookup (3):');
                    ScPHP::dev_var_dump($sql);
                    ScPHP::dev_var_dump($array);
                    ScPHP::dev_var_dump($sqlResult);
                }
    
                if (count($sqlResult)==0){
                    foreach ($array as &$valor){
                        $valor = htmlentities($valor);
                    }
                }
    
                return count($sqlResult) != 0 ? $sqlResult:false;
            }else{
                return $datos[0][0] = false;
            }
        } catch (Exception $e) {
            ScPHP::dev_var_dump('Hubo un error: ');
            ScPHP::dev_var_dump($e);
            return false;
        }
    }
    
    public static function sql_exec_sql($sql,$array=null){
        global $pdoLibreria;
        $query = $pdoLibreria->prepare($sql);
    
        foreach ( $array as &$valor){
            $valor = (is_string($valor)) ? nl2br( htmlentities($valor) ) : $valor;
        }
    
        try {
            return $query->execute($array);
        } catch (Exception $exception) {
            echo $exception;
            return false;
        }
    }
    
    
    /*###JS###*/
    
    public static function js_alert($texto){
        echo "<script>alert('" . $texto . "' );</script>";
    }
    
    public static function js_console_log($texto){
        echo "<script>console.log('" . $texto . "' );</script>";
    }
    
    
    /*###STR###*/
    
    public static function str_existe_en_string($texto,$busqueda,$depurar=false){
        ScPHP::dev_depurar($depurar,$texto,'ScPHP::str_existe_en_string');
        return (strpos($texto,$busqueda) !== false);
    }
    
    public static function str_quitar_espacios_y_lower($texto,$depurar=false){
        ScPHP::dev_depurar($depurar,$texto,'ScPHP::str_existe_en_string');
        return strtolower(preg_replace('/(\n|\r|\t|\s)/','',$texto));
    }
    
    public static function str_resaltar_texto($t,$busqueda,$class=null){
        return (isset($t{1}) && isset($busqueda{1}))?str_replace($busqueda,"<b class='$class'>$busqueda</b>",$t):false;
    }
    
    public static function str_generar_enlaces_html_de_string($texto,$depurar=false){
        ScPHP::dev_depurar($depurar,
            array(
                $texto,
                preg_replace(
                    '#((https?|ftp)://(\S*?\.\S*?))([\s)\[\]{},;"\':<]|\.\s|$)#i',
                    "<a href=\"$1\" target=\"_blank\">$3</a>$4",
                    $texto
                )
            ),
            'ScPHP::str_generar_enlaces_html_de_string');
        $texto = ScPHP::str_reemplazar_expresion_regular($texto,'&amp;','&');
      
        return preg_replace(
            '#((https?|ftp)://(\S*?\.\S*?))([\s)\[\]{},;"\':<]|\.\s|$)#i',
            "<a href=\"$1\" target=\"_blank\">$3</a>$4",
            $texto
        );
    }
    
    public static function str_reemplazar_expresion_regular($t,$expresion,$reemplazo,$depurar=false){
        $expresion = ScPHP::str_corregir_expresion_regular($expresion);
        ScPHP::dev_depurar($depurar,"t : $t expresion : $expresion reemplazo : $reemplazo ",'ScPHP::str_reemplazar_expresion_regular');
      
        return preg_replace(
            $expresion,
            $reemplazo,
            $t
        );
    }
    
    public static function str_incluye_expresion_regular($t,$expresion,$depurar=false){
        $expresion = ScPHP::str_corregir_expresion_regular($expresion);
        ScPHP::dev_depurar($depurar,array($t,$expresion),'ScPHP::str_incluye_expresion_regular');
       
        return preg_match($expresion,$t);
    }
    
    public static function str_corregir_expresion_regular($expresion,$depurar=false){
        ScPHP::dev_depurar($depurar,array($expresion),'ScPHP::str_corregir_expresion_regular');
      
        return (ScPHP::str_inicia_con($expresion,'/') && ScPHP::str_finaliza_con($expresion,'/')) ?
            $expresion :
            '/'.$expresion.'/';
    }
    
    public static function str_extraer_expresion_regular($t,$expresion,$depurar=false){
        ScPHP::dev_depurar($depurar,array($t,$expresion),'ScPHP::str_extraer_expresion_regular');
        $expresion     = ScPHP::str_corregir_expresion_regular($expresion);
        $coincidencias = false;
    
        if(ScPHP::str_incluye_expresion_regular($t,$expresion)){
            preg_match_all($expresion,$t,$coincidencias,PREG_OFFSET_CAPTURE);
            $arrayResutl = array();
    
            for ($i=0,$iMax=count($coincidencias[0]);$i<$iMax;$i++ ){
                $valor=$coincidencias[0];
                for ($j=0 ;$j<$iMax;$j++){
                    $arrayResutl[$j] = ($valor[$j][0]);
                }
            }
    
            $coincidencias = count($arrayResutl)>1? $arrayResutl : $arrayResutl[0];
        }
    
        return $coincidencias;
    }
    
    public static function str_inicia_con($t,$busqueda,$depurar=false){
        ScPHP::dev_depurar($depurar,$t,'ScPHP::str_inicia_con');
        return (strpos($t, $busqueda) === 0);
    }
    
    public static function str_finaliza_con($t,$busqueda,$depurar=false){
        ScPHP::dev_depurar($depurar,$t,'ScPHP::str_finaliza_con');
        $cantidadCaracteres = strlen ($busqueda);
        
        return ($cantidadCaracteres && substr($t, -$cantidadCaracteres) == $busqueda);
    }
    
    public static function str_contiene($t,$busqueda,$depurar=false){
        return ScPHP::str_existe_en_string($t,$busqueda,$depurar);
    }
    
    public static function str_quitar_espacios_extra($t,$depurar=false){
        ScPHP::dev_depurar($depurar,$t,'ScPHP::str_quitar_espacios_extra');
        return trim(ScPHP::str_reemplazar_expresion_regular($t,'/(\n|\s)+/',' '));
    }
    
    public static function str_quitar_espacios_blancos($t,$depurar=false){
        ScPHP::dev_depurar($depurar,$t,'ScPHP::str_quitar_espacios_blancos');
        return trim(ScPHP::str_reemplazar_expresion_regular($t,'(\n|\s|\t|\r)+',''));
    }
    
    public static function str_sin_caracteres_especiales($texto,$quitarTodos=true){
        if(isset($texto{1})){
            //Aquí añades las letras que no quieres que se usen
            $vocalesNoPermitidas    = array('á','é','í','ó','ú','ñ');
            $vocalesNoPermitidasMay = array('Á','É','Í','Ó','Ú','Ñ');
    
            //Aquí añades las letras que quieres que se usen
            $vocalesPermitidas      = array('a','e','i','o','u','ni');
    
            //Aquí añades los caracteres que no quieres que se usen
            $caracteresNoPermitidos = array('?','\"','\'');
    
            $texto = strtolower($texto);
    
            for($i=0, $iMax = count($vocalesNoPermitidas); $i< $iMax; $i++){
                $texto = str_replace($vocalesNoPermitidas   [$i], $vocalesPermitidas[$i], $texto);
                $texto = str_replace($vocalesNoPermitidasMay[$i], $vocalesPermitidas[$i], $texto);
            }
    
            for($i=0, $iMax = count($caracteresNoPermitidos); $i< $iMax; $i++){
                $texto = str_replace($caracteresNoPermitidos[$i], '_', $texto);
            }
    
            //Esta parte reemplaza los espacios en blanco " " y los guiones "-" por guiones bajos "_"
            $texto = ScPHP::str_reemplazar_expresion_regular($texto,'(\s+|\-+|_+)+',"_");
    
            if($quitarTodos){
                $texto = ScPHP::str_reemplazar_expresion_regular($texto,'\W','');
                $texto = ScPHP::str_reemplazar_expresion_regular($texto,'(\s+|\-+|_+)+',"_");
            }
        }
        return $texto;
    }
    
    public static function str_to_oracion($t,$depurar=false){
        ScPHP::dev_depurar($depurar,$t,'ScPHP::str_to_oracion');
        return ScPHP::is_string($t,1) && strtolower($t) === $t ? ucfirst($t) : $t;
    }
    
    
    /*###FEC###*/
    
    public static function fec_formatear($fecha,$formato='Y-m-d H:i:s',$depurar=false){
        ScPHP::dev_depurar($depurar,array($fecha,$formato),'ScPHP::fec_formatear');
        return date($formato, strtotime($fecha));
    }
    
    
    /*###ARR###*/
    
    public static function arr_incluye_expresion_regular($array,$expresion,$depurar=false){
        ScPHP::dev_depurar($depurar,array($array,$expresion),'ScPHP::arr_incluye_expresion_regular');
    
        if (is_array($array) && isset($expresion{1})){
            $expresion = ScPHP::str_corregir_expresion_regular($expresion);
           
            foreach ($array as $valor){
                if (ScPHP::str_incluye_expresion_regular($valor,$expresion)){
                    return true;
                }
            }
        }
    
        return false;
    }
    
    public static function arr_to_json($arr,$arrayKeys=null,$depurar=false){
        ScPHP::dev_depurar($depurar,array($arr,$arrayKeys),'ScPHP::arr_poner_keys');
      
        if(ScPHP::is_array($arr,1)){
            if(!ScPHP::arr_contiene_keys($arr) && ScPHP::arr_contiene_keys($arr) ){
                $lista = '';
    
                foreach ($arr as $valor){
                    $lista .= json_encode($valor).' , ';
    
                }
    
                return '['.substr($lista,0,-3).']';
            }
    
            if(ScPHP::is_array($arrayKeys,1) && !ScPHP::arr_contiene_keys($arr)){
                $arr = ScPHP::arr_poner_keys($arrayKeys,$arr);
            }
    
            return json_encode($arr);
        }
    
        return false;
    }
    
    public static function arr_contiene_keys($arr,$depurar=false){
        ScPHP::dev_depurar($depurar,$arr,'ScPHP::arr_contiene_keys');
        $arr = array_keys($arr);
        
        return (int) preg_grep('/(\D)+/g',$arr);
    }
    
    public static function arr_poner_keys($arrayKeys,$arr,$depurar=false){
        ScPHP::dev_depurar($depurar,array($arrayKeys,$arr),'ScPHP::arr_poner_keys');
        
        if (ScPHP::is_array($arrayKeys) && ScPHP::is_array($arr)){
            return array_combine($arrayKeys, $arr);
        }
    
        return false;
    }
    
    public static function arr_unir($arr1,$arr2,$depurar=false){
        ScPHP::dev_depurar($depurar,array($arr1,$arr2),'ScPHP::arr_unir');
        
        if (ScPHP::is_array($arr1,1) && ScPHP::is_array($arr2,1) ){
            return array_merge($arr1, $arr2);
        }
    
        return false;
    }
    
    /*###IS###*/
    public static function is_string($t,$longitud=0,$depurar=false){
        ScPHP::dev_depurar(
            $depurar,
            array(
                $t,
                $longitud,
                ( is_string($t) && isset($t{$longitud}) )
            ),
            'ScPHP::is_string'
        );
        $longitud = ($longitud!=0) ? $longitud-1 : $longitud;
        
        return is_string($t) && isset($t{$longitud});
    }
    
    public static function is_url($url,$depurar=false){
        ScPHP::dev_depurar($depurar,$url,'ScPHP::is_url');
        
        if (ScPHP::is_string($url,3)){
            return filter_var($url,FILTER_VALIDATE_URL);
        }
    
        return false;
    }
    
    public static function is_array($array,$count=0,$depurar=false){
        ScPHP::dev_depurar($depurar,array($array,$count),'ScPHP::is_array');
        return is_array($array) &&  count($array) >= $count;
    }
    
    public static function is_bool($obj,$depurar=false){
        ScPHP::dev_depurar($depurar,$obj,'ScPHP::is_bool');
        return is_bool($obj);
    }
    
    public static function is_int($num,$tamanio=false){
        $tamanio = is_numeric($tamanio) ? $num >= $tamanio : true;
        return is_int($num) && ($tamanio);
    }
    
    public static function is_numeric($num,$tamanio=false){
        $tamanio = is_numeric($tamanio) ? $num >= $tamanio : true;
        return is_numeric($num) && ($tamanio);
    }
    public static function is_float($num,$tamanio=false){
        $tamanio = is_numeric($tamanio) ? $num >= $tamanio : true;
        return is_float($num) && ($tamanio);
    }
    
}