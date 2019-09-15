<?php

class view
{
    private static $view_number = 0;

    public static function set_view($n){
        self::$view_number = intval($n);
    }

    public static function p1(){
        switch(self::$view_number){
            case 0:
                return "";
            break;
            case 1:
                $return = "<script>".file_get_contents("js/convnet-min.js")."</script>";
                $return .= '<script>'.file_get_contents("js/Chart.js").'</script>';
                $return .= file_get_contents("views/_ai_fun_demo1.php");
                return $return;
            break;
            default:
                return "";
            break;
        }
    }

    public static function p2(){
        switch(self::$view_number){
            case 0:
                return file_get_contents("views/landing.php");
            break;
            case 1:
                return file_get_contents("views/center1.php");
            break;
            case 3:
                return file_get_contents("views/hiring.php");
            break;
            default:
                return "";
            break;
        }
    }

    public static function p3(){
        switch(self::$view_number){
            case 0:
                return "";
            break;
            case 1:
                return file_get_contents("views/_ai_fun_demo2.php");
            break;
            default:
                return "";
            break;
        }
    }

}

?>
